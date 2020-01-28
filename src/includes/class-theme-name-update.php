<?php
namespace Theme_Namespace;

/**
 * The updates-specific functionality of the theme.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Theme_Name
 * @subpackage Theme_Name/includes
 */

/**
 * The updates-specific functionality of the theme.
 *
 * Defines the theme name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Theme_Name
 * @subpackage Theme_Name/includes
 * @author     Your Name <email@example.com>
 */
class Theme_Name_Update {

  /**
	 * Parses the theme contents to retrieve theme's metadata.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $theme_data    Theme data. Values will be empty if not supplied by the theme.
	 */
	protected $theme_data;

  /**
   * Define the update functionality of the theme.
   *
	 * Set the theme data that can be used throughout the class.
	 *
   * @since    1.0.0
   */
  public function __construct( $theme_data ) {

      $this->theme_data = $theme_data;

  }

  /**
   * Makes a call to the update server api.
   *
   * @param $action   String  The api action to invoke on the update server
   * @param $params   array   The parameters for the api call
   * @return          array   The api response
   */
  private function call_api( $action, $params ) {
      $api_scheme = parse_url($this->theme_data->get('ThemeURI'), PHP_URL_SCHEME);
      $api_host = parse_url($this->theme_data->get('ThemeURI'), PHP_URL_HOST);

      $url = sprintf('%s://%s/wp-json/%s/%s?%s', $api_scheme, $api_host, $this->theme_data->get('TextDomain'), $action, http_build_query( $params ));

      $response = wp_remote_get( $url );

      if ( is_wp_error( $response ) ) {
          return false;
      }

      $response_body = wp_remote_retrieve_body( $response );
      $result = json_decode( $response_body );

      if( !$result->success ) {
        return false;
      }

      return $result->data;
  }

  /**
   * Checks the api response to see if there was an error.
   *
   * @param $response mixed|object    The api response to verify
   * @return bool     True if there was an error. Otherwise false.
   */
  private function is_api_error( $response ) {
      if ( $response === false ) {
          return true;
      }

      if ( ! is_object( $response ) ) {
          return true;
      }

      if ( isset( $response->error ) ) {
          return true;
      }

      return false;
  }

  /**
   * The filter that checks if there are updates to the theme
   * using the update server api.
   *
   * @param $transient    mixed   The transient used for WordPress
   *                              theme / theme updates.
   *
   * @return mixed        The transient with our (possible) additions.
   */
  public function check_for_update( $transient ) {
      if ( empty( $transient->checked ) ) {
          return $transient;
      }

      $info = $this->is_update_available();

      if ( $info !== false ) {
        $theme_slug = $this->theme_data->get_template();

        $transient->response[$theme_slug] = array(
            'new_version' => $info->version,
            'package' => $info->download_link,
            'url' => $info->description_url
        );
      }

      return $transient;
  }

    /**
     * Calls the update server to get the information for the
     * current theme version.
     *
     * @return object|bool   The theme data, or false if call fails.
     */
    public function get_info() {

        $info = $this->call_api(
            'update',
            array(
		        'email' => '',
                'license' => ''
            )
        );

        return $info;

  }

  /**
   * Checks the update server to see if there is an update available for this theme.
   *
   * @return object|bool  If there is an update, returns the theme information.
   *                      Otherwise returns false.
   */
  public function is_update_available() {
      $theme_info = $this->get_info();

      if ( $this->is_api_error( $theme_info ) ) {
          return false;
      }

      if ( version_compare( $theme_info->version, $this->theme_data->get('Version'), '<=' ) ) {
          return false;
      }

      return $plugin_info;
  }
}
