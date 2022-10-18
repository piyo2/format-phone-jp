<?php

namespace piyo2\format;

final class PhoneJP
{
	/** @var string 区切り文字 */
	const Delimiter = '-';

	/** @var string[] ルールセット */
	private static $rules;

	/**
	 * ルールを初期化する
	 *
	 * @return void
	 */
	private static function init(): void
	{
		if (isset(self::$rules)) {
			return;
		}
		self::$rules = file(__DIR__ . '/../data/rules', FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
	}

	/**
	 * 市外局番-局番-番号 に分割する
	 *
	 * @param string $phoneNumber
	 * @param bool $withPrefix
	 * @param string $delimiter
	 * @return string
	 */
	public static function split(string $phoneNumber, bool $withPrefix = true, string $delimiter = self::Delimiter): string
	{
		$digits = preg_replace('/[^0-9#*]/', '', $phoneNumber);
		self::init();
		foreach (self::$rules as $rule) {
			$re = '/\\A0?' . $rule . '\\z/';
			if (preg_match($re, $digits, $m)) {
				return implode($delimiter, [
					($withPrefix ? '0' : '') . $m[1],
					$m[2],
					$m[3],
				]);
			}
		}
		return $digits; // nothing matched
	}
}
