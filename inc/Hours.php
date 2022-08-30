<?php

namespace pr;

class Hours {
    private $time;
    private $available;
    private $database;
    // private $Sunday;
    // private $Monday;
    // private $Tuesday;
    // private $Wednesday;
    // private $Thursday;
    // private $Friday;
    // private $Saturday;
    const TABLE_NAME = 'pr_hours';
    const days       = [
        'Sunday',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
    ];

    function __construct() {
        $this->time      = pr_var( 'time' );
        $this->available = pr_var( 'available' ) == true ? 'on' : '';

        foreach ( self::days as $day ) {
            $this->{$day} = pr_var( $day );
        }

        $this->database = new Database();
    }

    function create() {
        $data = [
            'time'      => $this->time,
            'available' => 'on',
        ];

        $data_types = [
            '%s',
            '%s',
        ];

        foreach ( self::days as $day ) {
            $data[$day]   = pr_var( $day );
            $data_types[] = '%s';
        }

        $this->database->create(
            self::TABLE_NAME,
            $data,
            $data_types
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
                pr_var( 'selectedDay' ) => true,
                // 'available'           => 'on',
            ],
            $id
        );
    }

    function unavailable( $id ) {
        $this->database->update(
            self::TABLE_NAME,
            [
                pr_var( 'selectedDay' ) => false,
                // 'available'           => '',
            ],
            $id
        );
    }

    public function get_all() {
        return $this->database->get_all( self::TABLE_NAME );
    }

    /**
     * Return available hours for a specific day
     *
     * @return mixed|object
     */
    public function date_to_hours() {
        if ( ! empty( pr_var( 'date' ) ) ) {

            $day = date( 'l', strtotime( pr_var( 'date' ) ) );

            $hours = $this->database->get_results(
                "SELECT * FROM {$this->database->prefix}pr_hours;"
            );
            // wp_send_json_success( $_POST );exit;

            set_query_var( 'hours', $hours );

            return pr_get_template( 'ajax-available-hours' );
        } else {
            return $this->get_todays_hours();
        }
    }

    /**
     * Returns available hours for today
     *
     * @return mixed|object
     */
    public function get_todays_hours() {
        $day = date( 'l' );

        $hours = $this->database->get_results(
            "SELECT * FROM {$this->database->prefix}pr_hours;"
        );

        set_query_var( 'hours', $hours );

        return pr_get_template( 'ajax-available-hours' );
    }

    public static function get_hour( $id = '' ) {
        $self = new self();

        $id = empty( $id ) ? pr_var( 'id' ) : $id;

        return $self->database->get_one( self::TABLE_NAME, $id );
    }

    public function assign( $id ) {
        return $this->database->update(
            'pr_hours',
            [
                'available' => '',
            ],
            $id
        );
    }

    public function unassign( $id ) {
        return $this->database->update(
            'pr_hours',
            [
                'available' => 'on',
            ],
            $id
        );
    }

}