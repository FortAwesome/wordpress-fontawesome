<?php

require_once( dirname(__FILE__) . '/../includes/class-font-awesome-activator.php');
require_once( dirname(__FILE__) . '/_support/font_awesome_phpunit_util.php');

class UnregisteredClientsTest extends WP_UnitTestCase {

  protected $fake_unregistered_clients = array(
    'styles' => [
      array(
        'handle' => 'fa-4.7-jsdelivr-css',
        'src' => 'https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.css'
      )
    ],
    'scripts' => [
      array(
        'handle' => 'fa-5.0.13-js',
        'src' => 'https://use.fontawesome.com/releases/v5.0.13/js/all.js'
      )
    ]
  );
  /**
   * @before
   */
  function reset(){
    FontAwesome::instance()->reset();
    \FontAwesomePhpUnitUtil\MockFontAwesomeReleases::mock();
    wp_script_is('font-awesome-official', 'enqueued') && wp_dequeue_script('font-awesome-official');
    wp_script_is('font-awesome-official-v4shim', 'enqueued') && wp_dequeue_script('font-awesome-official-v4shim');
    wp_style_is('font-awesome-official', 'enqueued') && wp_dequeue_style('font-awesome-official');
    wp_style_is('font-awesome-official-v4shim', 'enqueued') && wp_dequeue_style('font-awesome-official-v4shim');
    foreach($this->fake_unregistered_clients['styles'] as $style){
      wp_dequeue_style($style['handle']);
      wp_deregister_style($style['handle']);
    }
    foreach($this->fake_unregistered_clients['scripts'] as $script){
      wp_dequeue_script($script['handle']);
      wp_deregister_script($script['handle']);
    }
  }

  function enqueue_fakes(){
    // Add some unregistered clients, both styles and scripts
    foreach($this->fake_unregistered_clients['styles'] as $style){
      wp_enqueue_style( $style['handle'], $style['src'], array(), null, 'all' );
    }

    foreach($this->fake_unregistered_clients['scripts'] as $script){
      wp_enqueue_script( $script['handle'], $script['src'], array(), null, 'all' );
    }
  }

  function test_unregistered_conflict_cleaned(){
    $fa = \FontAwesomePhpUnitUtil\mock_singleton_method(
      $this,
      FontAwesome::class,
      'options',
      function($method) {
        $opts = wp_parse_args(array('remove_others' => true), FontAwesome()->default_user_options);
        $method->willReturn($opts);
      }
    );

    $this->enqueue_fakes();

    add_action('font_awesome_requirements', function() use($fa){
      $fa->register(['name' => 'clientA']);
    });

    $fa->load();

    ob_start();
    wp_head(); // required to trigger the 'wp_enqueue_scripts' action
    ob_end_clean();

    // make sure that the fake unregistered clients are no longer enqueued and that our plugin succeeded otherwise
    $unregistered_clients = $fa->unregistered_clients();
    $this->assertCount(
      count($this->fake_unregistered_clients['styles']) + count($this->fake_unregistered_clients['scripts']),
      $unregistered_clients
    );
    foreach( $unregistered_clients as $client){
      switch($client['type']){
        case 'style':
          $this->assertTrue(wp_style_is($client['handle'], 'registered')); // is *was* there
          $this->assertFalse(wp_style_is($client['handle'], 'enqueued')); // now it's gone
          break;
        case 'script':
          $this->assertTrue(wp_script_is($client['handle'], 'registered')); // is *was* there
          $this->assertFalse(wp_script_is($client['handle'], 'enqueued')); // now it's gone
          break;
      }
    }
    $this->assertTrue(wp_style_is($fa->handle, 'enqueued')); // and our plugin's style *is* there
  }

  function test_unregistered_conflict_unresolved_by_default(){
    $fa = FontAwesome();

    $this->enqueue_fakes();

    add_action('font_awesome_requirements', function() use($fa){
      $fa->register(['name' => 'clientA']);
    });

    $fa->load();

    ob_start();
    wp_head(); // required to trigger the 'wp_enqueue_scripts' action
    ob_end_clean();

    // make sure that the fake unregistered clients remain enqueued
    $unregistered_clients = $fa->unregistered_clients();
    $this->assertCount(
      count($this->fake_unregistered_clients['styles']) + count($this->fake_unregistered_clients['scripts']),
      $unregistered_clients
    );
    foreach( $unregistered_clients as $client){
      switch($client['type']){
        case 'style':
          $this->assertTrue(wp_style_is($client['handle'], 'enqueued'));
          break;
        case 'script':
          $this->assertTrue(wp_script_is($client['handle'], 'enqueued'));
          break;
      }
    }
  }
}

