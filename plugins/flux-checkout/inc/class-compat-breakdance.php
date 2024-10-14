<?php
/**
 * Iconic_Flux_Compat_Breakance.
 *
 * Compatibility with Breakdance builder.
 *
 * @package Iconic_Flux
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( class_exists( 'Iconic_Flux_Compat_Breakdance' ) ) {
	return;
}

/**
 * Iconic_Flux_Compat_Breakance.
 *
 * @class    Iconic_Flux_Compat_Breakance.
 * @package  Iconic_Flux
 */
class Iconic_Flux_Compat_Breakdance {
	/**
	 * Run.
	 */
	public static function run() {
		add_action( 'wp', array( __CLASS__, 'compat_breakdance' ) );
	}

	/**
	 * Disable breakdance template functions.
	 */
	public static function compat_breakdance() {
		if ( ! function_exists( 'Breakdance\ActionsFilters\template_include' ) ) {
			return;
		}

		if ( ! Iconic_Flux_Core::is_flux_template() ) {
			return;
		}

		remove_filter( 'template_include', 'Breakdance\ActionsFilters\template_include', 1000000 );

		global $wp_filter;

		self::unhook_unonymous_callbacks( 'wc_get_template', 10 );
		self::unhook_unonymous_callbacks( 'wp_head', BREAKDANCE_ASSETS_PRIORITY );
		self::unhook_unonymous_callbacks( 'wp_footer', BREAKDANCE_ASSETS_PRIORITY );
	}

	/**
	 * Unhook unanymous/closure functions from the given action and prority.
	 *
	 * @param string $action   Action.
	 * @param int    $priority Priority.
	 *
	 * @return void
	 */
	public static function unhook_unonymous_callbacks( $action, $priority ) {
		global $wp_filter;

		if ( empty( $wp_filter[ $action ] ) || empty( $wp_filter[ $action ]->callbacks[ $priority ] ) ) {
			return;
		}

		foreach ( $wp_filter[ $action ]->callbacks[ $priority ] as $function ) {
			if ( is_object( $function['function'] ) ) {
				unset( $wp_filter[ $action ]->callbacks[ $priority ] );
			}
		}
	}
}
