<?php
/**
 * @license GPL-2.0-or-later
 *
 * Modified by iconicwp on 28-August-2024 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Iconic_Flux_NS\StellarWP\Uplink\Messages;

class Network_Licensed extends Message_Abstract {
	/**
	 * @inheritDoc
	 */
	public function get(): string {
		return esc_html__( 'A valid license has been entered by your network administrator.', 'flux-checkout' );
	}
}
