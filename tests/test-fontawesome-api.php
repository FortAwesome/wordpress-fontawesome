<?php
namespace FortAwesome;

/**
 * Tests the release provider.
 *
 * @noinspection PhpIncludeInspection
 */

require_once FONTAWESOME_DIR_PATH . 'includes/class-fontawesome-metadata-provider.php';
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
      $metadata_api = FontAwesome_Metadata_Provider::instance();
      $returned_value = $metadata_api->get_available_versions();
    }
}