<?php
/**
 * Example test case to verify that Unit tests run correctly.
 *
 * @package hm-base
 */

namespace HMBase\Tests;

/**
 * Class Example_Test_Case
 *
 * @group example
 */
class Example_Test_Case extends WP_UnitTestCase {

	/**
	 * Verify that 1 does, in fact, equal 1.
	 */
	function test_integer_equals() {
		$this->assertEquals( 1, 1 );
	}
}
