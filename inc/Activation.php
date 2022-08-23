<?php

namespace pr;

class Activation
{
    static function activate()
    {

        if (!function_exists('dbDelta')) {
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        }

        global $wpdb;
        $prefix = $wpdb->prefix;

        // Pickup registration table
        $query = "CREATE TABLE IF NOT EXISTS `{$prefix}pr_orders` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `order_id` longtext NOT NULL,
            `user_id` longtext NOT NULL,
            `status` longtext NOT NULL,
            `organization` longtext NOT NULL,
            `pickup-area` longtext NOT NULL,
            `request-date` longtext NOT NULL,
            `pickup-date` longtext NOT NULL,
            `request-time` longtext NOT NULL,
            `contact-person` longtext NOT NULL,
            `phone` longtext NOT NULL,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        dbDelta($query);
        // Sample info table
        $query = "CREATE TABLE IF NOT EXISTS `{$prefix}pr_reports` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `order_id` longtext NOT NULL,
            `parent` longtext NOT NULL,
            `sample-name` longtext NOT NULL,
            `sample-info` longtext NOT NULL,
            `condition` longtext NOT NULL,
            `specific-info` longtext NOT NULL,
            `surgeon` longtext NOT NULL,
            `pdf1` longtext NOT NULL,
            `pdf2` longtext NOT NULL,
            `status` longtext NOT NULL,
            `user_id` longtext NOT NULL,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        dbDelta($query);
        // User reports
        // $query = "CREATE TABLE `{$prefix}_pr_reports` (
        //     `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        //     `order_id` longtext NOT NULL,
        //     `pickup_id` longtext NOT NULL,
        //     `contact_person` longtext NOT NULL,
        //     `phone` longtext NOT NULL,
        //     `file` longtext NOT NULL,
        //     `status` longtext NOT NULL,
        //     `user_id` longtext NOT NULL,
        //     PRIMARY KEY (`id`)
        //    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        // dbDelta($query);


        // Create pages
        self::create_page('Manage Orders', '[my_orders]');
        self::create_page('My Reports', '[my_reports]');
        self::create_page('Pickup Registration', '[pickup-registration]');
    }

    static  function create_page($title_of_the_page, $content, $parent_id = NULL)
    {
        $objPage = get_page_by_title($title_of_the_page, 'OBJECT', 'page');
        if (!empty($objPage)) {
            return;
        }

        $page_id = wp_insert_post(
            array(
                'comment_status' => 'close',
                'ping_status'    => 'close',
                'post_author'    => 1,
                'post_title'     => ucwords($title_of_the_page),
                'post_name'      => strtolower(str_replace(' ', '-', trim($title_of_the_page))),
                'post_status'    => 'publish',
                'post_content'   => $content,
                'post_type'      => 'page',
                'post_parent'    =>  $parent_id
            )
        );
    }
}
