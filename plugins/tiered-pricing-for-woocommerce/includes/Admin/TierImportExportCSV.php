<?php 
namespace Wpexperts\TierPricingForWoocommerce\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class TierImportExportCSV {

	/**
	 * Constructor
	 */
	public function __construct() { 
		// export csv file
		add_action( 'wp_ajax_wtp_export_data', array( $this, 'wtp_export_data' ) );

		// import csv file 
		add_action( 'wp_ajax_wtp_import_data', array( $this, 'wtp_import_data' ) );
		add_action( 'wp_ajax_wtp_start_importing_to_db', array( $this, 'wtp_start_importing_to_db' ) );
	}

	
	/**
	 * Export tier by type
	 */
	public function wtp_export_data() {     
		
		if ( ! isset( $_POST['_wtp_nonce'] ) ) {
			check_ajax_referer('wtp_export_csv', '_wtp_nonce');
		}

		$post = $_POST;
	  
		if ( isset( $post['wtp_type'] ) && 'wtp_export_csv' === sanitize_text_field( $post['wtp_type'] ) ) {
			$error   = '';
			$success = '';

			if ( ! empty( $post['tier_to_export'] ) ) {
				$data =  array();
				$range_data = array();
				$fix_data = array();
				$qty_data = array();
				$range_header_column = array();
				$fix_header_column = array();
				$qty_header_column = array();
				$type = '';
				$tier_type = get_post_meta( $post['tier_to_export'], 'wtp_tier_type', true );
				$tier_fix_select = get_post_meta( $post['tier_to_export'], 'wtp_rule_fix_select', true );
				$tier_include_product = get_post_meta( $post['tier_to_export'], 'wtp_include_product', true );
				$tier_exclude_product = get_post_meta( $post['tier_to_export'], 'wtp_exclude_product', true );
				$tier_exclude_cat = get_post_meta( $post['tier_to_export'], 'wtp_exclude_product_cat', true );
				$tier_include_cat = get_post_meta( $post['tier_to_export'], 'wtp_include_product_cat', true );
				$users = get_post_meta( $post['tier_to_export'], 'wtp_users', true );
				$users_roles = get_post_meta( $post['tier_to_export'], 'wtp_user_roles', true );

				if ( 'tier_range' == $tier_type ) {
					$rules = get_post_meta( $post['tier_to_export'], 'wtp_tier_clone', true );
					if ( ! empty( $rules ) ) {
						foreach ( $rules as $rule ) {
							array_push(
								$range_data,
								array( 
									'ID' => $post['tier_to_export'],
									'Title' => get_the_title( $post['tier_to_export'] ),
									'include_product' => implode(',', $tier_include_product ),
									'exclude_product' => implode(',', $tier_exclude_product ),
									'include_catagory' => implode(',', $tier_include_cat ),
									'exclude_catagory' => implode(',', $tier_exclude_cat ),
									'users' => implode(',', $users ),
									'users_role' => implode(',', $users_roles ),
									'range_min_qty'  => $rule['wtp_min_qty'],
									'range_max_qty'  => $rule['wtp_max_qty'],
									'range_discount_type' => $rule['wtp_discount_type'],
									'range_discount_value' => $rule['wtp_discount_value'],
								)
							);
						}
						$range_header_column = array( 
							esc_html__( 'Minimum Quantity', 'wtp' ),
							esc_html__( 'Maximum Quantity', 'wtp' ),
							esc_html__( 'Discount Type', 'wtp' ),
							esc_html__( 'Discount Value', 'wtp' ),
							esc_html__( 'range_type', 'wtp' ),
						);
						$type = '_range_';
					}
						
				} elseif ( 'tier_fix_rule' == $tier_fix_select ) {
						$wtp_tier_fix_rule = get_post_meta( $post['tier_to_export'], 'wtp_tier_fix_clone', true );  
					if ( !empty( $wtp_tier_fix_rule ) ) {
						foreach ( $wtp_tier_fix_rule as $fix_rule ) {
							array_push(
								$fix_data,
								array( 
									'ID' => $post['tier_to_export'],
									'Title' => get_the_title( $post['tier_to_export'] ),
									'include_product' => implode(',', $tier_include_product ),
									'exclude_product' => implode(',', $tier_exclude_product ),
									'include_catagory' => implode(',', $tier_include_cat ),
									'exclude_catagory' => implode(',', $tier_exclude_cat ),
									'users' => implode(',', $users ),
									'users_role' => implode(',', $users_roles ),
									'fix_set_qty'  => $fix_rule['wtp_set_qty'],
									'fix_wtp_value' => $fix_rule['wtp_value'], 
								)
							);
						}
						$fix_header_column = array( 
							esc_html__( 'Set Quantity', 'wtp' ),
							esc_html__( 'Fixed Value', 'wtp' ),
							esc_html__( 'fix_type', 'wtp' ),
						);
						$type = '_fix_';
					}
				} else {
					$wtp_tier_qty_clone = get_post_meta( $post['tier_to_export'], 'wtp_tier_qty_clone', true );
					if ( !empty( $wtp_tier_qty_clone ) ) {
						foreach ( $wtp_tier_qty_clone as $qty_rule ) {
							array_push(
								$qty_data,
								array( 
									'ID' => $post['tier_to_export'],
									'Title' => get_the_title( $post['tier_to_export'] ),
									'include_product' => implode(',', $tier_include_product ),
									'exclude_product' => implode(',', $tier_exclude_product ),
									'include_catagory' => implode(',', $tier_include_cat ),
									'exclude_catagory' => implode(',', $tier_exclude_cat ),
									'users' => implode(',', $users ),
									'users_role' => implode(',', $users_roles ),
									'qty_min_qty'  => $qty_rule['wtp_min_qty'],
									'qty_max_value' => $qty_rule['wtp_max_qty'],
									'qty_wtp_value' => $qty_rule['wtp_value'],
								)
							);
						}
						$qty_header_column = array( 
							esc_html__( 'Minimum Quantity', 'wtp' ),
							esc_html__( 'Maximum Quantity', 'wtp' ),
							esc_html__( 'Fixed Value', 'wtp' ),
							esc_html__( 'Fix_qty_type', 'wtp' ),
						);
						$type = '_qty_';
					}
				}

				$data = array_merge( $range_data, $fix_data, $qty_data );

				if ( ! empty( $data ) ) {
					
					/**
					 * Filter wtp_change_csv_name
					 * 
					 * @since 1.0
					**/
					$file_name = str_replace( ' ', '_', apply_filters( 'wtp_change_csv_name', 'tier' . $type . 'pricing.csv' ) );

					// tell the browser it's going to be a csv file
					header( 'Content-Type: text/csv; charset=UTF-8' );
					
					// tell the browser we want to save it instead of displaying it
					header( 'Content-Disposition: attachment; filename="' . $file_name . '";' );

					$filepath = WTP_ROOT_PATH . 'exports/';
					
					if ( ! file_exists( $filepath ) ) {
						mkdir( $filepath, 0777, true );
					} elseif ( file_exists( $filepath . $file_name ) ) {
							unlink( $filepath . $file_name );
					}
					
					$output = fopen( $filepath . $file_name, 'a' );
					
					$column = array(
						esc_html__( 'ID', 'wtp' ),
						esc_html__( 'Title', 'wtp' ), esc_html__( 'Included Product', 'wtp' ),
						esc_html__( 'Excluded Product', 'wtp' ),
						esc_html__( 'Included Catagory', 'wtp' ),
						esc_html__( 'Excluded Catagory', 'wtp' ),
						esc_html__( 'Users', 'wtp' ),
						esc_html__( 'User Roles', 'wtp' ),
					);

					$header_column = array_merge( $column, $range_header_column, $fix_header_column, $qty_header_column );
					
					// save the column headers
					fputcsv( $output, $header_column );
					
					foreach ( $data as $k => $data ) {
						fputcsv( $output, $data );
					}

					// reset the file pointer to the start of the file
					fseek( $output, 0 );

					fclose( $output );

					$url     = WTP_ROOT_URL . 'exports/' . $file_name;
					/* translators: %1$s and %2$s contains anchor tags*/
					$success = sprintf( esc_html__( 'Successfully exported. Click here to dowload the exported %1$sCSV file.%2$s', 'wtp' ), '<a href="' . esc_url( $url ) . '" target="_blank">', '</a>' );
				} else {
					$error = esc_html__( 'No data found for export.', 'wtp' );
				}
			} else {
				$error = esc_html__( 'Please select tier type to be exported.', 'wtp' );
			}

			if ( '' != $error ) {
				$output = array(
					'error' => $error,
				);
			} else {
				$output = array(
					'success' => $success,
				);
			}

			echo json_encode( $output );
		}

		wp_die();
	}

