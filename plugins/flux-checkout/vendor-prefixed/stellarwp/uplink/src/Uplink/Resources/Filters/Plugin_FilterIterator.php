<?php
/**
 * @license GPL-2.0-or-later
 *
 * Modified by iconicwp on 28-August-2024 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */ declare( strict_types=1 );

namespace Iconic_Flux_NS\StellarWP\Uplink\Resources\Filters;

use Countable;
use FilterIterator;
use Iconic_Flux_NS\StellarWP\Uplink\Resources\Plugin;

/**
 * @method Plugin current()
 */
class Plugin_FilterIterator extends FilterIterator implements Countable {

	/**
	 * @inheritDoc
	 */
	public function accept(): bool {
		$resource = $this->getInnerIterator()->current();

		return 'plugin' === $resource->get_type();
	}

	/**
	 * @inheritDoc
	 */
	public function count() : int {
		return iterator_count( $this );
	}

}
