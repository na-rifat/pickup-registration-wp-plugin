<?php
global  $wpdb;
$prefix =  $wpdb->prefix;
$sample_table =  $prefix . 'sample_info';
$order_id = $_POST['id'];

$query = "SELECT * FROM $sample_table WHERE pickup_id=%s";
$samples = $wpdb->get_results(
    $wpdb->prepare(
        $query,
        $order_id
    )
);

?>

<table>
    <thead>
        <tr>
            <th>Sample name</th>
            <th>Sample info</th>
            <th>Condition</th>
            <th>Specific info</th>
            <th>Surgeon</th>
            <th>Phone</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($samples as $sample) { ?>
            <tr>
                <td><?php echo $sample->{'sample-name'} ?></td>
                <td><?php echo $sample->{'sample-info'} ?></td>
                <td><?php echo $sample->{'condition'} ?></td>
                <td><?php echo $sample->{'specific-info'} ?></td>
                <td><?php echo $sample->{'surgeon'} ?></td>
                <td><?php echo $sample->{'info_phone'} ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>