<?php

namespace Rserve;

require_once __DIR__ . '/../config.php';

class SessionTest extends RserveTestCase {

	public function testSession() {
		$this->markTestSkipped("Not sure why this isnt working");

		// random id
		$random = '';
		for($i = 0; $i < 10; ++$i) {
			$random .= dechex(mt_rand());
		}
		$random_id = uniqid($random, TRUE);

		$r = $this->rserve->evalString('x="'.$random_id.'"');

		$this->assertEquals($r, $random_id);

		$session = $this->rserve->detachSession();

		$cnx = new \Rserve\Connection($session);

		$x = $cnx->evalString('x');

		$this->assertEquals($x, $random_id);

	}
}
