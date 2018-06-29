<?php

require_once('includes/class-font-awesome-release-provider.php');
require_once( dirname(__FILE__) . '/_support/font_awesome_phpunit_util.php');
use Composer\Semver\Semver;

class ReleaseProviderTest extends WP_UnitTestCase {
  protected $known_versions = [
    '5.0.1',
    '5.0.2',
    '5.0.3',
    '5.0.4',
    '5.0.6',
    '5.0.8',
    '5.0.9',
    '5.0.10',
    '5.0.12',
    '5.0.13',
    '5.1.0'
  ];

  public function test_can_load_and_instantiate(){
    $obj = FontAwesomeReleaseProvider();
    $this->assertFalse(is_null($obj));
  }

  public function test_load_release_data(){
    $farp = FontAwesomeReleaseProvider();
    $klass = new \ReflectionClass('FontAwesomeReleaseProvider');
    $releases_method = $klass->getMethod('releases');
    $releases_method->setAccessible(true);
    $releases = $releases_method->invoke($farp);
    $this->assertFalse(is_null($releases));
    $this->assertCount(count($this->known_versions), $releases);
    foreach($this->known_versions as $version){
      $this->assertArrayHasKey($version, $releases);
    }
  }

  public function test_versions(){
    $farp = FontAwesomeReleaseProvider();
    $versions = $farp->versions();
    $known_versions = $this->known_versions;
    $this->assertCount(count($this->known_versions), $versions);
    $this->assertArraySubset(Semver::rsort($known_versions), $versions);
  }

  public function test_5_0_all_free_shimless(){
    $farp = FontAwesomeReleaseProvider();

    $resource_collection = $farp->get_resource_collection(
      '5.0.13', // version
      'all', // style_opt
      [
        'use_pro' => false,
        'use_svg' => false,
        'use_shim' => false
      ]
    );

    $this->assertFalse(is_null($resource_collection));
    $this->assertCount(1, $resource_collection);
    $this->assertEquals('https://use.fontawesome.com/releases/v5.0.13/css/all.css', $resource_collection[0]->source());
    $this->assertEquals('sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp', $resource_collection[0]->integrity_key());
  }

  public function test_5_0_all_webfont_pro_shimless(){
    $farp = FontAwesomeReleaseProvider();

    $resource_collection = $farp->get_resource_collection(
      '5.0.13', // version
      'all', // style_opt
      [
        'use_pro' => true,
        'use_svg' => false,
        'use_shim' => false
      ]
    );

    $this->assertFalse(is_null($resource_collection));
    $this->assertCount(1, $resource_collection);
    $this->assertEquals('https://pro.fontawesome.com/releases/v5.0.13/css/all.css', $resource_collection[0]->source());
    $this->assertEquals('sha384-oi8o31xSQq8S0RpBcb4FaLB8LJi9AT8oIdmS1QldR8Ui7KUQjNAnDlJjp55Ba8FG', $resource_collection[0]->integrity_key());
  }

  /**
   * There was no webfont shim in 5.0.x. So this should throw an exception.
   */
  public function test_5_0_webfont_shim(){
    $farp = FontAwesomeReleaseProvider();

    $this->expectException(InvalidArgumentException::class);

    $resource_collection = $farp->get_resource_collection(
      '5.0.13', // version
      'all', // style_opt
      [
        'use_pro' => true,
        'use_svg' => false,
        'use_shim' => true
      ]
    );
  }

  public function test_5_1_all_webfont_pro_shimless(){
    $farp = FontAwesomeReleaseProvider();

    $resource_collection = $farp->get_resource_collection(
      '5.1.0', // version
      'all', // style_opt
      [
        'use_pro' => true,
        'use_svg' => false,
        'use_shim' => false
      ]
    );

    $this->assertFalse(is_null($resource_collection));
    $this->assertCount(1, $resource_collection);
    $this->assertEquals('https://pro.fontawesome.com/releases/v5.1.0/css/all.css', $resource_collection[0]->source());
    $this->assertEquals('sha384-87DrmpqHRiY8hPLIr7ByqhPIywuSsjuQAfMXAE0sMUpY3BM7nXjf+mLIUSvhDArs', $resource_collection[0]->integrity_key());
  }

