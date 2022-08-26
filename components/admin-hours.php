<?php
    $hours = New \pr\Hours();
    $hours = $hours->get_all();
?>
<section class="customer-orders pr-section admin-orders pr-hours">
    <div class="container">
        <div class="wrapper">

            <div class="new-hour">
                <h2>Add new hour</h2>
                <form action="#" id="new_hour">
                    <table>
                        <tr>
                            <th class="tright"><label for="time">Time</label></th>
                            <td><input type="time" name="time" id="time" required></td>
                        </tr>
                        <tr>
                            <th class="tright"><label for="available">Available</label></th>
                            <td><input type="checkbox" name="available" id="available" value="true" ></td>
                        </tr>

                        <tr>
                            <td></td>
                            <td><button type="submit">Save</button></td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="heading">
                <!-- <h2>View all my order: Customer Page</h2> -->
                <div class="colheading">
                    <h3>Manage hours</h3>
                </div>
            </div>
            <div class="hours">
                <?php if ( empty( $hours ) ): ?>
                <h4>There is no available hours!</h4>
                <?php else: ?>
                <table class="pr-table">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Available</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ( $hours as $hour ): ?>
                        <tr data-id="<?php echo $hour->id ?>">
                            <td class="tcenter"><?php echo $hour->time ?></td>
                            <td class="tcenter"><input type="checkbox" name="available"
                                    <?php echo $hour->available == true ? 'checked' : '' ?> class="time-availibity">
                            </td>
                            <td class="dlt-hour tcenter">DELETE</td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
                <?php endif;?>
            </div>
        </div>
    </div>
</section>


<?php _pr_get_template( 'msg-modal' );?>