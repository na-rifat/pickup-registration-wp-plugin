        <?php
        global $wpdb;

        $orders = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM {$wpdb->prefix}pickup_info WHERE user_id=%s",
                get_current_user_id()
            )
        );
        ?>
        <!-- View orders Customer page -->
        <section class="customer-orders pr-section">
            <div class="container">
                <div class="wrapper">
                    <div class="heading">
                        <!-- <h2>View all my order: Customer Page</h2> -->
                        <div class="colheading">
                            <h3>My orders</h3>
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
                                <th>Sample</th>
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
        <!-- View orders Customer page end -->