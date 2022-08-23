<?php

namespace pr;

class Ajax {
    function __construct() {
        $this->register( 'register_pickup' );
        $this->register( 'pr_approval' );
        $this->register( 'view_detail' );
    }

    /**
     * Register action hooks to recieve AJAX requests
     *
     * @param  string $action
     * @return void
     */
    public function register( $action ) {
        add_action( "wp_ajax_nopriv_{$action}", [$this, $action] );
        add_action( "wp_ajax_{$action}", [$this, $action] );
    }

    /**
     * This function verifies nonces and keep the AJAX request protected
     *
     * @return void
     */
    public static function verify_nonce() {
        if ( ! wp_verify_nonce( pr_var( 'nonce' ), pr_var( 'action' ) ) ) {
            wp_send_json_error(
                [
                    'msg' => __( 'Invalid token!', PR ),
                ]
            );
            exit;
        }
    }

    /**
     * This function handles to create a new order
     *
     * Function pushes data to {prefix}pr_orders table
     *
     * There will be each row for an new order
     *
     * Parameters comes through $_POST method using AJAX
     *
     * @return void
     */
    public function register_pickup() {
        self::verify_nonce();

        global $wpdb;
        $prefix = $wpdb->prefix;

        $result = $wpdb->insert(
            "{$prefix}pr_orders",
            [
                'status'         => 'submitted',
                'order_id'       => '',
                'user_id'        => get_current_user_id(),
                'organization'   => pr_var( 'organization' ),
                'pickup-area'    => pr_var( 'pickup-area' ),
                'request-date'   => date( 'Y-m-d', strtotime( "today" ) ),
                'pickup-date'    => pr_var( 'request-date' ),
                'request-time'   => pr_var( 'request-time' ),
                'contact-person' => pr_var( 'contact-person' ),
                'phone'          => pr_var( 'phone' ),
            ],
            [
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
            ]
        );

        $user = get_current_user_id();
        update_user_meta( $user, 'user_organization', pr_var( 'organization' ) );
        update_user_meta( $user, 'pickup_area', pr_var( 'pickup-area' ) );
        update_user_meta( $user, 'contact_person', pr_var( 'contact-person' ) );
        update_user_meta( $user, 'phone', pr_var( 'phone' ) );

        if ( $result ) {

            $order_id  = 'ABC' . '-' . date( 'y' ) . '-' . str_pad( $wpdb->insert_id, 3, '0', STR_PAD_LEFT );
            $pickup_id = $wpdb->insert_id;

            $updated = $wpdb->update(
                "{$prefix}pr_orders",
                [
                    'order_id' => $order_id,
                ],
                [
                    'id' => $wpdb->insert_id,
                ]
            );
        }

        if ( ! empty( $_POST['sample-name'] ) ) {
            for ( $i = 0; $i < sizeof( $_POST['sample-name'] ); $i++ ) {
                $wpdb->insert(
                    "{$prefix}pr_reports",
                    [
                        'order_id'      => $order_id,
                        'parent'        => $pickup_id,
                        'sample-name'   => $_POST['sample-name'][$i],
                        'sample-info'   => $_POST['sample-info'][$i],
                        'condition'     => ! empty( $_POST['condition'][$i] ) ? $_POST['condition'][$i] : '',
                        'specific-info' => $_POST['specific-info'][$i],
                        'surgeon'       => $_POST['surgeon'][$i],
                        'pdf1'          => '',
                        'pdf2'          => '',
                        'status'        => 'submitted',
                        'user_id'       => get_current_user_id(),
                    ],
                    [
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                    ]
                );
            }
        }

        if ( $updated ) {
            wp_send_json_success( [
                'msg' => 'Successfully updated',
                'url' => site_url( 'my-orders' ),
            ] );
            exit;
        }

        wp_send_json_error(
            [
                'msg' => __( 'There was an error inserting data.' ),
            ]
        );
        exit;
    }

    function pr_approval() {
        self::verify_nonce();

        global $wpdb;
        $prefix = $wpdb->prefix;

        // Get related data
        foreach ( $_POST['orders'] as $order_id ) {
            $query = "SELECT * FROM {$prefix}pickup_info WHERE id=%d";
            $order = $wpdb->get_row( $wpdb->prepare(
                $query,
                $order_id
            ) );

            // Insert report
            $file   = $this->handle_file_upload( $_FILES['pdf_' . $order_id] );
            $status = $file == false ? 'approved' : 'completed';

            $report_exists = $wpdb->get_var(
                "SELECT COUNT(id) FROM {$prefix}pr_reports WHERE pickup_id={$order_id}"
            );

            if ( $report_exists == 1 ) {
                // $report =  $wpdb->insert(
                //     $prefix . 'pr_reports',
                //     [
                //         'order_id' => $order->order_id,
                //         'pickup_id' => $order->id,
                //         'contact_person' => $order->{'contact-person'},
                //         'phone' => $order->phone,
                //         'file' => $file !== false ? serialize($file) : 'F',
                //         'status' => $status,
                //         'user_id' => $order->user_id
                //     ],
                //     [
                //         '%s',
                //         '%s',
                //         '%s',
                //         '%s',
                //         '%s',
                //         '%s',
                //         '%s',
                //     ]
                // );

                $updated_order = $wpdb->update(
                    $prefix . 'pickup_info',
                    [
                        'status' => $status,
                    ],
                    [
                        'id' => $order->id,
                    ]
                );
            }

            $report_id = $wpdb->get_row(
                "SELECT id FROM {$prefix}pr_reports WHERE pickup_id={$order_id}"
            );
            $report_id = $report_id->id;

            if ( $file ) {
                $updated_report = $wpdb->update(
                    $prefix . 'pr_reports',
                    [
                        'file'   => serialize( $file ),
                        'status' => $status,
                    ],
                    ['id' => $report_id]
                );

                $updated_order = $wpdb->update(
                    $prefix . 'pickup_info',
                    [
                        'status' => $status,
                    ],
                    [
                        'id' => $order->id,
                    ]
                );
            }
        }
    }

    public static function handle_file_upload( $file, $atts = [] ) {
        if ( empty( $file ) ) {
            return false;
        }

        $defaults = [
            'dir' => WP_CONTENT_DIR . '/pickup-registration',
            'url' => WP_CONTENT_URL . '/pickup-registration',
        ];

        $atts = wp_parse_args( $atts, $defaults );

        $result = [];

        $result['tmp_name']     = $file['tmp_name'];
        $result['upload_name']  = $file['name'];
        $result['type']         = $file['type'];
        $result['size']         = $file['size'];
        $result['ext']          = strtolower( explode( '.', $file['name'] )[sizeof( explode( '.', $file['name'] ) ) - 1] );
        $result['name']         = explode( '.', $file['name'] )[0];
        $result['storage_name'] = wp_unique_filename( $atts['dir'], $result['name'] . '.' . $result['ext'] );
        $result['dir']          = str_replace( '\\', '/', $atts['dir'] . $result['storage_name'] );
        $result['url']          = $atts['url'] . $result['storage_name'];
        $result['uploaded_at']  = time();

        move_uploaded_file( $result['tmp_name'], $result['dir'] );

        return $result;
    }

    function view_detail() {
        self::verify_nonce();

        wp_send_json_success( [
            'detail' => pr_get_template( 'ajax-sample-detail' ),
        ] );
        exit;
    }
}
