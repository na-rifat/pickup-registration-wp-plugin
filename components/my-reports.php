  <?php
    global $wpdb;
    $prefix = $wpdb->prefix;
    $user_id = get_current_user_id();

    $reports = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM {$prefix}pr_reports WHERE user_id=%d",
            $user_id
        )
    );
    ?>

  <!-- View my report customer page -->
  <section class="customer-report pr-section">
      <div class="container">
          <div class="wrapper">
              <div class="heading">
                  <!-- <h2>View all my order: Customer Page</h2> -->
                  <div class="colheading">
                      <h3>My reports</h3>
                  </div>
              </div>
              <?php if (empty($reports)) { ?>
                  <h3>There is no reports.</h3>
              <?php } else { ?>
                  <table class="pr-table">
                      <thead>
                          <tr>
                              <th>Order #</th>
                              <th>O.P. Date</th>
                              <th>Contact</th>
                              <th>Phone</th>
                              <th>Sample ID</th>
                              <th>Sample Info</th>
                              <th>Download Report</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php foreach ($reports as  $report) { ?>
                              <tr data-id="<?php echo $report->pickup_id ?>">
                                  <?php
                                    $order = $wpdb->get_row("SELECT * FROM {$prefix}pickup_info WHERE id=$report->pickup_id");
                                    $file = unserialize($report->file);
                                    printf('<td>%s</td>', $report->order_id);
                                    printf('<td>%s</td>', $order->{'request-date'});
                                    printf('<td>%s</td>', $report->contact_person);
                                    printf('<td>%s</td>', $report->phone); {
                                        $samples = $wpdb->get_results(
                                            $wpdb->prepare(
                                                "SELECT `sample-name` FROM {$wpdb->prefix}sample_info WHERE pickup_id=%s",
                                                $report->pickup_id
                                            )
                                        );

                                        $sample_list = [];

                                        foreach ($samples as $sample) {
                                            $sample_list[] = $sample->{'sample-name'};
                                        }

                                        printf('<td class="tcenter">%s</td>', implode(', ', $sample_list));
                                    }

                                    printf('<td class="btn-show-detail tcenter"><i class="fa-solid fa-arrow-up-right-from-square"></i></td>');

                                    if ($report->status == 'approved') {
                                        printf('<td class="pending tcenter">In progress</td>');
                                    } elseif ($report->status == 'completed') {
                                        printf('<td class="tcenter"><a href="%s" download="%s">PDF</a></td>', $file['url'], $file['upload_name']);
                                    }
                                    ?>
                              </tr>
                          <?php } ?>
                      </tbody>
                  </table>
              <?php  } ?>
          </div>
      </div>
  </section>
  <div class="report-modal">
      <div class="wrapper">
          <div class="cls-btn">X</div>
          <div class="inner-content"></div>
      </div>
  </div>
  <!-- View my report customer page end -->