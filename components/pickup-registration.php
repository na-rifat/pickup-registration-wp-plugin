<?php

    use pr\Hours;

$user = get_current_user_id()?>
<!-- Sample pickup registration -->
<section class="sample-registration pr-section">
    <div class="container">
        <div class="wrapper">
            <div class="heading">
                <h2>New pickup registration</h2>
            </div>
            <div class="form">
                <form action="#">
                    <div class="leftcol">
                        <div class="colheading">
                            <h3>Pickup Info</h3>
                        </div>
                        <table>
                            <tr>
                                <td>
                                    <label for="organization">Organization</label>
                                </td>
                                <td>
                                    <input required type="text" name="organization" id="organization"
                                        value="<?php echo get_user_meta( $user, 'user_organization', true ) ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="pickup-area">Pickup Area</label>
                                </td>
                                <td>
                                    <input required type="text" name="pickup-area" id="pickup-area"
                                        value="<?php echo get_user_meta( $user, 'pickup_area', true ) ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="request-date">Request Date</label>
                                </td>
                                <td>
                                    <input required type="date" name="request-date" id="request-date"
                                        value="<?php echo date( 'Y-m-d' ) ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="request-time">Request Time</label>
                                </td>
                                <td>
                                    <!-- <input required type="time" name="request-time" id="request-time" /> -->
                                    <input type="hidden" name="request-time" id="request-time" value="">
                                    <div class="request-date-holder">
                                        <?php
                                            $hours = new Hours();
                                            echo $hours->get_todays_hours();
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="contact-person">Contact Person</label>
                                </td>
                                <td>
                                    <input required type="text" name="contact-person" id="contact-person"
                                        value="<?php echo get_user_meta( $user, 'contact_person', true ) ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="phone">Phone</label>
                                </td>
                                <td>
                                    <input required type="tel" name="phone" id="phone"
                                        value="<?php echo get_user_meta( $user, 'phone', true ) ?>" />
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="rightcol">
                        <div class="form-holder">
                            <div class="colheading">
                                <h3>Sample Info</h3>
                            </div>
                            <table>
                                <tr>
                                    <td>
                                        <label for="sample-name">Sample Name</label>
                                    </td>
                                    <td>
                                        <input required type="text" name="sample-name[]" id="sample-name" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="sample-info">Sample Info</label>
                                    </td>
                                    <td>
                                        <input required type="text" name="sample-info[]" id="sample-info" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="condition_n">Condition</label>
                                    </td>
                                    <td>
                                        <div class="checkbox-grp">
                                            <label for="condition_nn"><input class="condition_n" type="checkbox"
                                                    name="condition[]" id="condition_n" value="N" checked />N</label>
                                            <label for="condition_yy">
                                                <input class="condition_y" type="checkbox" name="condition[]"
                                                    id="condition_y" value="Y" />
                                                Y
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="specific-info">
                                    <td>
                                        <label for="specific-info">Specific Info</label>
                                    </td>
                                    <td>
                                        <textarea name="specific-info[]" id="specific-info" cols="30"
                                            rows="3"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="surgeon">Surgeon</label>
                                    </td>
                                    <td>
                                        <input required type="text" name="surgeon[]" id="surgeon" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="operation_date">Operation Date</label>
                                    </td>
                                    <td>
                                        <input required type="date" name="operation_date" id="operation_date" />
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="add-new-sample">+ Add Sample</div>
                        <div class="agreement">
                            <div class="agreement-grp">
                                <input type="checkbox" name="agreement" id="agreement" required>
                                <label for="agreement">I agree to the terms and conditions *</label>
                            </div>
                            <div class="terms">
                                <h3>Term 1</h3>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque consectetur dicta
                                    quisquam, est sed non ex officia ab, ipsa, recusandae porro molestias tempora
                                    obcaecati praesentium ullam provident quis dolor omnis.</p>
                                <h3>Term 2</h3>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem quos dolorem
                                    veniam similique obcaecati nam odio reprehenderit doloribus assumenda quo cum
                                    consequuntur laboriosam excepturi blanditiis, placeat iste adipisci esse aliquam
                                    odit fuga in laudantium sapiente! Perferendis cum sapiente debitis animi!</p>
                            </div>
                        </div>
                        <div class="btn-grp">
                            <button type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- Sample pickup registration end-->