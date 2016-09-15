<?php

namespace Rserve;

class RserveTestCase extends \PHPUnit_Framework_TestCase {

	private static $cnx;

	/**
	 * Sets up the fixture, for example, open a network connection.
	 * This method is called before a test is executed.
	 *
	 * @access protected
	 */
	public function setUp() {

    $field = "RSERVE_HOST";
    if(!defined($field)) {
      $this->markTestSkipped("Need to define php constant in tests/config.php: $field");
    }

		if(!self::$cnx) {
			self::$cnx = new \Rserve\Connection(RSERVE_HOST);
		}

		$this->rserve = self::$cnx;
	}
}
