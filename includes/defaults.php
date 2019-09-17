<?php
if (!defined('ABSPATH'))
    exit;

if (!class_exists('WPSOCCON_Options')) {

    class WPSOCCON_Options
    {

        protected static $instance;
        public $defaults;

        function defaults()
        {

            $this->defaults = array(
                'button' => array(
                    'layout' => 'button',
                    'position' => 'bottom-right',
                    'text' => esc_html__('How can I help you?', 'wp-social-connect'),
                    'icon' => 'default',
                    'phone' => '123456789012',
                ),
                'main' => array(
                    'header' => '<h3>Hello!</h3><p>Click one of our representatives below to chat on WhatsApp or send us an email to <a href="mailto:hello@quadlayers.com">hello@quadlayers.com</a></p>',
                    'footer' => '<p>Call us to <a href="tel://123456789012">123456789012</a> from <em><time>0:00hs</time></em> a <em><time>24:00hs</time></em></p>'
                ),
                'chat' => array(
                    'emoji' => 'no',
                    'response' => esc_html__('Write a response', 'wp-social-connect'),
                ),
                'contacts' => array(
                    0 => array(
                        'chat' => true,
                        'avatar' => '93',
                        'phone' => '123456789012',
                        'name' => 'John Doe',
                        'label' => esc_html__('Support', 'wp-social-connect'),
                    ),
                ),
            );

            return $this->defaults;
        }

        function wac_options($options)
        {

            if ($phone = get_option('wpsoccon_chat_page')) {
                $options['button']['phone'] = $phone;
            }

            if ($text = get_option('wpsoccon_chat_button')) {
                $options['button']['text'] = $text;
            }
            
            if ($message = get_option('wpsoccon_chat_message')) {
                $options['user']['message'] = $message;
            }

            return $options;
        }

        function options()
        {
            global $wpsoccon;

            $options = get_option(WPSOCCON_DOMAIN, $this->defaults());

            if (isset($options['button']['phone'])) {
                $options['button']['phone'] = str_replace('+', '', $options['button']['phone']);
            }
            if (isset($options['contacts'])) {
                if (count($options['contacts'])) {
                    foreach ($options['contacts'] as $id => $c) {

                        $options['contacts'][$id] = wp_parse_args($c, $this->defaults()['contacts'][0]);

                        $options['contacts'][$id]['phone'] = str_replace('+', '', $options['contacts'][$id]['phone']);
                    }
                }
            }

            // Include default args if undefined
            $wpsoccon = $this->wp_parse_args($options, $this->defaults());
        }

        function wp_parse_args(&$a, $b)
        {
            $a = (array) $a;
            $b = (array) $b;
            $result = $b;
            foreach ($a as $k => &$v) {
                if (is_array($v) && isset($result[$k])) {
                    $result[$k] = $this->wp_parse_args($v, $result[$k]);
                } else {
                    $result[$k] = $v;
                }
            }
            return $result;
        }

        function init()
        {
            add_action('init', array($this, 'options'));
            add_filter('default_option_qlwapp', array($this, 'wac_options'), 10);
        }

        public static function instance()
        {
            if (!isset(self::$instance)) {
                self::$instance = new self();
                self::$instance->defaults();
                self::$instance->init();
            }
            return self::$instance;
        }

    }
    WPSOCCON_Options::instance();
}
