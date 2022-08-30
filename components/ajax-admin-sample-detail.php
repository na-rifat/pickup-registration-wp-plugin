<?php
    global $wpdb;
    $prefix       = $wpdb->prefix;
    $report_table = $prefix . 'pr_reports';
    $order_id     = $_POST['id'];

    $query  = "SELECT * FROM $report_table WHERE id=%s";
    $report = $wpdb->get_row(
        $wpdb->prepare(
            $query,
            $order_id
        )
    );

?>

<form action="#" id="report-form">
    <table>
        <thead>
            <tr>
                <th>Sample name</th>
                <td><?php echo $report->{'sample-name'} ?></td>
            </tr>
            <tr>
                <th>Sample ID_AB</th>
                <td><input type="text" name="sample_id" id="sample_id" value="<?php echo $report->sample_id ?>"></td>
            </tr>
            <tr>
                <th>Sample info</th>
                <td><?php echo $report->{'sample-info'} ?></td>
            </tr>
            <tr>
                <th>Infection</th>
                <td><?php echo $report->condition ?></td>
            </tr>
            <tr>
                <th>Specific Info</th>
                <td>
                    <textarea name="specific-info" id="specific-info" cols="30"
                        rows="5"><?php echo $report->{'specific-info'} ?></textarea>
                </td>
            </tr>
            <tr>
                <th>Surgeon</th>
                <td><?php echo $report->surgeon ?></td>
            </tr>
            <tr>
                <th>Report</th>
                <td>
                    <!-- PDF1 -->
                    <?php if ( ! empty( $report->pdf1 ) ): ?>
<?php $pdf1 = unserialize( $report->pdf1 )?>
                    <p><a href="<?php echo $pdf1['url'] ?>" target="_blank">Preview PDF1</a><span class="dlt-file"
                            data-file="pdf2" data-id="<?php echo $report->id ?>">Delete</span></p>
                    <?php endif;?>
                    <!-- PDF2 -->
                    <?php if ( ! empty( $report->pdf2 ) ): ?>
<?php $pdf2 = unserialize( $report->pdf2 )?>
                    <p><a href="<?php echo $pdf2['url'] ?>" target="_blank">Preview PDF2</a><span class="dlt-file"
                            data-file="pdf2" data-id="<?php echo $report->id ?>">Delete</span></p>
                    <?php endif;?>

                    <?php if ( empty( $report->pdf1 ) || empty( $report->pdf2 ) ) {?>
                    <p class="file-uploader"><label for="pdf"><span>Upload PDF sample file</span>&nbsp;<input type="file"
                                name="file" id="file"></label></p>
                    <?php }?>
                </td>
            </tr>
            <tr>
                <th>Comments</th>
                <td>
                    <ul class="comments">
                        <?php $comments = unserialize( $report->comments )?>
<?php foreach ( $comments as $comment ): ?>
                        <li><span class="comment-text"><?php echo $comment['text'] ?></span><span
                                class="comment-meta">(<?php echo $comment['user'] ?>&nbsp;&nbsp;<?php echo $comment['datetime'] ?>)</span>
                        </li>
                        <?php endforeach;?>
                    </ul>
                    <textarea name="comment" id="comment" cols="30" rows="5"></textarea>
                </td>
            </tr>
        </thead>
    </table>
    <div class="btn-grp">
        <input type="hidden" name="id" value="<?php echo $report->id ?>">
        <button class="update-report" type="submit">
            Update
        </button>
    </div>
</form>