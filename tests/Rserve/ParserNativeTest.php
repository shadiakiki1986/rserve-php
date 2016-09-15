<?php

namespace Rserve;

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/Definition.php';

class ParserNativeTest extends RserveTestCase {

	/**
	 * Provider for test cases
	 */
	function providerSimpleTests() {
		return Rserve_Tests_Definition::$native_tests;
	}

	/**
	 * @dataProvider providerSimpleTests
	 * @param string $cmd R command
	 * @param string $type expected type
	 * @param array $expected expected php structure
	 * @param array $filters filters to apply to the R result to fit the tests values, each filter is array(funcname, param1,...), or a string funcname|param1|param2...
	 * @covers Rserve_Parser::parse
	 * @covers \Rserve\Connection::evalString
	 */
	public function testSimpleTypes($cmd, $type, $expected, $filters=NULL) {
		$r = $this->rserve->evalString($cmd);
		if( is_array($expected) ) {
			$this->assertInternalType('array',$r);
			if( is_array($r) AND !is_null($type) ) {
				foreach($r as $x) {
					$this->assertInternalType($type,$x);
				}
			}
		} else {
			if( !is_null($type) ) {
				$this->assertInternalType($type, $r);
			}
		}
		if( !is_null($filters) ) {
			foreach($filters as $key=>$filter) {
				if( is_string($filter) ) {
					$filter = explode('|',$filter);
				}
				$f = array_shift($filter);
				if( !is_callable($f) ) {
					throw new \Exception('Bad filter '.$f.' for '.$key);
				}
				$params = array_merge(array($r[$key]), $filter);
				$r[$key] = call_user_func_array($f, $params);
			}
		}
		$this->assertEquals($r, $expected);
	}

}
