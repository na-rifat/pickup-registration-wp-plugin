<?php

namespace pr;

/***
 * Wordpress database handler class
 *
 * Makes database operations more easier
 *
 * Author: Qutiest
 * Author URI: https://qutiest.com
 * Version: 1.0
 * Developer: Nura Alam Rifat
 */
class Database {

    private $db;
    public $prefix;

    function __construct() {
        global $wpdb;

        $this->db     = $wpdb;
        $this->prefix = $this->db->prefix;
    }

    /**
     * Performs a SQL query
     *
     * @param  string  $query
     * @return mixed
     */
    public function query( $query ) {
        return $this->db->query(
            $query
        );
    }

    /**
     * Insert row into database
     *
     * @param  string  $table_name
     * @param  array   $data
     * @param  array   $data_type
     * @return mixed
     */
    public function create( $table_name, $data, $data_type ) {
        return $this->db->insert(
            $this->prefix . $table_name,
            $data,
            $data_type
        );
    }

    /**
     * Update data in database
     *
     * @param  string     $table_name
     * @param  array      $data
     * @param  string|int $id
     * @param  string     $identifier
     * @return mixed
     */
    public function update( $table_name, $data, $id, $identifier = 'id' ) {
        return $this->db->update(
            $this->prefix . $table_name,
            $data,
            [
                $identifier => $id,
            ]
        );
    }

    /**
     * Delete identified datas in database
     *
     * @param  string     $table_name
     * @param  string|int $id
     * @return mixed
     */
    public function delete( $table_name, $id, $identifier = 'id' ) {
        return $this->db->delete(
            $this->prefix . $table_name,
            [$identifier => $id]
        );
    }

    /**
     * Return list of datas
     *
     * Not paginated
     *
     * Not sorted
     *
     * @param  string  $table_name
     * @return mixed
     */
    public function get_all( $table_name ) {
        return $this->db->get_results(
            "SELECT * FROM {$this->prefix}$table_name;"
        );
    }

    public function get_all_filtered( $table_name, $id, $identifier = 'id' ) {
        return $this->db->get_results(
            "SELECT * FROM {$this->prefix}$table_name WHERE `{$identifier}`='{$id}';"
        );
    }

    /**
     * Get single row
     *
     * @param  string  $table_name
     * @param  string  $id
     * @param  string  $identifier
     * @return mixed
     */
    public function get_one( $table_name, $id = '', $identifier = 'id' ) {
        if ( ! empty( $id ) ) {
            return $this->db->get_row(
                $this->db->prepare(
                    "SELECT * FROM {$this->prefix}$table_name WHERE {$identifier}=%s",
                    $id
                )
            );
        } else {
            return $this->db->get_row(
                "SELECT * FROM {$this->prefix}$table_name",
            );
        }
    }

    public function get_paginated( $table_name, $from = 0, $to = 20 ) {}

    public function get_sorted( $table_name, $sorting_col, $sort_type = 'DESC' ) {}

    public function get_paginated_sorted( $table_name, $sorting_col, $sort_type = 'DESC', $from = 0, $to = 20 ) {}

    public function get_results( $query ) {
        return $this->db->get_results( $query );
    }

}