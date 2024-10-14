<?php
/*
* Import/Export Setting Page.
*/
$args = array(
	'numberposts' => -1,
	'post_type'   => 'tier-rules',
	'post_status'  =>'publish',
);

$tiers = get_posts( $args );
$types = array(
	'range', 'fix', 'qty',
);

if ( isset( $_GET['sub_section'] ) && 'wtp_export' === sanitize_text_field( $_GET['sub_section'] ) ) {
	$sub_section = 'two';
} else {
	$sub_section = 'one';
}
?>
<ul class="wtp-inside-subtabs subsubsub " style="display:none">
	<li><a href="<?php echo esc_url( admin_url('admin.php?page=wc-settings&tab=tier_pricing&section=wtp_import_and_export&sub_section=wtp_import') ); ?>" <?php echo ( 'one' === $sub_section ) ? 'class="current"' : ''; ?> ><?php echo esc_html__( 'Import', 'wtp' ); ?></a> | </li>
	<li><a href="<?php echo esc_url( admin_url('admin.php?page=wc-settings&tab=tier_pricing&section=wtp_import_and_export&sub_section=wtp_export') ); ?>" <?php echo ( 'two' === $sub_section ) ? 'class="current"' : ''; ?> ><?php echo esc_html__( 'Export', 'wtp' ); ?></a></li>
</ul>
<br class="clear">
<table class="form-table">
	<tbody>		
	<?php

	if ( 'one' === $sub_section ) { // This will show  Import Settings
		?>
		<input type="hidden" id="wtp_type" name="wtp_type" value="wtp_import_csv">
		<input type="hidden" name="action" value="wtp_import_data">
		<input type="hidden" name="_wtp_nonce" value="<?php echo esc_attr( wp_create_nonce('wtp_import_csv') ); ?>">
		<tr valign="top">
			<th>
				<?php esc_html_e( 'Import Tier', 'wtp' ); ?>
			</th>
			<td>
				<select id="select_import_type" name="tier_to_import">
					<option value="">--Select Tier Type--</option>
					<?php foreach ( $types as $key => $value ) : ?>
						<option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html__( ucfirst( $value ), 'wtp' ); ?></option>
					<?php endforeach; ?>
				</select>
				<p><?php esc_html_e( 'Select type to import data for sample file', 'wtp' ); ?></p>
			</td>
		</tr>
		<tr valign="top" class="tier-sample" style="display:none;">
			<th scope="row" class="titledesc">
				<label for="wtp_display_type"><?php echo esc_html__('Sample', 'wtp'); ?></label>
			</th>
			<td class="forminp forminp-select">
				<span id="wtp_sample_csv">
					<?php printf( '%1$s <a href="%2$s" download>%3$s</a> %4$s', esc_html__('Click here to dowload the', 'wtp'), '#', esc_html__('Sample CSV', 'wtp'), esc_html__('file.', 'wtp') ); ?>						
				</span>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row" class="titledesc">
				<label for="wtp_display_type"><?php echo esc_html__('Upload File', 'wtp'); ?></label>
			</th>
			<td class="forminp forminp-select">
				<div class="drop-zone">
					<span class="drop-zone__prompt"><?php echo esc_html__( 'Drop file here or click to upload', 'wtp' ); ?></span>
					<input type="file" name="wtp_import_csv" id="wtp_import_csv" class="drop-zone__input">
				 </div><br>
				 <?php /* translators: %1$s contains <br> tags*/ ?>
				 <strong class="wtp-note"><?php printf( esc_html__( 'Only CSV format supported. %1$s Max file size is 5MB', 'wtp' ), '<br><br>' ); ?></strong>

				<div id="wtp_message"></div>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row" class="titledesc"></th>		
			<td class="forminp forminp-select">
				<input type="submit" id="import_runner" value="<?php echo esc_html__('Import Data', 'wtp'); ?>" class="button button-primary" />
			</td>
		</tr>
		<?php
	} else { // This will show Export Settings
		?>
		<input type="hidden" id="wtp_type" name="wtp_type" value="wtp_export_csv">
		<input type="hidden" name="action" value="wtp_export_data">
		<input type="hidden" name="_wtp_nonce" value="<?php echo esc_attr( wp_create_nonce('wtp_export_csv') ); ?>">
		<tr>  
			<th>
				<?php esc_html_e( 'Export Tier', 'wtp' ); ?>
			</th>
			<td>
				<select id="select_import_type" name="tier_to_export">
					<option value="">--Select a Tier to export --</option>
					<?php foreach ( $tiers as $key => $value ) : ?>
						<option value="<?php echo esc_attr( $value->ID ); ?>"><?php echo esc_html( $value->post_title ); ?></option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>
		<tr valign="top">
			<th></th>	
			<td class="forminp forminp-select">
				<input type="submit" id="export_runner" value="<?php echo esc_html__('Export Data', 'wtp'); ?>" class="button button-primary" /><br>

				<div id="wtp_message"></div>
			</td>			
		</tr>
		<?php
	}

	?>
	</tbody>
</table>
<?php
return array();
