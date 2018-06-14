<?php
// Cases TODO:
// - client with name only, accepting all defaults
// - webfont method + pseudo-elements should be compatible
// - webfont method and forbid pseudo-elements should warn but not die, cause you can't disable that
class RequirementsTest extends WP_UnitTestCase {
  function test_register_without_name(){
    FontAwesome()->reset();
    $this->expectException(InvalidArgumentException::class);

    FontAwesome()->register_requirements(array(
      'method' => 'svg',
      'v4shim' => 'require'
    ));
  }

  function test_single_client_gets_what_it_wants() {
    FontAwesome()->reset();
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
    FontAwesome()->reset();
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
    FontAwesome()->reset();
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

    $enqueued = false;
    $enqueued_callback = function() use(&$enqueued){
      $enqueued = true;
    };
    add_action('font_awesome_enqueued', $enqueued_callback);

    $failed = false;
    $failed_callback = function($data) use(&$failed){
      $failed = true;
      $this->assertEquals('method', $data['req']);
      $this->assertEquals(2, count($data['client-reqs']));
    };
    add_action('font_awesome_failed', $failed_callback);

    $this->assertNull(FontAwesome()->load());
    $this->assertTrue($failed);
    $this->assertFalse($enqueued);
  }

  function test_pseudo_element_default_false_when_svg(){
    FontAwesome()->reset();
    add_action('font_awesome_requirements', function(){
      FontAwesome()->register_requirements(array(
        'name' => 'test',
        'method' => 'svg'
      ));
    });

    add_action('font_awesome_enqueued', function($loadSpec){
      $this->assertEquals('svg', $loadSpec['method']);
      $this->assertFalse($loadSpec['pseudo-elements']);
    });

    FontAwesome()->load();
  }

  function test_pseudo_element_default_true_when_webfont(){
    FontAwesome()->reset();
    add_action('font_awesome_requirements', function(){
      FontAwesome()->register_requirements(array(
        'name' => 'test',
        'method' => 'webfont'
      ));
    });

    add_action('font_awesome_enqueued', function($loadSpec){
      $this->assertEquals('webfont', $loadSpec['method']);
      $this->assertTrue($loadSpec['pseudo-elements']);
    });

    FontAwesome()->load();
  }
}
