<?php

namespace sharapeco\real;

final class PhoneJP
{
	// @const string 区切り文字
	const Delimiter = '-';

	// @var string[]
	private static $rules;

	/// ルールを初期化する
	private static function init()
	{
		if (isset(self::$rules)) {
			return;
		}
		self::$rules = file(__DIR__ . '/../data/rules', FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
	}

	/// 市外局番-局番-番号 に分割する
	/// @param $tel: string
	/// @param $withPrefix: boolean
	/// @param $delimiter: string
	/// @return string
	public static function split($tel, $withPrefix = true, $delimiter = self::Delimiter)
	{
		$ndTel = preg_replace('/[ ,._-]/', '', $tel);
		self::init();
		foreach (self::$rules as $rule) {
			$re = '/\\A0?' . $rule . '\\z/';
			if (preg_match($re, $ndTel, $m)) {
				return implode($delimiter, [
					($withPrefix ? '0' : '') . $m[1],
					$m[2],
					$m[3],
				]);
			}
		}
		return $ndTel; // nothing matched
	}
}
