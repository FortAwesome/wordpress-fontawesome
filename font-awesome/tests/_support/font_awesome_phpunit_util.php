<?php
namespace FontAwesomePhpUnitUtil;
/**
 * Shared utilities for testing FontAwesome with PhpUnit and WordPress.
 */

/**
 * Replaces the singleton _instance on FontAwesome with a mock object
 * and then mocks a method.
 *
 * @param object $mock_builder the PhpUnit mock builder from $this->getMockBuilder()
 * @param string $method name of method to be mocked
 * @param callable $init a function to invoke, passing the method mock as the sole param.
 *                 Used to declare how the mock method will behave.
 *                 Ex: $mock_method->willReturn(false)
 */
function mock_singleton_method($mock_builder, $method, callable $init){
  $mock_builder->setMethods([$method]); // let all methods work as defined in the original
  $mock = $mock_builder->getMock();
  $ref = new \ReflectionProperty('FontAwesome', '_instance');
  $ref->setAccessible(true);
  $ref->setValue(null, $mock);
  $init($mock->method($method));
  return $mock;
}
