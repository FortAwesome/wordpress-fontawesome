<?php
require_once( FONTAWESOME_DIR_PATH . 'defines.php');
require_once( FONTAWESOME_DIR_PATH . 'vendor/autoload.php');
require_once( FONTAWESOME_DIR_PATH . 'includes/class-font-awesome-resource.php');

use Composer\Semver\Semver;
use GuzzleHttp\Client;

if (! class_exists('FontAwesomeReleaseProvider') ) :
  class FontAwesomeReleaseProvider {
    protected $_releases = null;

    protected $_apiClient = null;

    /**
     * The single instance of the class.
     */
    protected static $_instance = null;

    /**
     * Main FontAwesomeReleaseProvider Instance.
     *
     * Ensures only one instance of FontAwesomeReleaseProvider is loaded or can be loaded.
     */
    public static function instance() {
      if ( is_null( self::$_instance ) ) {
        self::$_instance = new self();
      }
      return self::$_instance;
    }

    /**
     * Resets the singleton instance referenced by this class.
     */
    public static function reset(){
      self::$_instance = null;
      self::instance();
    }

    private function __construct() {
      $this->_apiClient = new Client([
            // Base URI is used with relative requests
            'base_uri' => FONTAWESOME_API_URL,
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);
    }

    private function map_api_release($release) {
      $mapped_release = array();
      $mapped_release['version'] = $release['attributes']['version'];
      $mapped_release['download'] = $release['attributes']['download'];
      $mapped_release['date'] = $release['attributes']['date'];
      $mapped_release['iconCount'] = $release['attributes']['icon-count'];
      $mapped_release['sri'] = $release['attributes']['sri'];

      return $mapped_release;
    }

    private function load_releases(){
      $files = glob( trailingslashit(FONTAWESOME_DIR_PATH) . 'releases/release*.yml' );
      $response = $this->_apiClient->get('api/releases');
      $code = $response->getStatusCode();
      $body = $response->getBody();
      $bodyContents = $body->getContents();
      $bodyJson = json_decode($bodyContents, true);
      $apiReleases = array_map(array($this, 'map_api_release'), $bodyJson['data']);
      $this->_releases = array();
      foreach($apiReleases as $release){
        $this->_releases[$release['version']] = $release;
      }
      # foreach($files as $file){
      #   $basename = basename($file);
      #   $matches = [];
      #   if( preg_match('/release-([0-9]+\.[0-9]+\.[0-9]+)\.yml/', $basename,$matches) ){
      #     $release_data = Spyc::YAMLLoad($file);
      #     $this->_releases[$matches[1]] = $release_data;
      #   }
      # }
    }

    /**
     * @param string $version
     * @param string $file_basename
     * @param array $flags boolean flags, defaults: array('use_pro' => false, 'use_svg' => false)
     * @return FontAwesomeResource integrity_key will be null if none is available
     */
    private function build_resource($version, $file_basename, $flags = array('use_svg' => false, 'use_pro' => false)){
      $full_url = "https://";
      $full_url .=  boolval($flags['use_pro']) ? 'pro.' : 'use.';
      $full_url .= 'fontawesome.com/releases/v' . $version . '/';

      // use the style to build the relative url lookup the relative url
      $relative_url = $flags['use_svg'] ? 'js/' : 'css/';
      $relative_url .= $file_basename . '.';
      $relative_url .= $flags['use_svg'] ? 'js' : 'css';

      $full_url .= $relative_url;

      $license = $flags['use_pro'] ? 'pro' : 'free';

      // if we can't resolve an integrity_key in this deeply nested lookup, it will remain null
      $integrity_key = null;
      if(isset($this->releases()[$version]['sri'][$license][$relative_url])){
        $integrity_key = $this->releases()[$version]['sri'][$license][$relative_url];
      }

      return(new FontAwesomeResource($full_url, $integrity_key));
    }

    protected function releases(){
      if( is_null($this->_releases) ) {
        $this->load_releases();
      }
      return $this->_releases;
    }

    /**
     * @return array simple array of versions as strings, sorted in descending semantic version order
     */
    public function versions(){
      return Semver::rsort(array_keys($this->releases()));
    }

    /**
     * @param string $version
     * @param mixed $style_opt either the string 'all' or an array containing any of the following:
     *        ['solid', 'regular', 'light', 'brands']
     * @param array $flags boolean flags, defaults: array('use_pro' => false, 'use_svg' => false, 'use_shim' => true)
     * @throws InvalidArgumentException if called with use_svg = true, use_shim = true and version < 5.1.0.
     *         shims were not introduced for webfonts until 5.1.0. Throws when called with an array for $style_opt
     *         that contains no known style specifiers.
     * @return array containing version, shim, source URLs and integrity keys.
     *         They should be loaded in the order they appear in this collection.
     */
    public function get_resource_collection($version, $style_opt, $flags = array('use_pro' => false, 'use_svg' => false, 'use_shim' => true)){
      $resources = array();

      if ($flags['use_shim'] && !$flags['use_svg'] && !Semver::satisfies($version, '>= 5.1.0')){
        throw new InvalidArgumentException("A shim was requested for webfonts in Font Awesome version < 5.1.0, " .
          "but webfont shims were not introduced until version 5.1.0."
        );
      }

      if( ! array_key_exists($version, $this->releases())){
        throw new InvalidArgumentException("Font Awesome version \"$version\" is not one of the available versions.");
      }

      if(gettype($style_opt) == 'string' && 'all' == $style_opt){
        array_push($resources, $this->build_resource($version, 'all', $flags));
        if( $flags['use_shim'] ){
          array_push($resources, $this->build_resource($version, 'v4-shims', $flags));
        }
      } elseif (is_array($style_opt)){
        // These can be added to the collection in any order.
        // Silently ignore any invalid ones, but if there are no styles, then we should die.
        $load_styles = array();
        foreach($style_opt as $style){
          switch($style){
            case 'solid':
            case 'regular':
            case 'light':
            case 'brands':
              $load_styles[$style] = true;
              break;
            default:
              error_log("WARNING: ignorning an unrecognized style specifier: " . $style);
          }
        }
        $styles = array_keys($load_styles);
        if(count($styles) == 0 )
          throw new InvalidArgumentException("No icon styles were specified to Font Awesome, so none would be loaded." .
            "If that's what you intend, then you should probably just disable the Font Awesome plugin.");

        // Add the main library first
        array_push($resources, $this->build_resource($version, 'fontawesome', $flags));

        // create a new FontAwesomeResource for each style, in any order
        foreach($styles as $style){
          array_push($resources, $this->build_resource($version, $style, $flags));
        }

        if( $flags['use_shim'] ){
          array_push($resources, $this->build_resource($version, 'v4-shims', $flags));
        }
      } else {
        throw new InvalidArgumentException('$style_opt must be either the string "all" or a collection of ' .
          'style specifiers: solid, regular, light, brands.');
      }

      return $resources;
    }

    /**
     * @return string|null most recent major.minor.patch version (not a semver). Returns null if no versions available.
     */
    public function latest_minor_release(){
      $sorted_versions = $this->versions();
      return count($sorted_versions) > 0 ? $sorted_versions[0] : null;
    }

    /**
     * @return string|null latest patch level for the previous minor version. major.minor.patch version (not a semver).
     *         Returns null if there is no latest (and therefore no previous).
     *         Returns null if there's no previous, because the latest represents the only minor version in the set
     *           of available versions.
     */
    public function previous_minor_release(){
      // Find the latest
      $latest = $this->latest_minor_release();

      if( is_null($latest)) return null;

      // Build a previous minor version semver
      $version_parts = explode('.', $latest);
      $new_minor_number = intval($version_parts[1]) - 1;
      // make sure we don't try to use a negative number
      $new_minor_number = $new_minor_number >= 0 ? $new_minor_number : 0;
      $version_parts[1] = $new_minor_number;
      $version_parts[2] = 0; // set patch level of the semver to zero
      $previous_minor_release_semver_constraint = '~' . implode('.', $version_parts);

      $satisfying_versions = Semver::rsort(
        Semver::satisfiedBy($this->versions(), $previous_minor_release_semver_constraint)
      );
      $result = count($satisfying_versions) > 0 ? $satisfying_versions[0] : null;
      return $result == $latest ? null : $result;
    }
  }

  function FontAwesomeReleaseProvider(){
    return FontAwesomeReleaseProvider::instance();
  }

endif; // ! class_exists