  // TODO: when 5.1.1 is released, add a test to make sure there is a v4-shims.css integrity key
  public function test_5_1_0_missing_webfont_free_shim_integrity(){
    $farp = FontAwesomeReleaseProvider();

    $resource_collection = $farp->get_resource_collection(
      '5.1.0', // version
      'all', // style_opt
      [
        'use_pro' => false,
        'use_svg' => false,
        'use_shim' => true
      ]
    );

    $this->assertFalse(is_null($resource_collection));
    $this->assertCount(2, $resource_collection);
    $this->assertEquals('https://use.fontawesome.com/releases/v5.1.0/css/all.css', $resource_collection[0]->source());
    $this->assertEquals('sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt', $resource_collection[0]->integrity_key());
    $this->assertEquals('https://use.fontawesome.com/releases/v5.1.0/css/v4-shims.css', $resource_collection[1]->source());
    $this->assertTrue(is_null($resource_collection[1]->integrity_key()));
  }

  public function test_5_0_all_svg_pro_shim(){
    $farp = FontAwesomeReleaseProvider();

    $resource_collection = $farp->get_resource_collection(
      '5.0.13', // version
      'all', // style_opt
      [
        'use_pro' => true,
        'use_svg' => true,
        'use_shim' => true
      ]
    );

    $this->assertFalse(is_null($resource_collection));
    $this->assertCount(2, $resource_collection);
    $this->assertEquals('https://pro.fontawesome.com/releases/v5.0.13/js/all.js', $resource_collection[0]->source());
    $this->assertEquals('sha384-d84LGg2pm9KhR4mCAs3N29GQ4OYNy+K+FBHX8WhimHpPm86c839++MDABegrZ3gn', $resource_collection[0]->integrity_key());
    $this->assertEquals('https://pro.fontawesome.com/releases/v5.0.13/js/v4-shims.js', $resource_collection[1]->source());
    $this->assertEquals('sha384-LDfu/SrM7ecLU6uUcXDDIg59Va/6VIXvEDzOZEiBJCh148mMGba7k3BUFp1fo79X', $resource_collection[1]->integrity_key());
  }

  public function test_5_0_solid_brands_svg_free_shim(){
    $farp = FontAwesomeReleaseProvider();

    $resource_collection = $farp->get_resource_collection(
      '5.0.13', // version
      ['solid', 'brands'], // style_opt
      [
        'use_pro' => false,
        'use_svg' => true,
        'use_shim' => true
      ]
    );

    $this->assertFalse(is_null($resource_collection));
    $this->assertCount(4, $resource_collection);
    $resources = array();
    foreach( $resource_collection as $resource ){
      $matches = [];
      $this->assertTrue(boolval(preg_match('/\/(brands|solid|fontawesome|v4-shims)\.js/', $resource->source(), $matches)));
      $resources[$matches[1]] = $resource;
    }
    $this->assertCount(4, $resources);
    $this->assertArrayHasKey('fontawesome', $resources);
    $this->assertArrayHasKey('brands', $resources);
    $this->assertArrayHasKey('solid', $resources);
    $this->assertArrayHasKey('v4-shims', $resources);

    // The fontawesome main library will appear first in order
    $this->assertEquals('https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js', $resource_collection[0]->source());
    $this->assertEquals('sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY', $resource_collection[0]->integrity_key());

    // The style resources will appear in the middle, in any order
    foreach([1,2] as $resource_index){
      switch($resource_collection[$resource_index]){
        case $resources['brands']:
          $this->assertEquals('https://use.fontawesome.com/releases/v5.0.13/js/brands.js',
            $resource_collection[$resource_index]->source());
          $this->assertEquals('sha384-G/XjSSGjG98ANkPn82CYar6ZFqo7iCeZwVZIbNWhAmvCF2l+9b5S21K4udM7TGNu',
            $resource_collection[$resource_index]->integrity_key());
          break;
        case $resources['solid']:
          $this->assertEquals('https://use.fontawesome.com/releases/v5.0.13/js/solid.js',
            $resource_collection[$resource_index]->source());
          $this->assertEquals('sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ',
            $resource_collection[$resource_index]->integrity_key());
          break;
        default:
          throw new InvalidArgumentException('Unexpected resource in collection');
      }
    }

    // The shim will appear last in order
    $this->assertEquals('https://use.fontawesome.com/releases/v5.0.13/js/v4-shims.js', $resource_collection[3]->source());
    $this->assertEquals('sha384-qqI1UsWtMEdkxgOhFCatSq+JwGYOQW+RSazfcjlyZFNGjfwT/T1iJ26+mp70qvXx', $resource_collection[3]->integrity_key());
  }

