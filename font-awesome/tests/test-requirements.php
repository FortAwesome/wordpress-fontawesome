<?php
// Cases TODO:
// - client with name only, accepting all defaults
class RequirementsTest extends WP_UnitTestCase {
  function test_register_without_name(){
      $this->expectException(InvalidArgumentException::class);

      FontAwesome()->register_requirements(array(
        'method' => 'svg',
        'v4shim' => 'require'
      ));
  }

  function test_single_client_gets_what_it_wants() {

    add_action('font_awesome_requirements', function(){
      FontAwesome()->register_requirements(array(
        'name' => 'test',
        'method' => 'svg',
        'v4shim' => 'require'
      ));
    });

    add_action('font_awesome_enqueued', function($loadSpec){
      $this->assertEquals('svg', $loadSpec['method']);
      $this->assertTrue($loadSpec['v4shim']);
    });

    FontAwesome()->load();
  }

  function test_two_compatible_clients() {

    add_action('font_awesome_requirements', function(){

      FontAwesome()->register_requirements(array(
        'name' => 'clientA',
        'method' => 'svg',
        'v4shim' => 'require'
      ));

      FontAwesome()->register_requirements(array(
        'name' => 'clientB',
        'method' => 'svg'
        // leaves v4shim alone
      ));
    });

    add_action('font_awesome_enqueued', function($loadSpec){
      $this->assertEquals('svg', $loadSpec['method']);
      $this->assertTrue($loadSpec['v4shim']);
    });

    FontAwesome()->load();
  }

  function test_two_incompatible_clients() {

    add_action('font_awesome_requirements', function(){

      FontAwesome()->register_requirements(array(
        'name' => 'clientA',
        'method' => 'svg'
      ));

      FontAwesome()->register_requirements(array(
        'name' => 'clientB',
        'method' => 'webfont' // not compatible with svg
      ));
    });

    $enqueued_callback = function(){
      static $count = 0;
    $bt = debug_backtrace(1);
    $caller = array_shift($bt);
      $count++;
      return $count;
    };
    add_action('font_awesome_enqueued', $enqueued_callback);

    $failed_callback = function(){
      static $count = 0;
      $count++;
      return $count;
    };
    add_action('font_awesome_failed', $failed_callback);

    $this->assertNull(FontAwesome()->load());
    $this->assertEquals(0, $enqueued_callback() - 1);
    $this->assertEquals(1, $failed_callback() - 1);
  }

}
