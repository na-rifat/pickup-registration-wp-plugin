<?php

namespace pr;

class Hours {
    private $time;
    private $available;
    private $database;
    const TABLE_NAME = 'pr_hours';

    function __construct() {
        $this->time      = pr_var( 'time' );
        $this->available = pr_var( 'available' ) == 'on' ? 'true' : false;
        $this->database  = new Database();
    }

    function create() {
        $this->database->create(
            self::TABLE_NAME,
            [
                'time'      => $this->time,
                'available' => $this->available,
            ],
            [
                '%s',
                '%s',
            ]
        );
    }

    function delete( $id ) {
        $this->database->delete(
            self::TABLE_NAME,
            $id
        );
    }

    function available( $id ) {
        $this->database->update(
            self::TABLE_NAME,
            [
                'available' => true,
            ],
            $id
        );
    }

    function unavailable( $id ) {
        $this->database->update(
            self::TABLE_NAME,
            [
                'available' => false,
            ],
            $id
        );
    }

    public function get_all() {
        return $this->database->get_all( self::TABLE_NAME );
    }

}