  public function test_5_1_solid_webfont_free_shim(){
    $farp = FontAwesomeReleaseProvider();

    $resource_collection = $farp->get_resource_collection(
      '5.1.0', // version
      ['solid'], // style_opt, only a single style
      [
        'use_pro' => false,
        'use_svg' => false,
        'use_shim' => true // expect a warning but no error since webfont had no shim in 5.0.x
      ]
    );

    $this->assertFalse(is_null($resource_collection));
    $this->assertCount(3, $resource_collection);
    $resources = array();
    foreach( $resource_collection as $resource ){
      $matches = [];
      $this->assertTrue(boolval(preg_match('/\/(brands|solid|fontawesome|v4-shims)\.css/', $resource->source(), $matches)));
      $resources[$matches[1]] = $resource;
    }
    $this->assertCount(3, $resources);
    $this->assertArrayHasKey('fontawesome', $resources);
    $this->assertArrayHasKey('solid', $resources);
    $this->assertArrayHasKey('v4-shims', $resources);

    // The fontawesome main library will appear first in order
    $this->assertEquals('https://use.fontawesome.com/releases/v5.1.0/css/fontawesome.css', $resource_collection[0]->source());
    $this->assertEquals('sha384-ozJwkrqb90Oa3ZNb+yKFW2lToAWYdTiF1vt8JiH5ptTGHTGcN7qdoR1F95e0kYyG', $resource_collection[0]->integrity_key());

    // The solid style in the middle
    $this->assertEquals('https://use.fontawesome.com/releases/v5.1.0/css/solid.css',
      $resource_collection[1]->source());
    $this->assertEquals('sha384-TbilV5Lbhlwdyc4RuIV/JhD8NR+BfMrvz4BL5QFa2we1hQu6wvREr3v6XSRfCTRp',
      $resource_collection[1]->integrity_key());

    // The shim last
    $this->assertEquals('https://use.fontawesome.com/releases/v5.1.0/css/v4-shims.css', $resource_collection[2]->source());
    // But there was no integrity key for the webfont shim in 5.1.0, so we expect it to be null
    $this->assertTrue(is_null($resource_collection[2]->integrity_key()));
  }

  public function test_5_1_no_style_webfont_free_shim(){
    $farp = FontAwesomeReleaseProvider();

    $this->expectException(InvalidArgumentException::class);

    $resource_collection = $farp->get_resource_collection(
      '5.1.0', // version
      [], // style_opt, empty
      [
        'use_pro' => false,
        'use_svg' => false,
        'use_shim' => true
      ]
    );
  }

  public function test_5_1_bad_style_webfont_free_shim(){
    $farp = FontAwesomeReleaseProvider();

    $this->expectException(InvalidArgumentException::class);

    $state = array();
    \FontAwesomePhpUnitUtil\begin_error_log_capture($state);
    $resource_collection = $farp->get_resource_collection(
      '5.1.0', // version
      ['foo', 'bar'], // style_opt, only bad styles
      [
        'use_pro' => false,
        'use_svg' => false,
        'use_shim' => true
      ]
    );
    $error_log = \FontAwesomePhpUnitUtil\end_error_log_capture($state);
    $this->assertRegExp("/WARNING.+?unrecognized.+?foo/", $error_log);
  }

