<?php
/**
 * @license GPL-2.0-or-later
 *
 * Modified by James Kemp on 19-November-2024 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Iconic_WDS_NS\StellarWP\Uplink\Messages;

use Iconic_WDS_NS\StellarWP\ContainerContract\ContainerInterface;
use Iconic_WDS_NS\StellarWP\Uplink\Config;

class Valid_Key extends Message_Abstract {
	/**
	 * Expiration date.
	 *
	 * @var string
	 */
	protected $expiration;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 *
	 * @param string $expiration Expiration date.
	 * @param ContainerInterface|null $container Container instance.
	 */
	public function __construct( $expiration, $container = null ) {
		parent::__construct( $container );

		$this->expiration = $expiration;
	}

	/**
	 * @inheritDoc
	 */
	public function get(): string {
		if ( $this->expiration ) {
			$message = sprintf(
				__( 'Valid key! Expires on %s.', 'jckwds' ),
				$this->expiration
			);
		} else {
			$message = __( 'Valid key!', 'jckwds' );
		}
		$message = apply_filters( 'stellarwp/uplink/' . Config::get_hook_prefix() . '/messages/valid_key', $message, $this->expiration );

		return esc_html( $message );
	}
}
