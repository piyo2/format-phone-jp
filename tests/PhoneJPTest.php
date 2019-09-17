<?php
use PHPUnit\Framework\TestCase;
use sharapeco\real\PhoneJP;

final class PhoneJPTest extends TestCase {

	/**
	 * @test
	 */
	public function testFreeDial() {
		// ドモホルンリンクル
		$this->assertEquals(
			PhoneJP::split('0120444444'),
			'0120-444-444'
		);
	}

	/**
	 * @test
	 */
	public function testFreeDial2() {
		// 東京電力エナジーパートナー
		$this->assertEquals(
			PhoneJP::split('08001238800'),
			'0800-123-8800'
		);
	}

	/**
	 * @test
	 */
	public function testNaviDial() {
		// NTTコミュニケーションズ
		$this->assertEquals(
			PhoneJP::split('0570047999'),
			'0570-047-999'
		);
	}

	/**
	 * @test
	 */
	public function testQ2() {
		// 架空
		$this->assertEquals(
			PhoneJP::split('0990123456'),
			'0990-123-456'
		);
	}

	/**
	 * @test
	 */
	public function testOther() {
		// うるおいの里
		$this->assertEquals(
			PhoneJP::split('05058463151'),
			'050-5846-3151'
		);
	}

	/**
	 * @test
	 */
	public function testArea4() {
		// せたな町役場　大成総合支所
		$this->assertEquals(
			PhoneJP::split('0139845511'),
			'01398-4-5511'
		);
	}

	/**
	 * @test
	 */
	public function testArea3() {
		// せたな町役場　瀬棚総合支所
		$this->assertEquals(
			PhoneJP::split('0137873311'),
			'0137-87-3311'
		);
	}

	/**
	 * @test
	 */
	public function testArea2() {
		// 金沢市役所
		$this->assertEquals(
			PhoneJP::split('0762202111'),
			'076-220-2111'
		);
	}

	/**
	 * @test
	 */
	public function testArea1() {
		// 大阪市役所
		$this->assertEquals(
			PhoneJP::split('0643017285'),
			'06-4301-7285'
		);
	}

	/**
	 * @test
	 */
	public function testNoPrefixInput() {
		// 金沢市役所
		$this->assertEquals(
			PhoneJP::split('762202111'),
			'076-220-2111'
		);
	}

	/**
	 * @test
	 */
	public function testNoPrefixOutput() {
		// 金沢市役所
		$this->assertEquals(
			PhoneJP::split('0762202111', false),
			'76-220-2111'
		);
	}

	/**
	 * @test
	 */
	public function testDelimiter() {
		// 金沢市役所
		$this->assertEquals(
			PhoneJP::split('0762202111', true, ' '),
			'076 220 2111'
		);
	}

}