<?php
/**
 * Plugin Name:       WP Social Connect
 * Plugin URI:        https://zypacinfotech.com
 * Description:       WP Social Connect allows your visitors to contact you or your team through WhatsApp chat with a single click.
 * Version:           1.0.0
 * Author:            Zypac
 * Author URI:        https://zypacinfotech.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-social-connect
 */
if (!defined('WPSOCCON_PLUGIN_NAME')) {
  define('WPSOCCON_PLUGIN_NAME', 'WP Social Connect');
}
if (!defined('WPSOCCON_PLUGIN_VERSION')) {
  define('WPSOCCON_PLUGIN_VERSION', '1.0.0');
}
if (!defined('WPSOCCON_PLUGIN_FILE')) {
  define('WPSOCCON_PLUGIN_FILE', __FILE__);
}
if (!defined('WPSOCCON_PLUGIN_DIR')) {
  define('WPSOCCON_PLUGIN_DIR', __DIR__ . DIRECTORY_SEPARATOR);
}
if (!defined('WPSOCCON_DOMAIN')) {
  define('WPSOCCON_DOMAIN', 'wpsoccon');
}
if (!defined('WPSOCCON_DEMO_URL')) {
  define('WPSOCCON_DEMO_URL', 'https://zypacinfotech.com/wp/whatsapp');
}
if (!class_exists('WPSOCCON')) {

    class WPSOCCON {
  
      protected static $instance;
  
      function includes() {
        include_once('includes/frontend.php');
        include_once('includes/settings.php');
      }
  
      function init() {
        // Code
      }
  
      public static function instance() {
        if (!isset(self::$instance)) {
          self::$instance = new self();
          self::$instance->includes();
          self::$instance->init();
        }
        return self::$instance;
      }
  
    }
  
    add_action('plugins_loaded', array('WPSOCCON', 'instance'));
  }