<?php
/**
 * The API implemented by all subscribers.
 *
 * @package Iconic_WDS_NS\StellarWP\Telemetry\Contracts
 *
 * @license GPL-2.0-or-later
 * Modified by James Kemp on 19-November-2024 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Iconic_WDS_NS\StellarWP\Telemetry\Contracts;

/**
 * Interface Subscriber_Interface
 *
 * @package Iconic_WDS_NS\StellarWP\Telemetry\Contracts
 */
interface Subscriber_Interface {

	/**
	 * Register action/filter listeners to hook into WordPress
	 *
	 * @return void
	 */
	public function register();

}
