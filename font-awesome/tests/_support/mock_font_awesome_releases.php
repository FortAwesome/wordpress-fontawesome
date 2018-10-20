<?php

namespace FontAwesomePhpUnitUtil;

class MockFontAwesomeReleases {
  public static $releases = null;

  public static function load_releases () {
    $mocked_releases = array();
    $files = glob( trailingslashit(FONTAWESOME_DIR_PATH) . 'releases/release*.yml' );
    foreach($files as $file){
      $basename = basename($file);
      $matches = [];
      if( preg_match('/release-([0-9]+\.[0-9]+\.[0-9]+)\.yml/', $basename,$matches) ){
        $release_data = \Spyc::YAMLLoad($file);
        $mocked_releases[$matches[1]] = $release_data;
      }
    }

    self::$releases = $mocked_releases;

  }

  public static function releases() {
    if(self::$releases == null) {
      self::load_releases();
    }
    return self::$releases;
  }
}