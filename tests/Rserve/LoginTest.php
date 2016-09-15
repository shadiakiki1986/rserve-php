<?php

namespace Rserve;

/*
 * Refer to README for how to run this test
 */

require_once __DIR__ . '/../config.php';

class LoginTest extends RserveTestCase {

	public function testLogin() {

    foreach(array("RSERVE_PORT","RSERVE_USER","RSERVE_PASS") as $field) {
      if(!defined($field)) {
        $this->markTestSkipped("Need to define php constant in tests/config.php: $field");
      }
    }

		$cnx = new \Rserve\Connection(
      RSERVE_HOST,
      RSERVE_PORT,
			array('username'=>RSERVE_USER,'password'=>RSERVE_PASS)
		);

		// random id
		$random = '';
		for($i = 0; $i < 10; ++$i) {
			$random .= dechex(mt_rand());
		}
		$random_id = uniqid($random, TRUE);

		$r = $cnx->evalString('x="'.$random_id.'"');

		$this->assertEquals($r, $random_id);

		$session = $cnx->detachSession();
	}
}
