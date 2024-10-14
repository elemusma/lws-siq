<?php

/**
 * Change collection label to Store Pickup.
 *
 * @param array $labels Labels.
 *
 * @return array
 */
function iconic_wds_change_collection_label( $labels ) {
	$labels['collection']['details']           = 'Store Pickup Details';
	// $labels['delivery']['details']           = 'Store Delivery Details';
	$labels['delivery']['date']              = 'Choose Delivery Date';
	$labels['collection']['date']              = 'Choose Pickup Date';
	// $labels['collection']['select_date']       = 'Select a Pickup date';
	// $labels['collection']['choose_date']       = 'Please choose a date for your pickup.';
	// $labels['collection']['select_date_first'] = 'Please select a date first...';
	// $labels['collection']['time_slot']         = 'Time Slot';
	// $labels['collection']['choose_time_slot']  = 'Please choose a time slot for your pickup.';

	return $labels;
}
add_filter( 'iconic_wds_labels_by_type', 'iconic_wds_change_collection_label' );

?>