  /**
   * Add an invalid style specifier to the $style_opt, why also providing a legitimate one.
   * We expect success, but with a non-fatal error_log.
   */
  public function test_5_1_solid_foo_webfont_free_no_shim(){
    $farp = FontAwesomeReleaseProvider();

    $state = array();
    \FontAwesomePhpUnitUtil\begin_error_log_capture($state);
    $resource_collection = $farp->get_resource_collection(
      '5.1.0', // version
      ['solid', 'foo'], // style_opt
      [
        'use_pro' => false,
        'use_svg' => false,
        'use_shim' => false
      ]
    );
    $error_log = \FontAwesomePhpUnitUtil\end_error_log_capture($state);

    $this->assertFalse(is_null($resource_collection));
    $this->assertCount(2, $resource_collection);
    $resources = array();
    foreach( $resource_collection as $resource ){
      $matches = [];
      $this->assertTrue(boolval(preg_match('/\/(solid|fontawesome)\.css/', $resource->source(), $matches)));
      $resources[$matches[1]] = $resource;
    }
    $this->assertCount(2, $resources);
    $this->assertArrayHasKey('fontawesome', $resources);
    $this->assertArrayHasKey('solid', $resources);

    // The fontawesome main library will appear first in order
    $this->assertEquals('https://use.fontawesome.com/releases/v5.1.0/css/fontawesome.css', $resource_collection[0]->source());
    $this->assertEquals('sha384-ozJwkrqb90Oa3ZNb+yKFW2lToAWYdTiF1vt8JiH5ptTGHTGcN7qdoR1F95e0kYyG', $resource_collection[0]->integrity_key());

    // The solid style next
    $this->assertEquals('https://use.fontawesome.com/releases/v5.1.0/css/solid.css',
      $resource_collection[1]->source());
    $this->assertEquals('sha384-TbilV5Lbhlwdyc4RuIV/JhD8NR+BfMrvz4BL5QFa2we1hQu6wvREr3v6XSRfCTRp',
      $resource_collection[1]->integrity_key());

    $this->assertRegExp("/WARNING.+?unrecognized.+?foo/", $error_log);
  }

  public function test_invalid_version(){
    $farp = FontAwesomeReleaseProvider();

    $this->expectException(InvalidArgumentException::class);

    $resource_collection = $farp->get_resource_collection(
      '4.0.13', // invalid version
      'all', // style_opt
      [
        'use_pro' => true,
        'use_svg' => false,
        'use_shim' => false
      ]
    );

    $this->assertFalse(is_null($resource_collection));
    $this->assertCount(1, $resource_collection);
    $this->assertEquals('https://pro.fontawesome.com/releases/v4.0.13/css/all.css', $resource_collection[0]->source());
    $this->assertEquals('sha384-oi8o31xSQq8S0RpBcb4FaLB8LJi9AT8oIdmS1QldR8Ui7KUQjNAnDlJjp55Ba8FG', $resource_collection[0]->integrity_key());
  }

  function assert_latest_and_previous_releases($mocked_available_versions, $expected_latest, $expected_previous){
    $mock = \FontAwesomePhpUnitUtil\mock_singleton_method(
      $this,
      FontAwesomeReleaseProvider::class,
      'versions',
      function($method) use($mocked_available_versions){
        $method->willReturn(
          $mocked_available_versions
        );
      }
    );
    $this->assertEquals($expected_latest, $mock->latest_minor_release());
    $this->assertEquals($expected_previous, $mock->previous_minor_release());
  }

  function test_latest_and_previous_scenarios(){
    $this->assert_latest_and_previous_releases(
      [
        '5.1.1',
        '5.1.0',
        '5.0.13',
        '5.0.11',
        '5.0.0'
      ],
      '5.1.1',
      '5.0.13'
    );

    // There *is* no previous in this case because 5.0.0 is the earliest and 5.0.13 is the latest.
    // So there's no minor release version before the earliest available in this set.
    $this->assert_latest_and_previous_releases(
      [
        '5.0.13',
        '5.0.11',
        '5.0.0'
      ],
      '5.0.13',
      null
    );

    $this->assert_latest_and_previous_releases(
      [
        '5.2.0',
        '5.1.1',
        '5.0.13',
        '5.0.11',
        '5.0.0'
      ],
      '5.2.0',
      '5.1.1'
    );

    // empty set
    $this->assert_latest_and_previous_releases(
      [],
      null,
      null
    );
  }
}
