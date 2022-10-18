<?php

use PHPUnit\Framework\TestCase;
use piyo2\format\PhoneJP;

final class PhoneJPTest extends TestCase
{
	/**
	 * @test
	 */
	public function testFreeDial()
	{
		$this->assertEquals(
			PhoneJP::split('0120444444'),
			'0120-444-444'
		);
	}

	/**
	 * @test
	 */
	public function testFreeDial2()
	{
		$this->assertEquals(
			PhoneJP::split('08001238800'),
			'0800-123-8800'
		);
	}

	/**
	 * @test
	 */
	public function testNaviDial()
	{
		$this->assertEquals(
			PhoneJP::split('0570047999'),
			'0570-047-999'
		);
	}

	/**
	 * @test
	 */
	public function testQ2()
	{
		$this->assertEquals(
			PhoneJP::split('0990123456'),
			'0990-123-456'
		);
	}

	/**
	 * @test
	 */
	public function testOther()
	{
		$this->assertEquals(
			PhoneJP::split('05058463151'),
			'050-5846-3151'
		);
	}

	/**
	 * @test
	 */
	public function testArea4()
	{
		$this->assertEquals(
			PhoneJP::split('0139845511'),
			'01398-4-5511'
		);
	}

	/**
	 * @test
	 */
	public function testArea3()
	{
		$this->assertEquals(
			PhoneJP::split('0137873311'),
			'0137-87-3311'
		);
	}

	/**
	 * @test
	 */
	public function testArea2()
	{
		$this->assertEquals(
			PhoneJP::split('0762202111'),
			'076-220-2111'
		);
	}

	/**
	 * @test
	 */
	public function testArea1()
	{
		$this->assertEquals(
			PhoneJP::split('0643017285'),
			'06-4301-7285'
		);
	}

	/**
	 * @test
	 */
	public function testNoPrefixInput()
	{
		$this->assertEquals(
			PhoneJP::split('762202111'),
			'076-220-2111'
		);
	}

	/**
	 * @test
	 */
	public function testNoPrefixOutput()
	{
		$this->assertEquals(
			PhoneJP::split('0762202111', false),
			'76-220-2111'
		);
	}

	/**
	 * @test
	 */
	public function testDelimiter()
	{
		$this->assertEquals(
			PhoneJP::split('0762202111', true, ' '),
			'076 220 2111'
		);
	}
}
