# WordPress 7.0 Readiness Audit — Font Awesome Plugin

**Plugin version audited:** 5.1.5 (`main`)
**Date:** 2026-07-18
**Revised:** 2026-07-27 — the original P0 `getComputedStyle` finding was **retracted** after browser testing disproved it; see [Investigated and dismissed](#investigated-and-dismissed).
**Revised:** 2026-07-27 (second pass) — the **cross‑frame half** of the custom‑event‑bus finding was also retracted, along with the two other cross‑frame "verify" items that rested on the same assumption. A real defect *was* found and fixed in that same code: an unbounded listener leak. See [P1 — Custom‑event bus](#p1--customevent-bus-on-the-global-document-listener-leak-fixed).
**Scope:** Compatibility with WordPress 7.0, with emphasis on the **iframed block editor** and how the plugin's block / rich‑text format behave inside it.
**References:**
- [WordPress 7.0 Field Guide](https://make.wordpress.org/core/2026/05/14/wordpress-7-0-field-guide/)
- [PR #298 — "Add `enqueue_block_assets` to action hooks"](https://github.com/FortAwesome/wordpress-fontawesome/pull/298) — **merged** as `d27300dd`. See the note under P0 about what it did and did not change.

> **Note on methodology.** This started as a **static‑analysis** audit; a dockerized WordPress 7 environment was not available. Items still marked **Verify** have not been run against WP7. File/line references are to the current `main`.
>
> **Static analysis produced two false positives here.** Both were "outer window touches inner element, therefore cross‑frame bug," and both dissolved once the actual mechanism was checked:
>
> 1. The `getComputedStyle` P0, disproved by reproducing the shape in Chromium, Firefox, and WebKit (see [Investigated and dismissed](#investigated-and-dismissed)).
> 2. The custom‑event‑bus P1, disproved by reading what WP core actually puts inside the iframe (see [below](#p1--customevent-bus-on-the-global-document-listener-leak-fixed)).
>
> That is the standard the remaining cross‑frame items should be held to. The heuristic that generated them has a bad track record in this codebase.

---

## TL;DR

The plugin is in reasonably good shape for WP7. The block is already `apiVersion: 3`, and the block's own editor assets are already injected into the editor iframe. The remaining work is small and specific:

1. **Runtime asset delivery into the iframe** (kit / CDN webfont / v4 shims) was addressed by **PR #298**, now merged. One duplicate‑enqueue side effect still wants confirming.
2. **The "fragile cross‑window assumptions" are not fragile.** None of the plugin's JS can evaluate inside the editor iframe, so the custom‑event bus, the web‑component registry, and the `window[GLOBAL_KEY]` global all resolve in a single realm. See [Investigated and dismissed](#investigated-and-dismissed) for the mechanism.
3. **Housekeeping**: bump "Tested up to", consider realigning `@wordpress/*` dev deps to `wp-7.0`.

**One real code fix came out of this audit, and it was not a WP7 issue.** Chasing the cross‑frame question through the event bus turned up an unbounded listener leak in `IconChooserModal` that had been there all along — fixed, with a regression test. Both cross‑frame findings the audit originally raised (`getComputedStyle`, the event bus) were false positives and have been retracted.

There are **no PHP‑level blockers**: the plugin already requires PHP 7.4 (WP7's new minimum).

---

## Why the iframe matters now

Per the field guide, WP7 **enforces the iframed editor canvas whenever every registered block uses Block API version 3+**. Older (v1/v2) blocks force a fallback to the non‑iframed editor.

This plugin's block is **`apiVersion: 3`** (`block-editor/src/block.json`). That means:

- On a WP7 site where all active blocks are v3, **this block renders inside the iframe**, and every cross‑frame assumption below is exercised for real.
- The plugin has **no way to opt out** and should not try to — v3 is correct. The task is to make the block iframe‑correct.

Inside the iframe, the editor content lives in a **separate document and window** from the surrounding admin page. JS that reaches for the *outer* `document`/`window` while operating on an element that lives *inside* the iframe is worth examining.

**But "outer window touches inner element" is not by itself a bug** — that heuristic produced both false positives retracted below. Whether it breaks depends on two things, and *both* have to go wrong:

1. **Does the API resolve against the receiver's realm, or the element's?** APIs that resolve against **the element's own document** are safe to call from any window; `getComputedStyle` is one of these (verified). APIs that resolve against **the receiver's** document/registry are the ones that *could* break: event dispatch/listen pairs, `customElements` registries, `document.querySelector`, per‑realm globals.
2. **Is there actually more than one realm in play?** A receiver‑resolved API is only a hazard if some of the plugin's code genuinely runs inside the iframe. **None of it does** — see [Investigated and dismissed](#investigated-and-dismissed). WordPress puts *styles* in the iframe, plus whatever `enqueue_block_assets` enqueues; it does not put block `editorScript` bundles there.

The audit's original cross‑frame items all failed test 1 or test 2. Check both before treating a new one as real.

---

## What's already correct

These are worth stating explicitly so they aren't "fixed" by mistake:

| Area | Status | Evidence |
|---|---|---|
| Block API version | ✅ v3 — qualifies for the iframe | `block-editor/src/block.json` (`"apiVersion": 3`) |
| Block's **own** editor CSS reaches the iframe | ✅ Already handled | `block-editor/font-awesome-icon-block-init.php:91-108` version‑gates to `enqueue_block_assets` on WP 6.3+ so the block's `editorStyle` lands inside the editor content iframe. ⚠️ The inline comment there says this loads the assets "inside the editor's content iframe" — true of the **styles**, not the **script**. The bundle is registered on that hook but enqueued as the block's `editorScript`, which WP loads in the outer window only. That distinction is what the [retraction below](#investigated-and-dismissed) turns on; worth correcting the comment so the false positive isn't re‑derived from it. |
| SVG rendering | ✅ Inline SVG via React; no DOM injection | Icons render through `@fortawesome/react-fontawesome` in the React tree — they render wherever React renders, including the iframe. |
| FA MutationObserver in editor | ✅ Disabled | `block-editor/src/index.js:10-11` sets `config.autoAddCss = false; config.autoReplaceSvg = false`, so FA's own MutationObserver‑driven SVG replacement does **not** run in the editor. |
| PHP minimum | ✅ Meets WP7 | `readme.txt`: `Requires PHP: 7.4` |
| `useAnchor` for the inline popover | ✅ Core, iframe‑aware | `block-editor/src/richTextIcon.js:5,166` — `useAnchor` from `@wordpress/rich-text` handles cross‑iframe popover positioning in core. |
| Inline icon preview reads surrounding text style | ✅ Verified in 3 engines | `block-editor/src/richTextIcon.js:179` — `window.getComputedStyle(contentRef.current)` returns the **iframe's** styles correctly. Do **not** "fix" this to use `ownerDocument.defaultView`; see [Investigated and dismissed](#investigated-and-dismissed). |
| Not affected by WP7 removals | ✅ N/A | No reliance on `add_theme_support('html5','script')`, CodeMirror, or `contentOnly`/pattern‑override mechanics. The icon block has no InnerBlocks, so `"role": "content"` guidance doesn't apply. |

---

## Findings

### P0 — Runtime FA assets in the iframe (addressed by PR #298, merged)

**Files:** `includes/class-fontawesome.php` (multiple `add_action` loops)

The block's *own* editorStyle/editorScript already reach the iframe (see "Already correct"). But the **Font Awesome runtime itself** — the kit loader, CDN webfont/SVG CSS, v4 shims — is enqueued only on:

```php
array( 'wp_enqueue_scripts', 'admin_enqueue_scripts', 'login_enqueue_scripts' )
```

**None of these hooks fire inside the editor content iframe.** So the FA runtime is absent from the iframe. Consequences:

- **SVG technology:** mostly OK for *this block*, because icons are inlined by `react-fontawesome` and the SVG **styles** handle is already enqueued into the iframe via `enqueue_block_assets` (`includes/class-fontawesome.php:411-419`). Sizing/animation classes are covered.
- **Webfont technology, kit `<i>` tags, and shortcode output rendered in the editor:** icons will **not** render correctly in the iframe without the runtime present.

**PR #298** (merged as `d27300dd`) adds `'enqueue_block_assets'` to those enqueue loops: kit, CDN webfont, v4 shims, plain enqueue, blocklist removal. `enqueue_block_assets` **does** fire inside the iframe, so this is the right mechanism.

**Assessment of PR #298 as merged:**
- ✅ Correct approach for kit / CDN / v4‑shim delivery into the iframe.
- ✅ **The conflict detector was correctly left out.** Its enqueue loop (`includes/class-fontawesome.php:3164`) still carries only the three original hooks, so the in‑iframe scan race raised in review never shipped. The item that used to appear here as a P1 is resolved — nothing to do.
- ⚠️ **`enqueue_block_assets` also fires on the front end**, not just the editor. Adding it to loops that already run on `wp_enqueue_scripts` means a second enqueue on the front end. WordPress dedupes styles/scripts **by handle**, so this is normally harmless — but see the duplicate‑inline‑style item directly below.

**Verify — duplicated inline styles, with a concrete mechanism.** This was previously stated as a vague "check for duplicate injection"; here is the specific path that would cause it.

`enqueue_font_awesome_block_editor_assets()` (`block-editor/font-awesome-icon-block-init.php:18`) runs on `enqueue_block_assets` and calls `wp_add_inline_style()` on the SVG styles handle. `enqueue_block_assets` fires **twice per editor load**: once for the outer admin page, and once inside `_wp_get_iframed_editor_assets()` (`wp-includes/block-editor.php`) while it collects the iframe's assets.

That collector swaps in a fresh `WP_Styles` but then does:

```php
$wp_styles->registered = $current_wp_styles->registered;
```

PHP copies the array, but the values are `_WP_Dependency` **objects** — shared by reference. So `wp_add_inline_style()` during the iframe pass calls `add_data('after', …)` on the *same* object the outer registry holds, and the rule is appended twice.

Expected impact is cosmetic (an identical CSS rule emitted twice), but it should be **confirmed rather than assumed**, and the same reasoning applies to the `@font-face` override in the v4‑shim loop (`class-fontawesome.php:2126`).

---

### P1 — Custom‑event bus on the global `document` (listener leak — FIXED)

**Dispatch:** `edit.js:153`, `richTextIcon.js:185`, `richTextIcon.js:236`, `iconModifier.js:469` — all `document.dispatchEvent(...)`.
**Listen:** `icon-chooser/src/IconChooserModal.js` — `document.addEventListener(openEvent.type, ...)`.
**Event creation:** `block-editor/src/createCustomEvent.js` — `new Event(name, { bubbles: true, cancelable: false })`.

This finding had two halves. **The cross‑frame half was wrong** and has been moved to [Investigated and dismissed](#investigated-and-dismissed). **The cleanup half was right, and worse than it looked.**

`IconChooserModal` registered its listener **during render**, with no `removeEventListener`. `edit.js:25` compounded it by calling `createCustomEvent()` inline in the component body, minting a **new random event type on every render**. Since the modal subscribes *by type*, `document` gained both a listener and a permanent new entry in its listener map for every render any icon block ever performed — and `Edit` re-renders on every `setAttributes`, so each interaction in the icon styling modal added one.

Nothing ever misbehaved: dispatch always used the same render's event object, `setOpen` is stable across renders, and `setState` on an unmounted component is a no-op in React 18. That is why the browser suite stayed green over it. The cost was pure leak — each retained closure holds `setOpen`, which holds the React fiber, so unmounted choosers stayed reachable.

**Measured in the iframed editor** (Chromium, `bin/dev` env), driving 9 interactions in the styling modal:

| | distinct event types | total registrations |
|---|---|---|
| Before | 11 | 12 |
| After | 1 | 2 |

**Fix applied:**
- `IconChooserModal.js` — subscribe in a `useLayoutEffect` keyed on `openEvent.type`, returning a `removeEventListener` cleanup. `useLayoutEffect` rather than `useEffect` keeps registration inside the same synchronous commit that the old render-time call had, which matters because `classic-editor/src/index.js:102-109` mounts the chooser and then dispatches the open event from a `setTimeout(…, 0)` on the same click. **This is defensive, not a demonstrated fix:** a `useEffect` build was measured passing that first-click check in Chromium, WebKit and Firefox. The layout effect simply removes the dependency on React's passive-effect task beating a `setTimeout(0)`.
- `edit.js:25` — `useMemo(() => createCustomEvent(), [])`, so the event type is per block instance rather than per render. Safe because the `Placeholder` branch and the `IconModifier` branch are mutually exclusive, so a given `Edit` never has two `IconChooserModal`s mounted on one event.
- **Regression test:** `browser-testing/tests-using-mock-fa-api/using-pro-kit/iconChooserListeners.spec.js` patches `Document.prototype.addEventListener`, drives a fixed number of re-renders, and asserts registrations stay bounded instead of tracking render count. It fails against the pre-fix bundles.

**Deliberately not changed:** the two module-scope events in `richTextIcon.js:43,51`. They must stay distinct from each other — the comment at lines 45-51 documents the double-insert bug that separation fixed — and `FormatEdit` is rendered only for the selected `RichText` (`@wordpress/block-editor` `rich-text/index.js:318`), so at most one is mounted at a time.

---

### ~~P1 — Conflict detector should not blanket‑run in the iframe~~ — **resolved before merge**

PR #298 as merged did **not** add `enqueue_block_assets` to the conflict detector's enqueue loop; `includes/class-fontawesome.php:3164` still lists only `wp_enqueue_scripts`, `admin_enqueue_scripts`, `login_enqueue_scripts`. The concurrent in-iframe scan this item warned about cannot happen. Retained here only so the concern isn't re-raised.

---

### P2 — Version metadata & dependency alignment

- **`readme.txt`:** `Tested up to: 6.9` → bump to `7.0` once verified. `Requires at least: 5.8` can remain. `Requires PHP: 7.4` already satisfies WP7's new minimum.
- **`@wordpress/*` dev dependencies** are pinned to **`wp-6.7`** in `block-editor/package.json` and `icon-chooser/package.json`. At runtime these packages are **externalized to the site's `wp.*` / `react` globals** (confirmed by `build/index.asset.php` manifests listing `react`, `wp-element`, `wp-rich-text`, etc.), so the plugin actually runs against **WP7's copies** regardless of the build‑time pin — which is why the iframe behavior takes effect without a rebuild. Still, realign dev deps to `wp-7.0` and rebuild/retest to catch any API drift in `useAnchor`, the rich‑text format `Edit` `contentRef` prop, and `createInterpolateElement` (`admin/src/createInterpolateElement.js` still falls back to the `__experimental*` alias).

### P3 — React version note

The fetched field guide did **not** document a React major bump for WP7 (WP already shipped React 18 in 6.2). The plugin does **not** bundle React (`react`/`react-jsx-runtime` are externals), and `@fortawesome/react-fontawesome ^0.2.2` supports React 18. **If** WP7 advances React (e.g. to 19), verify no Strict‑Mode double‑invoke or ref‑timing regressions in the modal/popover flows. Treat as *verify*, not a known break.

---

## Investigated and dismissed

### ~~P1/P2 — The three "cross‑frame realm" items~~ — **RETRACTED, one realm only**

This covers what were separately filed as: the cross‑frame half of the **custom‑event bus** P1, the **`FaIconChooser` custom‑element registry** P1, and the **`window[GLOBAL_KEY]`** P2. All three reduced to one question — *can any of the plugin's JS evaluate inside the editor iframe?* — and the answer is no.

**What WordPress actually puts in the iframe.** `_wp_get_iframed_editor_assets()` (`wp-includes/block-editor.php`) builds the iframe's `<head>`. It:

1. sets `should_load_block_editor_scripts_and_styles` to `__return_false`,
2. fires `do_action('enqueue_block_assets')`,
3. and then, walking every registered block type, enqueues **only `editor_style_handles`**.

Block **`editorScript`** handles are never enqueued into the iframe.

**What that means for this plugin.** The plugin's `enqueue_block_assets` callback, `enqueue_font_awesome_block_editor_assets()` (`block-editor/font-awesome-icon-block-init.php:18`), only calls `wp_register_script`/`wp_register_style` — it registers, it does not enqueue. The block bundle reaches the page solely as the block's `editorScript` (`block.json`: `"editorScript": "font-awesome-block-editor"`), i.e. **outer window only**. `RESOURCE_HANDLE_ICON_CHOOSER` is a declared dependency of that handle, so the icon‑chooser bundle is outer‑window only for the same reason.

So there is exactly one realm holding plugin JS, and consequently:

- **Event bus** — `document.dispatchEvent` in the block bundle and `document.addEventListener` in the icon‑chooser bundle are the same `document`. The buttons' *DOM* lives in the iframe, but their React handlers execute in the outer realm, so they dispatch outward. Confirmed live: the regression spec has to reach through `editor.canvas` (the `[name="editor-canvas"]` frame) to click "Choose Icon", and the modal still opens.
- **Custom‑element registry** — one window, one `customElements` registry. `<FaIconChooser>` upgrades.
- **`window[GLOBAL_KEY]`** — set and read on the same `window`. `edit.js:15` / `richTextIcon.js:25` cannot miss what `icon-chooser/src/index.js:31` set.

**Caveat.** Verified against the WP **6.6.1** source (`tmp/wordpress/wp-includes/block-editor.php`) and exercised against the local `bin/dev` container, whose editor *is* iframed. Re‑confirm `_wp_get_iframed_editor_assets()` is unchanged in WP 7.0 — if a future WP starts injecting `editorScript` into the iframe, all three items come back at once, and this section is the place to start.

**What survived.** Only the listener leak, which had nothing to do with frames. See [P1 — Custom‑event bus](#p1--customevent-bus-on-the-global-document-listener-leak-fixed).

---

### ~~P0 — Cross‑frame `getComputedStyle` bug~~ — **RETRACTED, not a bug**

**File:** `block-editor/src/richTextIcon.js:179`

```js
const { color, fontSize, backgroundColor } = window.getComputedStyle(contentRef.current)
```

The original audit flagged this as a required code fix, reasoning that `contentRef.current` lives inside the iframe while `window` is the outer admin window, so the computed values would come back empty or wrong.

**That reasoning was incorrect.** Per CSSOM, `getComputedStyle(elt)` begins by taking its document from **`elt`'s node document** — the receiving window plays no part in style resolution. `window.getComputedStyle(el)` and `el.ownerDocument.defaultView.getComputedStyle(el)` are the same operation. The proposed fix was a no‑op.

**Empirical confirmation.** The exact shape was reproduced — outer window holding the script, editable node inside a same‑origin `srcdoc` iframe carrying its own styles — and both call forms compared:

| Engine | via outer `window` | via `ownerDocument.defaultView` |
|---|---|---|
| Chromium 140.0.7339.186 | `rgb(200, 100, 50)` / `37px` / `rgb(9, 8, 7)` | identical |
| Firefox 141.0 | identical | identical |
| WebKit 26.0 | identical | identical |

All three return the iframe's styles correctly. The inline icon preview (`block-editor/src/iconModifier.js:460-468`) gets correct values in the iframed editor.

**Do not apply the previously proposed fix — it is a regression on Firefox.** Computed values only degrade when the element's browsing context container is **not being rendered** (a `display:none` iframe, or a detached node), and that is a function of rendering state, not of which window is called. In that state the two forms diverge, and the "fix" is the worse of the two:

```
iframe display:none, Firefox 141:
  window.getComputedStyle(el)                        -> rgb(0,0,0) | 16px | rgba(0,0,0,0)   (initial values)
  el.ownerDocument.defaultView.getComputedStyle(el)  -> "" | "" | ""                        (empty strings)
```

Chromium and WebKit return correct values even while hidden. So the current code degrades to a styled-but-wrong preview in the worst case, whereas the proposed change would have produced an unstyled one.

This state is unreachable in practice anyway: `InlineUI` only mounts under `isObjectActive` (`richTextIcon.js:366`) — the caret is already on an icon in a rendered editable, so the iframe is visible. The same reasoning rules out the only hard‑failure case, `getComputedStyle(null)`, which throws `TypeError` in all three engines but requires an unpopulated `contentRef.current`.

**Consequence for `classic-editor/src/index.js:42`:** the earlier note recommending the same change "for consistency" is withdrawn. There is nothing to be consistent with.

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
| 1 | **P0** | Deliver kit/CDN/webfont/v4‑shim runtime into the iframe | ✅ Done — PR #298 merged (`d27300dd`) | `includes/class-fontawesome.php` enqueue loops |
| 2 | **P1** | Icon‑chooser open‑event listener leak | ✅ Fixed + regression test | `IconChooserModal.js`, `edit.js:25`, `iconChooserListeners.spec.js` |
| 3 | **P2** | Duplicate inline style from double `enqueue_block_assets` firing | Verify (mechanism identified) | `font-awesome-icon-block-init.php:51`, `class-fontawesome.php:2126` |
| 4 | **P2** | Bump "Tested up to: 7.0"; realign `@wordpress/*` to `wp-7.0` | Housekeeping | `readme.txt`, `*/package.json` |
| 5 | **P2** | Re‑confirm `_wp_get_iframed_editor_assets()` unchanged in WP7 | Verify | `wp-includes/block-editor.php` |
| 6 | **P3** | Confirm no React‑major regression | Verify | modal/popover flows |
| — | ~~P0~~ | ~~`getComputedStyle` uses outer window on iframe node~~ | **Retracted — not a bug** | [Investigated and dismissed](#investigated-and-dismissed) |
| — | ~~P1~~ | ~~Custom‑event bus breaks across the iframe boundary~~ | **Retracted — one realm** | [Investigated and dismissed](#investigated-and-dismissed) |
| — | ~~P1~~ | ~~Icon‑chooser web component won't upgrade inside iframe~~ | **Retracted — one realm** | [Investigated and dismissed](#investigated-and-dismissed) |
| — | ~~P1~~ | ~~Conflict detector blanket‑runs in the iframe~~ | **Resolved before merge** | `class-fontawesome.php:3164` keeps the original three hooks |
| — | ~~P2~~ | ~~Shared `window[GLOBAL_KEY]` single‑window assumption~~ | **Retracted — one realm** | [Investigated and dismissed](#investigated-and-dismissed) |

**Nothing on this list blocks WP7.** Item 1 shipped. Item 2 was a real bug, but a pre‑existing one unrelated to WP7 — it just happened to be sitting in the code the cross‑frame investigation had to read. Items 3–6 are verification and housekeeping. Four of the audit's original five cross‑frame findings were false positives from the same heuristic; see the methodology note at the top before adding another.

---

## Runtime verification checklist (once a WP7 docker env is available)

Run on a WP7 site where the editor is iframed (all‑v3‑blocks condition met).

**Automated first.** The existing Playwright suite already covers the iframed editor against the local `bin/dev` container and should be re‑pointed at WP7 before any of the manual steps:

```bash
cd browser-testing
npm run test:browser-mocked-fa-api-pro-kit-all-browsers
npm run test:browser-mocked-fa-api-legacy-cdn-all-browsers
```

(The `test:ci:*` variants set `CI=true`, which loads `.env.ci` and targets the CI compose stack on `localhost:8888`, not the local dev env — use the non‑CI scripts above against `bin/dev`.)

Then, by hand:

1. Insert the **Font Awesome Icon block**; confirm the placeholder, the chosen icon, sizing, and animations render **inside the iframe** for both **SVG** and **webfont** technologies.
2. Click **"Choose Icon"** → the icon chooser modal opens, searches, and inserts. Repeat for the **rich‑text format** ("Change Icon" toolbar button) and the **icon styling modifier**. Covered for the block placeholder by `iconChooserListeners.spec.js`; the rich‑text and modifier entry points are still manual.
3. Confirm the **rich‑text inline icon preview** reflects the surrounding text color/size. This is a **regression check, not a fix validation** — cross‑engine testing says it already works (see [Investigated and dismissed](#investigated-and-dismissed)); this confirms it end‑to‑end with the theme's real editor styles applied.
4. With a **kit** configured, confirm kit `<i>` tags / shortcodes render in the editor iframe (validates PR #298).
5. **Classic editor**, which no automated spec covers and which the `useLayoutEffect` choice in `IconChooserModal` specifically protects: open a post in the classic editor and click the Font Awesome media button — the chooser must open on the **first** click, including on a page with multiple editors.
6. Confirm no duplicate `@font-face`/inline‑style injection, on the **front end** and in the **editor**, per the mechanism described under P0.
7. Re‑read `_wp_get_iframed_editor_assets()` in the WP7 tree and confirm it still enqueues only `editor_style_handles` for registered block types. The whole "one realm" argument rests on that.
