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
		$f = new PhoneJP();
		$this->assertEquals(
			$f->formatIfValid('0120444444'),
			'0120-444-444'
		);
	}

	/**
	 * @test
	 */
	public function testFreeDial2()
	{
		$f = new PhoneJP();
		$this->assertEquals(
			$f->formatIfValid('08001238800'),
			'0800-123-8800'
		);
	}

	/**
	 * @test
	 */
	public function testNaviDial()
	{
		$f = new PhoneJP();
		$this->assertEquals(
			$f->formatIfValid('0570047999'),
			'0570-047-999'
		);
	}

	/**
	 * @test
	 */
	public function testQ2()
	{
		$f = new PhoneJP();
		$this->assertEquals(
			$f->formatIfValid('0990123456'),
			'0990-123-456'
		);
	}

	/**
	 * @test
	 */
	public function testOther()
	{
		$f = new PhoneJP();
		$this->assertEquals(
			$f->formatIfValid('05058463151'),
			'050-5846-3151'
		);
	}

	/**
	 * @test
	 */
	public function testSymbol()
	{
		$f = new PhoneJP();
		$this->assertEquals(
			$f->format('#9110*'),
			'#9110*'
		);
	}

	/**
	 * @test
	 */
	public function testInvalidCharacter()
	{
		$f = new PhoneJP();
		$this->assertEquals(
			$f->formatIfValid('#91a-bc10*'),
			null
		);
	}

	/**
	 * @test
	 */
	public function testArea4()
	{
		$f = new PhoneJP();
		$this->assertEquals(
			$f->formatIfValid('0139845511'),
			'01398-4-5511'
		);
	}

	/**
	 * @test
	 */
	public function testArea3()
	{
		$f = new PhoneJP();
		$this->assertEquals(
			$f->formatIfValid('0137873311'),
			'0137-87-3311'
		);
	}

	/**
	 * @test
	 */
	public function testArea2()
	{
		$f = new PhoneJP();
		$this->assertEquals(
			$f->formatIfValid('0762202111'),
			'076-220-2111'
		);
	}

	/**
	 * @test
	 */
	public function testArea1()
	{
		$f = new PhoneJP();
		$this->assertEquals(
			$f->formatIfValid('0643017285'),
			'06-4301-7285'
		);
	}

	/**
	 * @test
	 */
	public function testNoRegion()
	{
		$f = new PhoneJP();
		$this->assertEquals(
			$f->formatIfValid('0127123456'),
			null
		);
	}

	/**
	 * @test
	 */
	public function testNoPrefix()
	{
		$f = new PhoneJP();
		$this->assertEquals(
			$f->formatIfValid('762202111'),
			'76-220-2111'
		);
	}

	/**
	 * @test
	 */
	public function testForceDomesticPrefix()
	{
		$f = new PhoneJP();
		$f->setPrefixMode(PhoneJP::PREFIX_FORCE_DOMESTIC);
		$this->assertEquals(
			$f->formatIfValid('762202111'),
			'076-220-2111'
		);
	}

	/**
	 * @test
	 */
	public function testForceDomesticPrefix2()
	{
		$f = new PhoneJP();
		$f->setPrefixMode(PhoneJP::PREFIX_FORCE_DOMESTIC);
		$this->assertEquals(
			$f->formatIfValid('+81 76-220-2111'),
			'076-220-2111'
		);
	}

	/**
	 * @test
	 */
	public function testForceDomesticPrefix3()
	{
		$f = new PhoneJP();
		$f->setPrefixMode(PhoneJP::PREFIX_FORCE_DOMESTIC);
		$this->assertEquals(
			$f->formatIfValid('076-220-2111'),
			'076-220-2111'
		);
	}

	/**
	 * @test
	 */
	public function testForceCountryPrefix()
	{
		$f = new PhoneJP();
		$f->setPrefixMode(PhoneJP::PREFIX_FORCE_COUNTRY);
		$this->assertEquals(
			$f->formatIfValid('0762202111'),
			'+81 76-220-2111'
		);
	}

	/**
	 * @test
	 */
	public function testForceCountryPrefix2()
	{
		$f = new PhoneJP();
		$f->setPrefixMode(PhoneJP::PREFIX_FORCE_COUNTRY);
		$this->assertEquals(
			$f->formatIfValid('+81762202111'),
			'+81 76-220-2111'
		);
	}

	/**
	 * @test
	 */
	public function testForceCountryPrefix3()
	{
		$f = new PhoneJP();
		$f->setPrefixMode(PhoneJP::PREFIX_FORCE_COUNTRY);
		$this->assertEquals(
			$f->formatIfValid('0762202111'),
			'+81 76-220-2111'
		);
	}

	/**
	 * @test
	 */
	public function testDomesticPrefix()
	{
		$f = new PhoneJP();
		$this->assertEquals(
			$f->formatIfValid('0762202111'),
			'076-220-2111'
		);
	}

	/**
	 * @test
	 */
	public function testCountryPrefix()
	{
		$f = new PhoneJP();
		$this->assertEquals(
			$f->formatIfValid('+81762202111'),
			'+81 76-220-2111'
		);
	}

	/**
	 * @test
	 */
	public function testCountryPrefix2()
	{
		$f = new PhoneJP();
		$this->assertEquals(
			$f->formatIfValid('+810762202111'),
			'+81 76-220-2111'
		);
	}

	/**
	 * @test
	 */
	public function testDelimiter()
	{
		$f = new PhoneJP();
		$f->setDelimiter(' ');
		$this->assertEquals(
			$f->formatIfValid('0762202111'),
			'076 220 2111'
		);
	}

	/**
	 * @test
	 */
	public function testCountryDelimiter()
	{
		$f = new PhoneJP();
		$f->setPrefixMode(PhoneJP::PREFIX_FORCE_COUNTRY);
		$f->setCountryPrefixDelimiter('-');
		$this->assertEquals(
			$f->formatIfValid('0762202111'),
			'+81-76-220-2111'
		);
	}

	/**
	 * @test
	 */
	public function testZenkaku()
	{
		$f = new PhoneJP();
		$f->setPrefixMode(PhoneJP::PREFIX_FORCE_DOMESTIC);
		$this->assertEquals(
			$f->formatIfValid('＋８１０７６２２０２１１１'),
			'076-220-2111'
		);
	}
}
