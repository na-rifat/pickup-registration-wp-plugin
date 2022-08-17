<?php

namespace pr;

class Shortcode
{
    function __construct()
    {
        $this->register_shortcodes();
    }

    function register_shortcodes()
    {

        add_shortcode('pickup-registration', [$this, 'pickup_registration']);
        add_shortcode('my_orders', [$this, 'my_orders']);
        add_shortcode('my_reports', [$this, 'my_reports']);
        add_shortcode('admin_orders', [$this, 'admin_orders']);
    }

    function pickup_registration()
    {
        _pr_get_template('pickup-registration');
    }

    
    function my_orders()
    {
        _pr_get_template('my-orders');
    }

    function my_reports()
    {
        _pr_get_template('my-reports');
    }


}
