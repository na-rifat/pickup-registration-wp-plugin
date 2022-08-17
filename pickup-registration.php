<?php

namespace pr;

/**
 * Plugin name: Pickup Registration
 * Plugin description: User management and pickup registration system with delivery tracking.
 * Author: Qutiest
 * Author URI: https://qutiest.com
 * DescriptioN: It's a customer pickup reservation plugin. Can handle pickup registration, manage orders, and view reports by the customers.
 */


require_once 'vendor/autoload.php';

define('PR_ASSETS_PATH', plugin_dir_path(__FILE__) . '/dist');
define('PR_ASSETS_URL', plugin_dir_url(__FILE__) . '/dist');

new Init();

register_activation_hook(__FILE__, '\pr\Activation::activate');
