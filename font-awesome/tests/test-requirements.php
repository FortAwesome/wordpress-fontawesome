<?php
    require_once('vendor/autoload.php');
    use Composer\Semver\Semver;
// Cases TODO:
// - client with name only, accepting all defaults
// - webfont method + pseudo-elements should be compatible
// - webfont method and forbid pseudo-elements should warn but not die, cause you can't disable that
class RequirementsTest extends WP_UnitTestCase {

  /**
   * @before
   */
  function reset(){
    FontAwesome()->reset();
  }

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

  function test_incompatible_method() {
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

  /**
   * @group version
   */
  function test_incompatible_version() {
    add_action('font_awesome_requirements', function(){

      FontAwesome()->register_requirements(array(
        'name' => 'clientA',
        'version' => '5.0.13'
      ));

      FontAwesome()->register_requirements(array(
        'name' => 'clientB',
        'version' => '5.0.12'
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
      $this->assertEquals('version', $data['req']);
      $this->assertEquals(2, count($data['client-reqs']));
    };
    add_action('font_awesome_failed', $failed_callback);

    $this->assertNull(FontAwesome()->load());
    $this->assertTrue($failed);
    $this->assertFalse($enqueued);
  }

  // This is here mainly to provide development notes about what kind of
  // results to expect from the Semver library. It does not test our plugin.
  // If anything, it tests the Semver library for regressions in a handful of cases.
  /**
   * @group version
   */
  function test_explore_semver(){
    $this->assertTrue(Semver::satisfies('5.0.13', '5.0.13'));
    $this->assertFalse(Semver::satisfies('5.0.13', '5.0.12'));
    $this->assertTrue(Semver::satisfies('5.0.13', '>5.0.10'));
    $this->assertTrue(Semver::satisfies('5.0.13', '^5.0'));
    $this->assertTrue(Semver::satisfies('5.0.11', '~5.0.10'));
    $this->assertFalse(Semver::satisfies('5.1.0', '~5.0.10'));
    $this->assertTrue(Semver::satisfies('5.1.0', '^5.0.0'));
    $this->assertFalse(Semver::satisfies('5.0.13', '^5.1.0'));
    /**
     * probably we need to provide only stable versions, not development ones,
     * because this doesn't behave as might be expected.
     */
    //$this->assertFalse(Semver::satisfies('5.1.0.11-dev', '^5.0.0-stable'));
  }

  /**
   * @group version
   * @requires function skipme
   */
  function test_compatible_with_latest_stable_version() {
    $stub = $this->createMock(FontAwesome::class);
    $stub->method('get_latest_stable_version')
      ->willReturn('5.0.13');

    add_action('font_awesome_requirements', function(){

      FontAwesome()->register_requirements(array(
        'name' => 'clientA',
        'version' => '~5.0.0'
      ));

      FontAwesome()->register_requirements(array(
        'name' => 'clientB',
        'version' => '>=5.0.12'
      ));

      FontAwesome()->register_requirements(array(
        'name' => 'clientC',
        'version' => '^5'
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
    };
    add_action('font_awesome_failed', $failed_callback);

    $this->assertFalse($failed);
    $this->assertTrue($enqueued);
  }
}
