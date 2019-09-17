<?php
if (!defined('ABSPATH'))
    exit;
if (!class_exists('QLWAPP_Settings')) {

    class WPSOCCON_Settings
    {

        protected static $instance;

        function add_menu()
        {
            add_menu_page(WPSOCCON_PLUGIN_NAME, WPSOCCON_PLUGIN_NAME, 'edit_posts', WPSOCCON_DOMAIN, array($this, 'settings_welcome'), 'dashicons-share');
            add_submenu_page(WPSOCCON_DOMAIN, esc_html__('Settings', 'wp-social-connect'), esc_html__('Settings', 'wp-social-connect'), 'edit_posts', WPSOCCON_DOMAIN, array($this, 'settings_welcome'));
        }

        function settings_header()
        {
            global $submenu;
            ?>
            <div class="wrap about-wrap full-width-layout qlwrap">

                <h1><?php echo esc_html(WPSOCCON_PLUGIN_NAME); ?></h1>

                <p class="about-text">
                    <?php printf(esc_html__('Thanks for using %s! We will do our best to offer you the best and improved communication experience with your users.', 'wp-social-connect'), WPSOCCON_PLUGIN_NAME); ?>
                </p>

                <p class="about-text">
                    <?php printf('<a href="%s" target="_blank">%s</a>', WPSOCCON_DEMO_URL, esc_html__('Check out our demo', 'wp-social-connect')); ?></a>
                </p>

                <?php printf('<a href="%s" target="_blank"><div style="
                     background: #fff url(%s) no-repeat;
                     background-position: center;
                     background-size: 130px 100px;
                     color: #fff;
                     font-size: 14px;
                     text-align: center;
                     font-weight: 600;
                     margin: 5px 0 0;
                     padding-top: 120px;
                     height: 40px;
                     display: inline-block;
                     width: 140px;
                     " class="wp-badge">%s</div></a>', 'https://zypacinfotech.com', plugins_url('/assets/img/zypac-logo.png', WPSOCCON_PLUGIN_FILE), esc_html__('', 'wp-social-connect')); ?>

            </div>
            <?php
                        if (isset($submenu[WPSOCCON_DOMAIN])) {
                            if (is_array($submenu[WPSOCCON_DOMAIN])) {
                                ?>
                    <div class="wrap about-wrap full-width-layout qlwrap">
                        <h2 class="nav-tab-wrapper">
                            <?php
                              foreach ($submenu[WPSOCCON_DOMAIN] as $tab) {
                                if (strpos($tab[2], '.php') !== false)
                                   continue;
                            ?>
                                <a href="<?php echo admin_url('admin.php?page=' . esc_attr($tab[2])); ?>" class="nav-tab<?php echo (isset($_GET['page']) && $_GET['page'] == $tab[2]) ? ' nav-tab-active' : ''; ?>"><?php echo $tab[0]; ?></a>
                            <?php
                                 }
                            ?>
                        </h2>
                    </div>
            <?php
                            }
                        }
                    }

                    function settings_sanitize($settings)
                    {

                        if (isset($settings['button']['layout'])) {
                            $settings['button']['layout'] = sanitize_html_class($settings['button']['layout']);
                        }
                        if (isset($settings['button']['position'])) {
                            $settings['button']['position'] = sanitize_html_class($settings['button']['position']);
                        }
                        if (isset($settings['button']['text'])) {
                            $settings['button']['text'] = sanitize_text_field($settings['button']['text']);
                        }

                        if (isset($settings['button']['icon'])) {
                            $settings['button']['icon'] = sanitize_html_class($settings['button']['icon']);
                        }
                        if (isset($settings['box']['header'])) {
                            $settings['box']['header'] = wp_kses_post($settings['box']['header']);
                        }
                        if (isset($settings['box']['footer'])) {
                            $settings['box']['footer'] = wp_kses_post($settings['box']['footer']);
                        }
                        if (isset($settings['contacts'])) {
                            if (count($settings['contacts'])) {
                                foreach ($settings['contacts'] as $id => $c) {
                                    $settings['contacts'][$id]['chat'] = (bool) $settings['contacts'][$id]['chat'];
                                    $settings['contacts'][$id]['avatar'] = sanitize_text_field($settings['contacts'][$id]['avatar']);
                                    $settings['contacts'][$id]['phone'] = sanitize_text_field($settings['contacts'][$id]['phone']);
                                    $settings['contacts'][$id]['firstname'] = sanitize_text_field($settings['contacts'][$id]['firstname']);
                                    $settings['contacts'][$id]['lastname'] = sanitize_text_field($settings['contacts'][$id]['lastname']);
                                    $settings['contacts'][$id]['label'] = sanitize_text_field($settings['contacts'][$id]['label']);
                                    $settings['contacts'][$id]['message'] = wp_kses_post($settings['contacts'][$id]['message']);
                                    $settings['contacts'][$id]['timeto'] = wp_kses_post($settings['contacts'][$id]['timeto']);
                                }
                            }
                        }

                        return $settings;
                    }

                    function settings_welcome()
                    {

                        global $wpsoccon;
                        ?>
            <?php $this->settings_header(); ?>
            <div class="wrap about-wrap full-width-layout qlwrap">
                <?php include_once('pages/main.php'); ?>
            </div>
<?php
        }

        function add_css()
        {
            wp_enqueue_style( 'wp-color-picker');
        }


        function add_js()
        {
            if (isset($_GET['page']) && strpos($_GET['page'], WPSOCCON_DOMAIN) !== false) {
                wp_enqueue_media();
				wp_enqueue_script( 'wp-color-picker');
                wp_enqueue_script('wpsoccon-admin', plugins_url('/assets/js/wpsoccon-main.js', WPSOCCON_PLUGIN_FILE), array('jquery'), WPSOCCON_PLUGIN_VERSION, true);
            }
        }

        function init()
        {
            add_action('admin_enqueue_scripts', array($this, 'add_js'));
            add_action('admin_head', array($this, 'add_css'));
            add_action('admin_menu', array($this, 'add_menu'));
        }

        public static function instance()
        {
            if (!isset(self::$instance)) {
                self::$instance = new self();
                self::$instance->init();
            }
            return self::$instance;
        }
    }

    WPSOCCON_Settings::instance();
}
