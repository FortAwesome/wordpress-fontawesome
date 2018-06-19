<?php

require_once( dirname(__FILE__) . '/../includes/class-font-awesome-activator.php');
require_once( dirname(__FILE__) . '/../includes/class-font-awesome-deactivator.php');

class ActivationTest extends WP_UnitTestCase {

  /**
   * @before
   */
  function reset(){
    delete_option(FontAwesome()->options_key);
  }

  function test_before_activation(){
    $options = get_option(FontAwesome()->options_key);
    $this->assertFalse($options);
  }

  function test_activation_creates_default_config(){
    FontAwesome_Activator::activate();
    $options = get_option(FontAwesome()->options_key);
    $this->assertEquals(FontAwesome()->default_user_options['load_spec']['name'], $options['load_spec']['name']);
  }
}