	/**
	 * Files to import
	 */
	public function wtp_start_importing_to_db() {       
		if ( isset( $_POST['_wtp_nonce'] ) ) {
			check_ajax_referer('wtp_import_csv', '_wtp_nonce');
		}
		
	
		header( 'Content-type: text/html; charset=utf-8' );
		header( 'Cache-Control: no-cache, must-revalidate' );
		header( 'Pragma: no-cache' );
		
		if ( isset( $_COOKIE['csv_file_name'] ) ) {
			
			$filename = sanitize_file_name( $_COOKIE['csv_file_name'] );
			$filepath = WTP_ROOT_PATH . 'imports/';

			if ( file_exists( $filepath ) ) {

				$file_data = fopen( $filepath . $filename, 'r' );

				$tier_data = array();
				$first_row = fgetcsv( $file_data );

				$type = isset( $_POST['import_type'] ) ? sanitize_text_field( $_POST['import_type'] ) : '';
				if ( in_array( $type . '_type', $first_row ) ) {

					while ( $row = fgetcsv( $file_data ) ) {
						$post_id            = isset( $row[0] ) ? $row[0] : 0;
						$post_title         = isset( $row[1] ) ? $row[1] : '';
						$include_porduct    = isset( $row[2] ) ? explode( ',', $row[2] ) : array();
						$exclude_porduct    = isset( $row[3] ) ? explode( ',', $row[3] ) : array();
						$include_cat        = isset( $row[4] ) ? explode( ',', $row[4] ) : array();
						$exclude_cat        = isset( $row[5] ) ? explode( ',', $row[5] ) : array();
						$user               = isset( $row[6] ) ? explode( ',', $row[6] ) : array();
						$user_role          = isset( $row[7] ) ? explode( ',', $row[7] ) : array();
						$min_qty            = isset( $row[8] ) ? trim( $row[8] ) : '';
						$max_qty            = isset( $row[9] ) ? trim( $row[9] ) : '&#8734;';
						$discount_type      = isset( $row[10] ) ? trim( strtolower( $row[10] ) ) : '';
						$discount_value     = isset( $row[11] ) ? trim( $row[11] ) : '';

						if ( post_exists( $post_title ) ) {
							$tier_data[] =  array( 
								'wtp_min_qty' => $min_qty,
								'wtp_max_qty' => $max_qty,
								'wtp_discount_type' => $discount_type,
								'wtp_discount_value' => $discount_value,
							);

							update_post_meta( $post_id, 'wtp_include_product', $include_porduct );
							update_post_meta( $post_id, 'wtp_exclude_product', $exclude_porduct );
							update_post_meta( $post_id, 'wtp_tier_clone', $tier_data );
							update_post_meta( $post_id, 'wtp_include_product_cat', $include_cat );
							update_post_meta( $post_id, 'wtp_exclude_product_cat', $exclude_cat );
							update_post_meta( $post_id, 'wtp_user', $user );
							update_post_meta( $post_id, 'wtp_user_roles', $user_role );

						} else {
							// Create new tier.
							$args = array( 
								'post_title'   => $post_title,
								'post_type'    => 'tier-rules',
								'post_status'  => 'publish',

							);
							$new_postid = wp_insert_post( $args );
						   
							if ( $new_postid ) {
								update_post_meta( $new_postid, 'wtp_include_product', $include_porduct );
								update_post_meta( $new_postid, 'wtp_exclude_product', $exclude_porduct );
								update_post_meta( $new_postid, 'wtp_tier_clone', $tier_data );
								update_post_meta( $new_postid, 'wtp_include_product_cat', $include_cat );
								update_post_meta( $new_postid, 'wtp_exclude_product_cat', $exclude_cat );
								update_post_meta( $new_postid, 'wtp_user', $user );
								update_post_meta( $new_postid, 'wtp_user_roles', $user_role );
							}

						}

						if ( ob_get_level() > 0 ) {
							ob_end_flush();
						}
					}   

					echo 'success'; 

				} elseif ( in_array( $type . '_type', $first_row ) ) {
					while ( $row = fgetcsv( $file_data ) ) {
						$post_id            = isset( $row[0] ) ? $row[0] : 0;
						$post_title         = isset( $row[1] ) ? $row[1] : '';
						$include_porduct    = isset( $row[2] ) ? explode( ',', $row[2] ) : array();
						$exclude_porduct    = isset( $row[3] ) ? explode( ',', $row[3] ) : array();
						$include_cat        = isset( $row[4] ) ? explode( ',', $row[4] ) : array();
						$exclude_cat        = isset( $row[5] ) ? explode( ',', $row[5] ) : array();
						$user               = isset( $row[6] ) ? explode( ',', $row[6] ) : array();
						$user_role          = isset( $row[7] ) ? explode( ',', $row[7] ) : array();
						$set_qty            = isset( $row[8] ) ? trim( $row[8] ) : '';
						$value            = isset( $row[9] ) ? trim( $row[9] ) : '&#8734;';

						if ( post_exists( $post_title ) ) {
							$tier_data[] =  array( 
								'wtp_set_qty' => $set_qty,
								'wtp_value' => $value,
							);

							update_post_meta( $post_id, 'wtp_include_product', $include_porduct );
							update_post_meta( $post_id, 'wtp_exclude_product', $exclude_porduct );
							update_post_meta( $post_id, 'wtp_tier_fix_clone', $tier_data );
							update_post_meta( $post_id, 'wtp_include_product_cat', $include_cat );
							update_post_meta( $post_id, 'wtp_exclude_product_cat', $exclude_cat );
							update_post_meta( $post_id, 'wtp_user', $user );
							update_post_meta( $post_id, 'wtp_user_roles', $user_role );

						} else {
							// Create new tier.
							$args = array( 
							  'post_title'   => $post_title,
							  'post_type'    => 'tier-rules',
							  'post_status'  => 'publish',

							);
							$new_postid = wp_insert_post( $args );
						   
							if ( $new_postid ) {
								update_post_meta( $new_postid, 'wtp_include_product', $include_porduct );
								update_post_meta( $new_postid, 'wtp_exclude_product', $exclude_porduct );
								update_post_meta( $new_postid, 'wtp_tier_fix_clone', $tier_data );
								update_post_meta( $new_postid, 'wtp_include_product_cat', $include_cat );
								update_post_meta( $new_postid, 'wtp_exclude_product_cat', $exclude_cat );
								update_post_meta( $new_postid, 'wtp_user', $user );
								update_post_meta( $new_postid, 'wtp_user_roles', $user_role );
							}

						}

						if ( ob_get_level() > 0 ) {
							ob_end_flush();
						}
					}   

					echo 'success'; 

				} elseif ( in_array( $type . '_type', $first_row ) ) {
					while ( $row = fgetcsv( $file_data ) ) {
						$post_id            = isset( $row[0] ) ? $row[0] : 0;
						$post_title         = isset( $row[1] ) ? $row[1] : '';
						$include_porduct    = isset( $row[2] ) ? explode( ',', $row[2] ) : array();
						$exclude_porduct    = isset( $row[3] ) ? explode( ',', $row[3] ) : array();
						$include_cat        = isset( $row[4] ) ? explode( ',', $row[4] ) : array();
						$exclude_cat        = isset( $row[5] ) ? explode( ',', $row[5] ) : array();
						$user               = isset( $row[6] ) ? explode( ',', $row[6] ) : array();
						$user_role          = isset( $row[7] ) ? explode( ',', $row[7] ) : array();
						$min_qty            = isset( $row[8] ) ? trim( $row[8] ) : '';
						$max_qty            = isset( $row[9] ) ? trim( $row[9] ) : '&#8734;';
						$value              = isset( $row[11] ) ? trim( $row[11] ) : '';

						if ( post_exists( $post_title ) ) {
							$tier_data[] =  array( 
								'wtp_min_qty' => $min_qty,
								'wtp_max_qty' => $max_qty,
								'wtp_value' => $value,
							);

							update_post_meta( $post_id, 'wtp_include_product', $include_porduct );
							update_post_meta( $post_id, 'wtp_exclude_product', $exclude_porduct );
							update_post_meta( $post_id, 'wtp_tier_qty_clone', $tier_data );
							update_post_meta( $post_id, 'wtp_include_product_cat', $include_cat );
							update_post_meta( $post_id, 'wtp_exclude_product_cat', $exclude_cat );
							update_post_meta( $post_id, 'wtp_user', $user );
							update_post_meta( $post_id, 'wtp_user_roles', $user_role );

						} else {
							// Create new tier.
							$args = array( 
								'post_title'   => $post_title,
								'post_type'    => 'tier-rules',
								'post_status'  => 'publish',

							);
							$new_postid = wp_insert_post( $args );
						   
							if ( $new_postid ) {
								update_post_meta( $new_postid, 'wtp_include_product', $include_porduct );
								update_post_meta( $new_postid, 'wtp_exclude_product', $exclude_porduct );
								update_post_meta( $new_postid, 'wtp_tier_qty_clone', $tier_data );
								update_post_meta( $new_postid, 'wtp_include_product_cat', $include_cat );
								update_post_meta( $new_postid, 'wtp_exclude_product_cat', $exclude_cat );
								update_post_meta( $new_postid, 'wtp_user', $user );
								update_post_meta( $new_postid, 'wtp_user_roles', $user_role );
							}

						}

						if ( ob_get_level() > 0 ) {
							ob_end_flush();
						}
					}   

					echo 'success'; 
				} else {
					echo 'error';
				}

				setcookie( 'csv_file_name', '', time() - 3600, '/' );

				if ( file_exists( $filepath . $filename ) ) {
					unlink( $filepath . $filename );
				}
			}
		}

		wp_die();
	}
	
