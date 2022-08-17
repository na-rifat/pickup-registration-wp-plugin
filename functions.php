<?php

if (!function_exists('pr_get_template')) {
    function pr_get_template($template_dir)
    {
        ob_start();
        include 'components/' . $template_dir . '.php';
        return ob_get_clean();
    }
}

if (!function_exists('_pr_get_template')) {
    function _pr_get_template($template_dir)
    {
        echo pr_get_template($template_dir);
    }
}


if (!function_exists('pr_var')) {
    function pr_var($name, $type = 'string')
    {
        return !empty($_REQUEST[$name]) ? $_REQUEST[$name] : '';
    }
}
