  <?php $user =  get_current_user_id() ?>
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
                                      <input type="text" name="organization" id="organization" value="<?php echo get_user_meta($user, 'organization', true) ?>" />
                                  </td>
                              </tr>
                              <tr>
                                  <td>
                                      <label for="pickup-area">Pickup Area</label>
                                  </td>
                                  <td>
                                      <input type="text" name="pickup-area" id="pickup-area" value="<?php echo get_user_meta($user, 'pickup_area', true) ?>" />
                                  </td>
                              </tr>
                              <tr>
                                  <td>
                                      <label for="request-date">Request Date</label>
                                  </td>
                                  <td>
                                      <input type="date" name="request-date" id="request-date" />
                                  </td>
                              </tr>
                              <tr>
                                  <td>
                                      <label for="request-time">Request Time</label>
                                  </td>
                                  <td>
                                      <input type="time" name="request-time" id="request-time" />
                                  </td>
                              </tr>
                              <tr>
                                  <td>
                                      <label for="contact-person">Contact Person</label>
                                  </td>
                                  <td>
                                      <input type="text" name="contact-person" id="contact-person" value="<?php echo get_user_meta($user, 'contact_person', true) ?>" />
                                  </td>
                              </tr>
                              <tr>
                                  <td>
                                      <label for="phone">Phone</label>
                                  </td>
                                  <td>
                                      <input type="tel" name="phone" id="phone" value="<?php echo get_user_meta($user, 'phone', true) ?>" />
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
                                          <input type="text" name="sample-name[]" id="sample-name" />
                                      </td>
                                  </tr>
                                  <tr>
                                      <td>
                                          <label for="sample-info">Sample Info</label>
                                      </td>
                                      <td>
                                          <input type="text" name="sample-info[]" id="sample-info" />
                                      </td>
                                  </tr>
                                  <tr>
                                      <td>
                                          <label for="condition_n">Condition</label>
                                      </td>
                                      <td>
                                          <div class="checkbox-grp">
                                              <label for="condition_n"><input type="checkbox" name="condition[]" id="condition_n" value="N" />N</label>
                                              <label for="condition_y">
                                                  <input type="checkbox" name="condition[]" id="condition_y" value="Y" />
                                                  Y
                                              </label>
                                          </div>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td>
                                          <label for="specific-info">Specific Info</label>
                                      </td>
                                      <td>
                                          <input type="text" name="specific-info[]" id="specific-info" />
                                      </td>
                                  </tr>
                                  <tr>
                                      <td>
                                          <label for="surgeon">Surgeon</label>
                                      </td>
                                      <td>
                                          <input type="text" name="surgeon[]" id="surgeon" />
                                      </td>
                                  </tr>
                                  <tr>
                                      <td>
                                          <label for="info_phone">Phone</label>
                                      </td>
                                      <td>
                                          <input type="text" name="info_phone" id="info_phone" />
                                      </td>
                                  </tr>
                              </table>
                          </div>
                          <div class="add-new-sample">+ Add Sample</div>
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