<?php
$hours = get_query_var( 'hours' );
$day   = date( 'l', strtotime( ! empty( pr_var( 'date' ) ) ? pr_var( 'date' ) : 'today' ) );

echo '<ul class="customer-times">';
foreach ( $hours as $hour ) {
    printf( '<li data-id="%s" class="%s">%s</li>', $hour->id, $hour->{$day} == true && $hour->available == true ? 'available' : 'unavailable', $hour->time );
}
echo '</ul>';
?>