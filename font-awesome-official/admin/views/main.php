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
<div class="wrap font-awesome-official-admin">
<h1>Font Awesome Official</h1>
<div class="status <?= $fa_status_label ?>">
<p><span class="status-label">Status: </span><span class="status-value"><?= $fa_status_label ?></span></p>
<?php if(! $fa_has_conflict ): ?>
<p><span class="loaded-label">Loaded: </span></p>
<div class="load-spec">
  <?= fa_get_loaded_description() ?>
</div>
</p>
<?php endif; ?>
</div>
<form method="post" action="options.php">
  <?php
  settings_fields( FontAwesome()->options_key );
  do_settings_sections( FontAwesome()->plugin_name );
  submit_button();
  $fa_requirements_column_keys_and_labels = [
            ['name', 'Name'],
            ['method', 'Method'],
            ['version','Version'],
            ['v4shim', 'Version 4 Compatibility'],
            ['pseudo-elements', 'Pseudo-elements Support']
          ];
  ?>
</form>
  <div class="<?= FontAwesome()->plugin_name ?>-report">
    <h1>Current Requirements</h1>
    <table class="<?= FontAwesome()->plugin_name ?>-clients">
      <colgroup>
        <?php
        foreach($fa_requirements_column_keys_and_labels as $key) {
          fa_requirements_col($key);
        }
        ?>
      </colgroup>
      <thead>
      <tr class="header">
        <?php
        foreach($fa_requirements_column_keys_and_labels as $key) {
            fa_requirements_th($key);
        }
        ?>
      </tr>
      </thead>
      <tbody>
    <?php foreach(FontAwesome()->requirements() as $req) { ?>
      <tr class="client">
        <td class="name"><?= fa_format_requirement_value($req, 'name') ?></td>
        <td class="method"><?= fa_format_requirement_value($req, 'method') ?></td>
        <td class="version"><?= fa_format_requirement_value($req, 'version') ?></td>
        <td class="v4shim"><?= fa_format_requirement_value($req, 'v4shim') ?></td>
        <td class="pseudo-elements"><?= fa_format_requirement_value($req, 'pseudo-elements') ?></td>
      </tr>
    <?php } ?>
      </tbody>
    </table>
    <div class="legend">
      <?php if(! is_null(FontAwesome()->conflicts()) ): ?>
      <p>* indicates conflicting requirements in this column.</p>
      <?php endif; ?>
      <p>_ indicates that this requirement was not specified by this client, so it can accept a default or the requirement of some other client.</p>
    </div>
  </div>
  <div class="<?= FontAwesome()->plugin_name ?>-unregistered-clients">
    <h1>Unregistered Clients</h1>
    <table class="<?= FontAwesome()->plugin_name ?>-unregistered-clients-table">
      <thead>
        <tr class="header">
          <th>name</th>
          <th>type</th>
          <th>source</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach( FontAwesome()->unregistered_clients() as $client ){ ?>
        <tr>
          <td><?= $client['handle'] ?></td>
          <td><?= $client['type'] ?></td>
          <td><?= $client['src'] ?></td>
        </tr>
      <?php } # end foreach client ?>
      </tbody>
    </table>
  </div>
</div>

