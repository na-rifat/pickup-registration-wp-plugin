<?php
    global $wpdb;
    $prefix            = $wpdb->prefix;
    $pickup_info_table = $prefix . 'pickup_info';
    $sample_info_table = $prefix . 'sample_info';
    $reports_table     = $prefix . 'pr_reports';

    // $query      = ;
    $new_orders = $wpdb->get_results(
        "SELECT * FROM {$prefix}pr_orders WHERE status='submitted';"
    );

    // Process orders data
    if ( ! isset( $_GET['sorting'] ) ) {
        $orders = $wpdb->get_results(
            "SELECT * FROM {$prefix}pr_orders;"
        );
    } else {
        $orders = $wpdb->get_results(
            "SELECT * FROM {$prefix}pr_orders ORDER BY '{$_GET['sorting']}' ASC"
        );
    }
?>
<!-- View orders Customer page -->
<section class="customer-orders pr-section admin-orders">
    <div class="container">
        <div class="wrapper">
            <div class="heading">
                <!-- <h2>View all my order: Customer Page</h2> -->
                <div class="colheading">
                    <h3>New orders</h3>
                </div>
            </div>
            <?php if ( empty( $new_orders ) ) {?>
            <h4>No new orders found!</h4>
            <?php } else {?>
            <table class="pr-table">
                <thead>
                    <tr>
                        <th>Select</th>
                        <th>Order #</th>
                        <th>Request Date</th>
                        <th>Organization</th>
                        <th>Pickup Date</th>
                        <th>Time</th>
                        <th>Contact</th>
                        <th>Phone</th>
                        <th>Sample info</th>
                        <!-- <th>Condition</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $new_orders as $order ) {?>
                    <tr data-id="<?php echo $order->id ?>">
                        <td data-id="<?php echo $order->id ?>"><input type="checkbox" name="approve_list[]"
                                id="approve_list" class="approve-order-selection"></td>
                        <td><?php echo $order->order_id ?></td>
                        <td><?php echo $order->{'request-date'} ?></td>
                        <td><?php echo $order->organization ?></td>
                        <td><?php echo $order->{'pickup-date'} ?></td>
                        <td><?php echo $order->{'request-time'} ?></td>
                        <td><?php echo $order->{'contact-person'} ?></td>
                        <td><?php echo $order->phone ?></td>
                        <td>
                            <?php
                                $samples = $wpdb->get_results(
                                    "SELECT `sample-name` FROM {$prefix}pr_reports WHERE parent={$order->id}"
                                );

                                    $sample_list = [];

                                    foreach ( $samples as $sample ) {
                                        $sample_list[] = $sample->{'sample-name'};
                                    }

                                    echo implode( ', ', $sample_list );
                                ?>
                        </td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
            <div class="btn-grp">
                <div class="delete-orders-btn">Delete Selected Orders</div>
                <div class="approve-orders-btn">Approve Selected Orders</div>
            </div>
            <?php }?>
        </div>
        <div class="wrapper">
            <div class="heading">
                <!-- <h2>View all my order: Customer Page</h2> -->
                <div class="colheading">
                    <h3>Manage orders</h3>
                </div>
            </div>
            <?php if ( empty( $orders ) ) {?>

            <h4>No orders found!</h4>

            <?php } else {?>

            <table class="pr-table">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Order #</th>
                        <th>Request Date</th>
                        <th>Organization</th>
                        <th>Pickup Date</th>
                        <th>Time</th>
                        <th>Contact</th>
                        <th>Phone</th>
                        <th>Qt.</th>
                        <th>Sample info</th>
                        <th>Submitted PDF</th>
                        <th>Report</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $orders as $order ) {?>
                    <tr data-id="<?php echo $order->id ?>">
                        <td class="<?php echo $order->status ?>"><?php echo ucfirst( $order->status ) ?></td>
                        <td><?php echo $order->order_id ?></td>
                        <td><?php echo $order->{'request-date'} ?></td>
                        <td><?php echo $order->organization ?></td>
                        <td><?php echo $order->{'pickup-date'} ?></td>
                        <td><?php echo $order->{'request-time'} ?></td>
                        <td><?php echo $order->{'contact-person'} ?></td>
                        <td><?php echo $order->phone ?></td>
                        <td>
                            <?php
                                $sample_count = $wpdb->get_var(
                                    "SELECT COUNT(*) FROM {$prefix}pr_reports WHERE parent={$order->id}"
                                );
                                    echo $sample_count;
                                ?>
                        </td>
                        <td>
                            <?php

                                    $samples = $wpdb->get_results(
                                        "SELECT `sample-name` FROM {$prefix}pr_reports WHERE parent={$order->id}"
                                    );
                                    $sample_list = [];

                                    foreach ( $samples as $sample ) {
                                        $sample_list[] = $sample->{'sample-name'};
                                    }

                                    echo implode( ', ', $sample_list );
                                ?>
                        </td>
                        <?php
                            if ( $order->status == 'completed' ) {
                                    $report = $wpdb->get_row(
                                        "SELECT file from {$prefix}pr_reports WHERE parent={$order->id}"
                                    );

                                    $file = unserialize( $report->file );
                                    printf( '<td class="tcenter"><a href="%s" download="%s">%s</a></td>', $file['url'], $file['upload_name'], 'PDF' );
                                } else {
                                    printf( '<td class="tcenter">In progress</td>' );
                                }

                            ?>
                        <td><a href="#" class="open-order" data-id="<?php echo $order->id ?>">Open</a></td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
            <div class="sorting-holder">

                <form action="<?php echo admin_url( 'admin.php?page=pickup-registration' ) ?>" method="GET">
                    <input type="hidden" name="page" value="pickup-registration">
                    <select name="sorting" id="sorting">
                        <option value="" disabled selected>Sort By</option>
                        <option value="pickup-date"
                            <?php echo isset( $_GET['sorting'] ) && $_GET['sorting'] == 'pickup-date' ? 'selected' : '' ?>>
                            Pickup
                            Date</option>
                        <option value="request-date"
                            <?php echo isset( $_GET['sorting'] ) && $_GET['sorting'] == 'request-date' ? 'selected' : '' ?>>
                            Request Date</option>
                        <option value="sample_info"
                            <?php echo isset( $_GET['sorting'] ) && $_GET['sorting'] == 'sample_info' ? 'selected' : '' ?>>
                            Sample
                            info</option>
                        <option value="status"
                            <?php echo isset( $_GET['sorting'] ) && $_GET['sorting'] == 'status' ? 'selected' : '' ?>>
                            Status</option>
                    </select>
                </form>
                <?php }?>
            </div>
        </div>
    </div>
