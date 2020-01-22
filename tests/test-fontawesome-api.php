<?php
namespace FortAwesome;

/**
 * Tests the release provider.
 *
 * @noinspection PhpIncludeInspection
 */

require_once FONTAWESOME_DIR_PATH . 'includes/class-fontawesome-api.php';
require_once dirname( __FILE__ ) . '/_support/font-awesome-phpunit-util.php';

use \InvalidArgumentException;

/**
 * Class ReleaseProviderTest
 *
 * @group api
 */
class MetadataAPITest extends \WP_UnitTestCase {

  public function test_get_available_versions() {
      // $mock_response = self::build_500_response();
      // $farp = $this->create_release_provider_with_mocked_response( $mock_response );
      // $farp->get_available_versions();
      $metadata_api = FontAwesome_Metadata_API::instance();
      $returned_value = $metadata_api->get_available_versions();
      print_r($returned_value);
    }
}