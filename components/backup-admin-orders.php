<?php
global $wpdb;
$prefix = $wpdb->prefix;
$pickup_info_table = $prefix . 'pickup_info';
$sample_info_table = $prefix . 'sample_info';
$reports_table =  $prefix . 'pr_reports';

$new_orders = $wpdb->get_results(
    $wpdb->prepare(
        "SELECT * FROM $pickup_info_table WHERE status=%s;",
        'submitted'
    )
);

$orders = $wpdb->get_results(
    $wpdb->prepare(
        "SELECT * FROM $pickup_info_table;"
    )
)
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
                    <?php foreach ($new_orders as $order) { ?>
                        <tr data-id="<?php echo $order->id ?>">
                            <td data-id="<?php echo $order->id ?>"><input type="checkbox" name="approve_list[]" id="approve_list" class="approve-order-selection"></td>
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
                                    $wpdb->prepare(
                                        "SELECT `sample-name` FROM {$wpdb->prefix}sample_info WHERE pickup_id=%s",
                                        $order->id
                                    )
                                );

                                $sample_list = [];

                                foreach ($samples as $sample) {
                                    $sample_list[] = $sample->{'sample-name'};
                                }

                                echo implode(', ', $sample_list);
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="btn-grp">
                <div class="approve-orders-btn">Approve Selected Orders</div>
            </div>
        </div>
        <div class="wrapper">
            <div class="heading">
                <!-- <h2>View all my order: Customer Page</h2> -->
                <div class="colheading">
                    <h3>Manage orders</h3>
                </div>
            </div>
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
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders   as $order) { ?>
                        <tr>
                            <td class="<?php echo $order->status ?>"><?php echo ucfirst($order->status) ?></td>
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
                                    $wpdb->prepare(
                                        "SELECT COUNT(*) FROM {$wpdb->prefix}sample_info WHERE pickup_id=%s",
                                        $order->id
                                    )
                                );

                                echo $sample_count;
                                ?>
                            </td>
                            <td>
                                <?php
                                $samples = $wpdb->get_results(
                                    $wpdb->prepare(
                                        "SELECT `sample-name` FROM {$wpdb->prefix}sample_info WHERE pickup_id=%s",
                                        $order->id
                                    )
                                );
                                $sample_list = [];

                                foreach ($samples as $sample) {
                                    $sample_list[] = $sample->{'sample-name'};
                                }

                                echo implode(', ', $sample_list);
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<section class="sample-modal">
    <div class="container">
        <div class="wrapper">
            <h2>Approval review and file submission</h2>
            <form action="#" class="approval-form" id="approval-form">
                <ul class="review-list">
                    <?php foreach ($new_orders as $order) { ?>
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
                                $samples = $wpdb->get_results(
                                    $wpdb->prepare(
                                        "SELECT `sample-name` FROM {$wpdb->prefix}sample_info WHERE pickup_id=%s",
                                        $order->id
                                    )
                                );

                                $sample_list = [];

                                foreach ($samples as $sample) {
                                    $sample_list[] = $sample->{'sample-name'};
                                }

                                echo implode(', ', $sample_list);
                                ?>
                            </p>
                            <p><label for="pdf"><span>Upload PDF sample file</span><input type="file" name="pdf_<?php echo $order->id ?>" id="pdf"></label></p>
                        </li>
                    <?php } ?>

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