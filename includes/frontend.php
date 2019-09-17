<?php
if (!class_exists('WPSOCCON_Frontend')) {

  class WPSOCCON_Frontend {

    protected static $instance;

    function add_js() {
      wp_enqueue_style(WPSOCCON_DOMAIN, plugins_url('/assets/css/wpsoccon-frontend.css', WPSOCCON_PLUGIN_FILE), null, WPSOCCON_PLUGIN_VERSION, 'all');
      wp_enqueue_script(WPSOCCON_DOMAIN, plugins_url('/assets/js/wpsoccon-frontend.js', WPSOCCON_PLUGIN_FILE), array('jquery'), WPSOCCON_PLUGIN_VERSION, true);
    }

    function add_box() {
        $contacts = get_option(WPSOCCON_DOMAIN . '-contacts');
        $header = get_option(WPSOCCON_DOMAIN . '-header');
        $footer = get_option(WPSOCCON_DOMAIN . '-footer');
        $btn_text = get_option(WPSOCCON_DOMAIN . '-button_text') == '' ? 'How Can I Help You?' : get_option(WPSOCCON_DOMAIN . '-button_text');
        $btn_color = get_option(WPSOCCON_DOMAIN . '-button_color') == '' ? '#303030' : get_option(WPSOCCON_DOMAIN . '-button_color');
        $btn_color = ($btn_color!='') ? $btn_color : '#303030';
		
		$header = ( $header!='' ) ? $header : 'Welcome Whatsup';
		$footer = ( $footer!='' ) ? $footer : 'Time : 9:00AM - 5:00PM';
        ?>
        
        <div id="wpsoccon" class="wpsoccon-main">
            <div class="wpsoccon-container">
                <div class="wpsoccon-box">
                    <div class="wpsoccon-header" style="background-color: <?php echo $btn_color; ?>;">
                        <i class="wpsoccon-close" data-action="close">×</i>
                        <div class="wpsoccon-description">
                            <?php
                                echo $header;
                            ?>
                        </div>
                    </div>
                    <div class="wpsoccon-body">
                        <?php
                            if(!empty($contacts)){
                                foreach($contacts as $c){
                                    ?>
                                    <a class="wpsoccon-account" data-phone="<?php echo $c['phone']; ?>"
                                    href="javascript:void(0);" target="_blank">
                                        <div class="wpsoccon-avatar">
                                            <div class="wpsoccon-avatar-container">
                                                <img alt="<?php echo $c['name']; ?>" src="<?php echo wp_get_attachment_url($c['attach_id']); ?>">
                                            </div>
                                        </div>
                                        <div class="wpsoccon-info">
                                            <span class="wpsoccon-label"><?php echo $c['label']; ?></span>
                                            <span class="wpsoccon-name"><?php echo $c['name']; ?></span>
                                    </div>
                                    </a>
                                    <?php
                                }
                            }else{
                    ?>
							<a class="wpsoccon-account" href="javascript:void(0);">
								<div>No Contacts Found !</div>
                            </a>
					<?php } ?>
                        
                    </div>
                    <div class="wpsoccon-footer">
                        <?php
                            echo $footer;
                        ?>
                    </div>
                </div>
                
            </div>
        </div>
        <a class="wpsoccon-toggle" href="javascript:void(0);" style="background-color: <?php echo $btn_color; ?>;">
                    <img src="<?php echo plugins_url('/assets/img/whatsapp-48.png', WPSOCCON_PLUGIN_FILE); ?>">
                    <span class="wpsoccon-text"><?php echo $btn_text; ?></span>
                </a>
        <?php
    }

    function add_frontend_css() {
     
    }

    function do_shortcode($atts, $content = null) {

      ob_start();
      return ob_get_clean();
    }

    function init() {
        add_action('wp_enqueue_scripts', array($this, 'add_js'));
        add_action('wp_head', array($this, 'add_frontend_css'), 200);
        add_action('wp_footer', array($this, 'add_box'));
        add_shortcode('whatsapp', array($this, 'do_shortcode'));
    }

    public static function instance() {
      if (!isset(self::$instance)) {
        self::$instance = new self();
        self::$instance->init();
      }
      return self::$instance;
    }

  }

  WPSOCCON_Frontend::instance();
}
