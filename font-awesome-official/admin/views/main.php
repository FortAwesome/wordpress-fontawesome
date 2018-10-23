<?php
/**
 * Returns the value of the requirement key, if it exists,
 * else it returns a string for display to indicate that
 * no requirement is specified for this key.
 */
function fa_format_requirement_value($req, $key){
  return array_key_exists($key, $req) ? $req[$key] : '_';
}
function fa_requirements_th($key){
  $conflicts = FontAwesome()->conflicts();
  $conflict_class = $key[0] == $conflicts['req'] ? 'class="conflict"' : '';
  $conflict_label = $key[0] == $conflicts['req'] ? '*' : '';
  echo('<th ' . $conflict_class . '>' . $conflict_label . $key[1] . '</th>');
}
function fa_requirements_col($key){
  $conflicts = FontAwesome()->conflicts();
  $conflict_class = $key[0] == $conflicts['req'] ? 'class="conflict"' : '';
  echo('<col ' . $conflict_class . '/>');
}
function fa_get_loaded_description(){
  $load_spec = FontAwesome()->load_spec();
  $desc = "Font Awesome";
  $desc .= $load_spec['pro'] ? ' <span class="license pro">Pro</span>' : ' <span class="license free">Free</span>';
  $v4compat = $load_spec['v4shim'] ? 'true' : 'false';
  $pseudo_elements = $load_spec['pseudo-elements'] ? 'true' : 'false';
?>
  <p><?= $desc ?></p>
  <table>
  <tr><td class="label">version: </td><td class="value"><?= $load_spec['version'] ?></td></tr>
  <tr><td class="label">method: </td><td class="value"><?= $load_spec['method'] ?></td></tr>
  <tr><td class="label">version 4 compatibility: </td><td class="value"><?= $v4compat ?></td></tr>
  <tr><td class="label">pseudo-elements support: </td><td class="value"><?= $pseudo_elements ?></td></tr>
  </table>
<?php
}

$fa_has_conflict = !is_null(FontAwesome()->conflicts());
$fa_status_label = $fa_has_conflict ? 'conflict' : 'good';
?>
<div id="font-awesome-official-admin">
</div>
