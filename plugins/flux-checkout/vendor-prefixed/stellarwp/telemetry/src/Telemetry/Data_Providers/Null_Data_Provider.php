<?php
/**
 * A data provider that provides no data, used for testing.
 *
 * @since   TBD
 *
 * @package Iconic_Flux_NS\StellarWP\Telemetry\Data_Providers;
 *
 * @license GPL-2.0-or-later
 * Modified by iconicwp on 28-August-2024 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Iconic_Flux_NS\StellarWP\Telemetry\Data_Providers;

use Iconic_Flux_NS\StellarWP\Telemetry\Contracts\Data_Provider;

/**
 * Class Null_Data_Provider.
 *
 * @since   TBD
 *
 * @package Iconic_Flux_NS\StellarWP\Telemetry\Data_Providers;
 */
class Null_Data_Provider implements Data_Provider {

	/**
	 * {@inheritDoc}
	 *
	 * @since   TBD
	 */
	public function get_data(): array {
		return [];
	}
}
