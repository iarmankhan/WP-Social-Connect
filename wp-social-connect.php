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

if (!class_exists('WPSOCCON')) {

    class WPSOCCON {
  
      protected static $instance;
  
      function includes() {
        include_once('includes/defaults.php');
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