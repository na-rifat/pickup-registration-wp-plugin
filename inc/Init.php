<?php

namespace pr;

use ElementorPro\Modules\DynamicTags\Tags\Shortcode;
use pr\Shortcode as PrShortcode;

class Init
{
    function __construct()
    {
        add_action('plugins_loaded', [$this, 'run']);
    }

    // function fire_activation()
    // {
    //     new Activation();
    //     exit;
    // }


    function define_constants()
    {
        define('PR_JS_PATH', PR_ASSETS_PATH . '/js');
        define('PR_JS_URL', PR_ASSETS_URL . '/js');

        define('PR_CSS_PATH', PR_ASSETS_PATH . '/css');
        define('PR_CSS_URL', PR_ASSETS_URL . '/css');

        define('PR_IMG_PATH', PR_ASSETS_PATH . '/img');
        define('PR_IMG_URL', PR_ASSETS_URL . '/img');

        define('PR_FONT_PATH', PR_ASSETS_PATH . '/fonts');
        define('PR_FONT_URL', PR_ASSETS_URL . '/fonts');

        define('PR', 'pr');
    }

    function run()
    {
        $this->define_constants();
        new Assets();
        new PrShortcode();

        if (defined('DOING_AJAX') && DOING_AJAX) {
            new Ajax();
        }

        add_menu_page(__('Pickup registration'), __('Pickup registration'), 'manage_options', 'pickup-registration', [$this, 'admin_page'], 'dashicons-cart', 0);
    }

    function admin_page()
    {
        _pr_get_template('admin-orders');
    }
}
