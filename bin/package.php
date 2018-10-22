<?php
$repo_dir = dirname(__DIR__);
$dist_dir = $repo_dir . '/dist';
$plugin_dir = $repo_dir . '/font-awesome-official';

initialize_dist_dir($dist_dir);
$rc = null;
system("composer install -d " . $plugin_dir, $rc);

if( 0 !== $rc ) {
  printf("ERROR: could not run composer. Do you have it installed and on the PATH?\n");
};

rcp($plugin_dir . '/vendor', $dist_dir . '/vendor');
rcp($plugin_dir . '/releases', $dist_dir . '/releases');
rcp($plugin_dir . '/includes', $dist_dir . '/includes');
rcp($plugin_dir . '/admin', $dist_dir . '/admin');
copy($plugin_dir . '/index.php', $dist_dir . '/index.php');
copy($plugin_dir . '/font-awesome-official.php', $dist_dir . '/font-awesome-official.php');
copy($repo_dir . '/readme.txt', $dist_dir . '/readme.txt');
copy($repo_dir . '/LICENSE', $dist_dir . '/LICENSE');
copy($plugin_dir . '/composer.json', $dist_dir . '/composer.json');
copy($plugin_dir . '/composer.lock', $dist_dir . '/composer.lock');

// zip dist
$zip_filename = $repo_dir . '/font-awesome-official.zip';
if(file_exists($zip_filename)) {
  printf("WARNING: Zip file $zip_filename already exists, so we won't overwrite it.\n" .
    "It's probably out of sync with the dist dir, though.\n");
}
$zip = new ZipArchive();
if ($zip->open($zip_filename, ZipArchive::CREATE)!==TRUE) {
  exit("cannot open <$zip_filename>\n");
} else {
  $options = array('add_path' => 'font-awesome-official/', 'remove_path' => 'dist');
  rzip($zip, 'dist', 0, $options);
  $zip->close();
}

function initialize_dist_dir($dist_dir){
  if(file_exists($dist_dir)){
    // remove the directory and its contents, recursively
    rimraf($dist_dir);
  }
  mkdir($dist_dir);
}

// Recursively zip
function rzip($zip, $src, $flags, $options){
  if(is_dir($src)){
    // Glob everything in the directory.
    // If it's a subdir, recursively add it to the zip.
    // Otherwise, it's a file—just add it to the zip.
    $files = glob($src . '/*');
    foreach ($files as $file){
      if (( $file != '.' ) && ( $file != '..' )) {
        if (is_dir($file)) {
          rzip($zip, $file, $flags, $options);
        } else {
          $zip->addGlob($file, $flags, $options);
        }
      }
    }
  }
  printf("WARNING: $src is not a directory. Ignoring.\n");
}

function rimraf($target){
  if(is_dir($target)){
    $dir = opendir($target);
    while(false !== ($file = readdir($dir))){
      if (( $file != '.' ) && ( $file != '..' )) {
        if( is_dir($target . '/' . $file)) {
          rimraf($target . '/' . $file);
        } else {
          unlink($target . '/' . $file);
        }
      }
    }
    rmdir($target);
  } else {
    unlink($target);
  }
}

// Copy recursively
// Parts borrowed from http://php.net/manual/en/function.copy.php#91010
function rcp($src, $dst){
  if(is_dir($src)){
    if(! file_exists($dst)) mkdir($dst);
    $dir = opendir($src);
    while(false !== ($file = readdir($dir))){
      if (( $file != '.' ) && ( $file != '..' )) {
        if( is_dir($src . '/' . $file)){
          rcp($src . '/' . $file, $dst . '/' . $file);
        } else {
          copy($src . '/' . $file, $dst . '/' . $file);
        }
      }
    }
  } else {
    copy($src, $dst);
  }
}
