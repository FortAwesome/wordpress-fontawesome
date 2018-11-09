<?php

require_once( dirname(__FILE__) . '/../includes/class-font-awesome-activator.php');
require_once( dirname(__FILE__) . '/../includes/class-font-awesome-deactivator.php');

class ActivationTest extends WP_UnitTestCase {

  /**
   * @before
   */
  function reset(){
    delete_option(FontAwesome::OPTIONS_KEY);
  }

  function test_before_activation(){
    $options = get_option(FontAwesome::OPTIONS_KEY);
    $this->assertFalse($options);
  }

  function test_activation_creates_default_config(){
    FontAwesome_Activator::activate();
    $options = get_option(FontAwesome::OPTIONS_KEY);
    $this->assertEquals(FontAwesome::DEFAULT_USER_OPTIONS['load_spec']['name'], $options['load_spec']['name']);
  }
}
