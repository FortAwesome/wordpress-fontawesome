# WordPress 7.0 Readiness Audit — Font Awesome Plugin

**Plugin version audited:** 5.1.5 (`main`)
**Date:** 2026-07-18
**Scope:** Compatibility with WordPress 7.0, with emphasis on the **iframed block editor** and how the plugin's block / rich‑text format behave inside it.
**References:**
- [WordPress 7.0 Field Guide](https://make.wordpress.org/core/2026/05/14/wordpress-7-0-field-guide/)
- [PR #298 — "Add `enqueue_block_assets` to action hooks"](https://github.com/FortAwesome/wordpress-fontawesome/pull/298) (open, unmerged as of this audit)

> **Note on methodology.** This is a **static‑analysis** audit. A dockerized WordPress 7 environment was not available, so none of the findings below have been confirmed by running the plugin in a live WP7 iframed editor. Every item marked **Verify** needs a runtime check once an environment is available. File/line references are to the current `main`.

---

## TL;DR

The plugin is in reasonably good shape for WP7. The block is already `apiVersion: 3`, and the block's own editor assets are already injected into the editor iframe. The remaining work is small and specific:

1. **One concrete cross‑frame bug** in the rich‑text icon UI (`window.getComputedStyle` on an iframe‑owned node). *Code fix required.*
2. **Runtime asset delivery into the iframe** (kit / CDN webfont / v4 shims) is what **PR #298** addresses — needed, but its blanket inclusion of the **conflict detector** should be reconsidered.
3. **A few fragile cross‑window assumptions** (custom‑event bus on the global `document`, a web‑component registry, shared `window` globals) that are *probably* fine but must be verified in the iframe.
4. **Housekeeping**: bump "Tested up to", consider realigning `@wordpress/*` dev deps to `wp-7.0`.

There are **no PHP‑level blockers**: the plugin already requires PHP 7.4 (WP7's new minimum).

---

## Why the iframe matters now

Per the field guide, WP7 **enforces the iframed editor canvas whenever every registered block uses Block API version 3+**. Older (v1/v2) blocks force a fallback to the non‑iframed editor.

This plugin's block is **`apiVersion: 3`** (`block-editor/src/block.json`). That means:

- On a WP7 site where all active blocks are v3, **this block renders inside the iframe**, and every cross‑frame assumption below is exercised for real.
- The plugin has **no way to opt out** and should not try to — v3 is correct. The task is to make the block iframe‑correct.

Inside the iframe, the editor content lives in a **separate document and window** from the surrounding admin page. Any JS that reaches for the *outer* `document`/`window` while operating on an element that lives *inside* the iframe is a latent bug.

---

## What's already correct

These are worth stating explicitly so they aren't "fixed" by mistake:

| Area | Status | Evidence |
|---|---|---|
| Block API version | ✅ v3 — qualifies for the iframe | `block-editor/src/block.json` (`"apiVersion": 3`) |
| Block's **own** editor CSS/JS reach the iframe | ✅ Already handled | `block-editor/font-awesome-icon-block-init.php:91-108` version‑gates to `enqueue_block_assets` on WP 6.3+ *specifically* so styles/scripts land inside the editor content iframe (documented in an inline comment). |
| SVG rendering | ✅ Inline SVG via React; no DOM injection | Icons render through `@fortawesome/react-fontawesome` in the React tree — they render wherever React renders, including the iframe. |
| FA MutationObserver in editor | ✅ Disabled | `block-editor/src/index.js:10-11` sets `config.autoAddCss = false; config.autoReplaceSvg = false`, so FA's own MutationObserver‑driven SVG replacement does **not** run in the editor. |
| PHP minimum | ✅ Meets WP7 | `readme.txt`: `Requires PHP: 7.4` |
| `useAnchor` for the inline popover | ✅ Core, iframe‑aware | `block-editor/src/richTextIcon.js:5,166` — `useAnchor` from `@wordpress/rich-text` handles cross‑iframe popover positioning in core. |
| Not affected by WP7 removals | ✅ N/A | No reliance on `add_theme_support('html5','script')`, CodeMirror, or `contentOnly`/pattern‑override mechanics. The icon block has no InnerBlocks, so `"role": "content"` guidance doesn't apply. |

---

## Findings

### P0 — Cross‑frame `getComputedStyle` bug (code fix required)

**File:** `block-editor/src/richTextIcon.js:171`

```js
const { color, fontSize, backgroundColor } = window.getComputedStyle(contentRef.current)
```

`contentRef.current` is the editable rich‑text element, which **lives inside the iframe** in WP7. `window` here is the **outer admin window** (the module's global). Calling `outerWindow.getComputedStyle()` on an element owned by a *different* document returns empty/incorrect computed values in browsers.

**Impact:** The `context` (`color`, `fontSize`, `backgroundColor`) is passed into `IconModifier` to preview the inline icon against the surrounding text's style (`block-editor/src/iconModifier.js:460-468`). In the iframed editor this preview will be blank/wrong. Functional degradation, not a crash.

**Fix:** resolve the view from the element's own document:

```js
const view = contentRef.current.ownerDocument.defaultView
const { color, fontSize, backgroundColor } = view.getComputedStyle(contentRef.current)
```

*(Same code smell, but iframe‑irrelevant, at `classic-editor/src/index.js:42` — the classic editor is not iframed. Fix for consistency only.)*

---

### P0 — Runtime FA assets in the iframe (this is what PR #298 is for)

**Files:** `includes/class-fontawesome.php` (multiple `add_action` loops)

The block's *own* editorStyle/editorScript already reach the iframe (see "Already correct"). But the **Font Awesome runtime itself** — the kit loader, CDN webfont/SVG CSS, v4 shims — is enqueued only on:

```php
array( 'wp_enqueue_scripts', 'admin_enqueue_scripts', 'login_enqueue_scripts' )
```

**None of these hooks fire inside the editor content iframe.** So the FA runtime is absent from the iframe. Consequences:

- **SVG technology:** mostly OK for *this block*, because icons are inlined by `react-fontawesome` and the SVG **styles** handle is already enqueued into the iframe via `enqueue_block_assets` (`includes/class-fontawesome.php:411-419`). Sizing/animation classes are covered.
- **Webfont technology, kit `<i>` tags, and shortcode output rendered in the editor:** icons will **not** render correctly in the iframe without the runtime present.

**PR #298** adds `'enqueue_block_assets'` to those enqueue loops (kit, CDN webfont, v4 shims, plain enqueue, and the conflict detector). `enqueue_block_assets` **does** fire inside the iframe, so this is the right mechanism.

**Assessment of PR #298:**
- ✅ Correct approach for kit / CDN / v4‑shim delivery into the iframe.
- ⚠️ **`enqueue_block_assets` also fires on the front end**, not just the editor. Adding it to loops that already run on `wp_enqueue_scripts` means a second enqueue on the front end. WordPress dedupes styles/scripts **by handle**, so this is normally harmless — but **verify** no duplicate inline `@font-face`/style injection or double conflict‑detector loads result.
- ⚠️ See P1 below re: the conflict detector.

---

### P1 — Conflict detector should not blanket‑run in the iframe

**File:** `includes/class-fontawesome.php:3160-3170` (the enqueue loop PR #298 also modifies)

The conflict‑detection scanner is currently an **admin/front‑end feature gated by `current_user_can('manage_options')`** and is *not* part of the block bundle. PR #298 adds `enqueue_block_assets` to its enqueue loop, which would cause the detector to **also load and scan inside the editor iframe**, concurrently with the outer admin page.

This is the exact race condition raised in the PR review (mlwilkerson): a scan running inside the iframe and outside at the same time can duplicate work or terminate a scan prematurely.

**Recommendation:** Exclude the conflict detector from the `enqueue_block_assets` change (keep it on the three original hooks), **or** make it explicitly iframe‑aware (detect the iframe context and no‑op, so only one scan runs). The webfont/kit/shim asset changes in PR #298 are independent of this and can proceed.

---

### P1 — Custom‑event bus on the global `document` (verify)

**Dispatch:** `edit.js:153`, `richTextIcon.js:185`, `richTextIcon.js:236`, `iconModifier.js:469` — all `document.dispatchEvent(...)`.
**Listen:** `icon-chooser/src/IconChooserModal.js:20` — `document.addEventListener(openEvent.type, ...)`.
**Event creation:** `block-editor/src/createCustomEvent.js` — `new Event(name, { bubbles: true, cancelable: false })`.

The "open the icon chooser" signal is a custom event on the **module‑global `document`**. Both the block bundle and the icon‑chooser bundle execute in the **outer** admin window, so both `document` references resolve to the **same outer document** — the bridge *should* keep working even though the buttons' DOM is inside the iframe (dispatch target == listener target == the outer `document`; bubbling is irrelevant here).

**But this is implicit and fragile.** If any portion of the icon‑chooser or its listener ends up bound to the iframe's `contentDocument`, dispatch and listen diverge and the modal silently won't open.

- **Verify** in the iframed editor: clicking "Choose Icon" (block placeholder), "Change Icon"/format‑toolbar button (rich text), and the modifier's chooser button all open the modal.
- **Cleanup bug (independent of iframe):** `IconChooserModal.js:20` registers the listener on every render with **no `removeEventListener`** — a listener leak. Wrap in `useEffect` with a cleanup return.

---

### P1 — `FaIconChooser` web component & per‑window custom‑element registry (verify)

**File:** `icon-chooser/src/IconChooserModal.js` (renders `<FaIconChooser>` from `@fortawesome/fa-icon-chooser-react`, a Stencil‑generated **custom element**), instantiated once on the outer window in `icon-chooser/src/index.js:29`.

Custom‑element registries are **per‑window**. The element is defined in the outer window. As long as the `Modal` renders as an **outer‑document portal** (the default for `@wordpress/components` `Modal`), the element upgrades correctly. If a future WP change renders the modal *inside* the iframe, the element won't upgrade there.

**Verify:** the icon chooser modal opens and its search/grid render fully inside the iframed editor.

---

### P2 — Shared `window[GLOBAL_KEY]` state assumes one window (verify)

**File:** `admin/src/constants.js:1` defines `GLOBAL_KEY = '__FontAwesomeOfficialPlugin__'`. It's **set** on the outer window by `icon-chooser/src/index.js:31` and `admin/src/index.js:42`, and **read at module‑eval time** by the block bundle: `edit.js:15` and `richTextIcon.js:25` (`get(window, [GLOBAL_KEY, 'iconChooser'])`).

If the block bundle ever evaluates in a different realm than the one where `iconChooser` was set, `IconChooserModal` is `undefined`. In practice all bundles load in the outer window, so this is expected to hold — but it's the same class of assumption as the event bus. **Verify** together with P1.

---

### P2 — Version metadata & dependency alignment

- **`readme.txt`:** `Tested up to: 6.9` → bump to `7.0` once verified. `Requires at least: 5.8` can remain. `Requires PHP: 7.4` already satisfies WP7's new minimum.
- **`@wordpress/*` dev dependencies** are pinned to **`wp-6.7`** in `block-editor/package.json` and `icon-chooser/package.json`. At runtime these packages are **externalized to the site's `wp.*` / `react` globals** (confirmed by `build/index.asset.php` manifests listing `react`, `wp-element`, `wp-rich-text`, etc.), so the plugin actually runs against **WP7's copies** regardless of the build‑time pin — which is why the iframe behavior takes effect without a rebuild. Still, realign dev deps to `wp-7.0` and rebuild/retest to catch any API drift in `useAnchor`, the rich‑text format `Edit` `contentRef` prop, and `createInterpolateElement` (`admin/src/createInterpolateElement.js` still falls back to the `__experimental*` alias).

### P3 — React version note

The fetched field guide did **not** document a React major bump for WP7 (WP already shipped React 18 in 6.2). The plugin does **not** bundle React (`react`/`react-jsx-runtime` are externals), and `@fortawesome/react-fontawesome ^0.2.2` supports React 18. **If** WP7 advances React (e.g. to 19), verify no Strict‑Mode double‑invoke or ref‑timing regressions in the modal/popover flows. Treat as *verify*, not a known break.

---

## Not applicable / no action

- **HTML5 `script` theme support removal** — plugin doesn't use it.
- **CodeMirror v5 / Espree** — plugin ships no code editor.
- **`contentOnly` patterns / Pattern Overrides / `"role": "content"`** — icon block has no InnerBlocks and isn't a pattern container.
- **New AI Client / Abilities / Connectors / DataViews APIs** — additive; nothing to adopt for compatibility.
- **Front‑end rendering** — the front end is not iframed; SVG/webfont output there is unchanged by WP7.

---

## Priority summary

| # | Priority | Item | Type | Location |
|---|---|---|---|---|
| 1 | **P0** | `getComputedStyle` uses outer window on iframe node | Code fix | `block-editor/src/richTextIcon.js:171` |
| 2 | **P0** | Deliver kit/CDN/webfont/v4‑shim runtime into the iframe | Merge PR #298 (scoped) | `includes/class-fontawesome.php` enqueue loops |
| 3 | **P1** | Conflict detector should not blanket‑run in the iframe | Scope down PR #298 | `includes/class-fontawesome.php:3160-3170` |
| 4 | **P1** | Custom‑event bus works across the iframe boundary | Verify + listener cleanup | dispatch: `edit.js`,`richTextIcon.js`,`iconModifier.js`; listen: `IconChooserModal.js:20` |
| 5 | **P1** | Icon‑chooser web component upgrades inside iframe | Verify | `icon-chooser/src/IconChooserModal.js`, `index.js:29` |
| 6 | **P2** | Shared `window[GLOBAL_KEY]` single‑window assumption | Verify | `edit.js:15`, `richTextIcon.js:25` |
| 7 | **P2** | Bump "Tested up to: 7.0"; realign `@wordpress/*` to `wp-7.0` | Housekeeping | `readme.txt`, `*/package.json` |
| 8 | **P3** | Confirm no React‑major regression | Verify | modal/popover flows |

---

## Runtime verification checklist (once a WP7 docker env is available)

Run on a WP7 site where the editor is iframed (all‑v3‑blocks condition met):

1. Insert the **Font Awesome Icon block**; confirm the placeholder, the chosen icon, sizing, and animations render **inside the iframe** for both **SVG** and **webfont** technologies.
2. Click **"Choose Icon"** → the icon chooser modal opens, searches, and inserts. Repeat for the **rich‑text format** ("Change Icon" toolbar button) and the **icon styling modifier**.
3. Confirm the **rich‑text inline icon preview** reflects the surrounding text color/size (validates the P0 `getComputedStyle` fix).
4. With a **kit** configured, confirm kit `<i>` tags / shortcodes render in the editor iframe (validates PR #298).
5. With **conflict detection** enabled, run a scan from the settings page and confirm it completes without duplicate/aborted scans caused by an in‑iframe copy (validates P1).
6. Check the browser console for cross‑frame errors and confirm no duplicate `@font-face`/inline‑style injection on the **front end** (side effect of `enqueue_block_assets`).