	/**
	 * Import Tier to data base by type
	 */
	public function wtp_import_data() {

		if ( ! isset( $_POST['_wtp_nonce'] ) ) {
			check_ajax_referer('wtp_import_csv', '_wtp_nonce');
		}       
		
		if ( isset( $_POST['wtp_type'] ) && 'wtp_import_csv' === sanitize_text_field( $_POST['wtp_type'] ) ) {
			$error = ''; 
			if ( isset( $_POST['tier_to_import'] ) && ! empty( sanitize_text_field( $_POST['tier_to_import'] ) ) ) {           
				if ( isset( $_FILES['wtp_import_csv']['name'] ) && '' != sanitize_text_field( $_FILES['wtp_import_csv']['name'] ) ) {

					$allowed_extension = array( 'csv' );
					$file_array        = explode( '.', sanitize_text_field( $_FILES['wtp_import_csv']['name'] ) );
					$extension         = end( $file_array );
					
					$maxAllowedSize = 5 * 1024 * 1024;

					if ( isset( $_FILES['wtp_import_csv']['size'] ) &&  $maxAllowedSize >= sanitize_text_field( $_FILES['wtp_import_csv']['size'] ) ) {

						if ( in_array( $extension, $allowed_extension ) ) {
							$new_file_name = rand() . '.' . $extension;
							setcookie( 'csv_file_name', $new_file_name, 0, '/' );
							// setcookie( 'import_type', sanitize_text_field( $_POST['tier_to_import'] ), 0, '/' );

							$filepath = WTP_ROOT_PATH . 'imports/';

							if ( ! file_exists( $filepath ) ) {
								mkdir( $filepath, 0777, true );
							}

							$filename_with_path = $filepath . $new_file_name;
							if ( isset( $_FILES['wtp_import_csv']['tmp_name'] ) ) {
								move_uploaded_file( sanitize_text_field( $_FILES['wtp_import_csv']['tmp_name'] ), $filename_with_path );
							}
							$file_content = file( $filename_with_path, FILE_SKIP_EMPTY_LINES );
						} else {
							$error = esc_html__( 'Only CSV file format is allowed', 'wtp' );
						}
					} else {
						$error = esc_html__( 'File size exceeded. Please upload file less than or equal to 5MB.', 'wtp' );
					}
				} else {
					$error = esc_html__( 'Please Select File', 'wtp' );
				}
			} else {
				$error = esc_html__( 'Please Select The Type To Import', 'wtp' );
			}

			if ( '' != $error ) {
				$output = array(
					'error' => $error,
				);
			} else {
				$output = array(
					'success'    => true,
				);
			}

			echo json_encode( $output );
			wp_die();
		}
	}
}