</section>

<section class="sample-modal">
    <div class="container">
        <div class="wrapper">
            <h2>Approval review</h2>
            <form action="#" class="approval-form" id="approval-form">
                <ul class="review-list">
                    <?php foreach ( $orders as $order ) {?>
                    <li data-id="<?php echo $order->id ?>">
                        <h5><strong>Order: </strong> <?php echo $order->order_id ?></h5>
                        <p><strong>Request date: </strong><?php echo $order->{'request-date'} ?></p>
                        <p><strong>Organization: </strong><?php echo $order->organization ?></p>
                        <p><strong>Pickup date: </strong><?php echo $order->{'pickup-date'} ?></p>
                        <p><strong>Request time: </strong><?php echo $order->{'request-time'} ?></p>
                        <p><strong>Contact: </strong><?php echo $order->{'contact-person'} ?></p>
                        <p><strong>Phone: </strong><?php echo $order->{'phone'} ?></p>
                        <p><strong>Sample info: </strong>
                            <?php
                                $query   = "SELECT `sample-name` FROM {$prefix}pr_reports WHERE parent=%s";
                                    $samples = $wpdb->get_results(
                                        $wpdb->prepare(
                                            $query,
                                            $order->id,
                                        )
                                    );

                                    $sample_list = [];

                                    foreach ( $samples as $sample ) {
                                        $sample_list[] = $sample->{'sample-name'};
                                    }

                                    echo implode( ', ', $sample_list );
                                ?>
                        </p>
                        <p><label for="pdf"><span>Upload PDF sample file 1</span><input type="file"
                                    name="pdf1_<?php echo $order->id ?>" id="pdf"></label></p>
                        <p><label for="pdf"><span>Upload PDF sample file 2</span><input type="file"
                                    name="pdf2_<?php echo $order->id ?>" id="pdf"></label></p>
                    </li>
                    <?php }?>

                </ul>
            </form>
            <div class="btn-grp">
                <div class="btn-cancel">Cancel</div>
                <div class="btn-confirm">Approve</div>
            </div>
        </div>
    </div>
</section>
<!-- View orders Customer page end -->