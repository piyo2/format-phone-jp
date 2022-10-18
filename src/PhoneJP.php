<?php

namespace piyo2\format;

use InvalidArgumentException;
use Normalizer;

class PhoneJP
{
	/** @var int 任意 */
	const PREFIX_OPTIONAL = 0;

	/** @var int 強制的に国内プリフィクス (0) を追加する */
	const PREFIX_FORCE_DOMESTIC = 1;

	/** @var int 強制的に国際プリフィクス (+81) を追加する */
	const PREFIX_FORCE_COUNTRY = 2;

	/** @var string 日本の国番号 */
	protected const CountryPrefix = '+81';

	/** @var string 国内プリフィクス */
	protected const DomesticPrefix = '0';

	/** @var int プリフィクスの追加モード (PREFIX_*** 定数) */
	protected $mode = self::PREFIX_OPTIONAL;

	/** @var string 番号の区切り文字 */
	protected $delimiter = '-';

	/** @var string 国番号の区切り文字 */
	protected $countryPrefixDelimiter = ' ';

	/** @var string[] ルールセット */
	protected static $rules;

	/**
	 * プリフィクスの追加モードを設定する
	 *
	 * @param integer $mode PREFIX_*** 定数
	 * @return void
	 */
	public function setPrefixMode(int $mode): void
	{
		if ($mode < self::PREFIX_OPTIONAL || $mode > self::PREFIX_FORCE_COUNTRY) {
			throw new InvalidArgumentException();
		}
		$this->mode = $mode;
	}

	/**
	 * 区切り文字を設定する
	 *
	 * @param string $delimiter
	 * @return void
	 */
	public function setDelimiter(string $delimiter): void
	{
		$this->delimiter = $delimiter;
	}

	/**
	 * 国番号の区切り文字を設定する
	 *
	 * @param string $delimiter
	 * @return void
	 */
	public function setCountryPrefixDelimiter(string $delimiter): void
	{
		$this->countryPrefixDelimiter = $delimiter;
	}

	/**
	 * 日本の一般の電話番号として正しいかどうかを返す
	 *
	 * @param string $phoneNumber
	 * @return boolean
	 */
	public function validate(string $phoneNumber): bool
	{
		return $this->formatIfValid($phoneNumber) !== null;
	}

	/**
	 * 市外局番-局番-番号 に分割する
	 *
	 * @param string $phoneNumber 電話番号
	 * @return string 分割した電話番号。分割できなかった場合は入力をそのまま返す
	 */
	public function format(string $phoneNumber): string
	{
		return $this->formatIfValid($phoneNumber) ?: $phoneNumber;
	}

	/**
	 * 形式が正しければ 市外局番-局番-番号 に分割する
	 *
	 * @param string $phoneNumber 電話番号
	 * @return string|null
	 */
	public function formatIfValid(string $phoneNumber): ?string
	{
		$n = $this->normalize($phoneNumber);

		$countryPrefix = null;
		if (strpos($n, '+') === 0) {
		 	if (strpos($n, self::CountryPrefix) !== 0) {
				return null;
			}
			$n = substr($n, strlen(self::CountryPrefix));
			$countryPrefix = self::CountryPrefix;
		}

		$digits = $this->removeDelimiter($n);
		if (preg_match('/[^0-9#*]/', $digits)) {
			return null;
		}

		$domesticPrefix = null;
		if (strpos($digits, self::DomesticPrefix) === 0) {
			$digits = substr($digits, strlen(self::DomesticPrefix));
			$domesticPrefix = self::DomesticPrefix;
		}

		self::init();
		foreach (self::$rules as $rule) {
			$re = '/\\A' . $rule . '\\z/';
			if (preg_match($re, $digits, $matches)) {
				if ($this->mode === self::PREFIX_FORCE_COUNTRY) {
					$prefix = self::CountryPrefix . $this->countryPrefixDelimiter;
				} else if ($this->mode === self::PREFIX_FORCE_DOMESTIC) {
					$prefix = self::DomesticPrefix;
				} else if (isset($countryPrefix)) {
					$prefix = $countryPrefix . $this->countryPrefixDelimiter;
				} else if (isset($domesticPrefix)) {
					$prefix = $domesticPrefix;
				} else {
					$prefix = '';
				}
				return implode($this->delimiter, [
					$prefix . $matches[1],
					$matches[2],
					$matches[3],
				]);
			}
		}
		return null;
	}

	/**
	 * 入力を正規化する（全角半角変換）
	 *
	 * @param string $phoneNumber
	 * @return string
	 */
	protected function normalize(string $phoneNumber): string
	{
		$n = $phoneNumber;
		$n = Normalizer::normalize($n);
		$n = \mb_convert_kana($n, 'KVa', 'UTF-8');
		return $n;
	}

	/**
	 * 区切り文字を除去する
	 *
	 * @param string $phoneNumber
	 * @return string
	 */
	protected function removeDelimiter(string $phoneNumber): string
	{
		return preg_replace('/[ ,.・ー－-]/u', '', $phoneNumber);
	}

	/**
	 * ルールを初期化する
	 *
	 * @return void
	 */
	protected static function init(): void
	{
		if (isset(self::$rules)) {
			return;
		}
		self::$rules = file(__DIR__ . '/../data/rules', FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
	}
}
