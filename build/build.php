<?php
require_once __DIR__ . '/../vendor/autoload.php';

// ルールファイル生成方法
//
//   1. 市外局番の一覧 Word 形式を開く
//   2. Word ファイルの「市外局番」列（ヘッダ除く）を Excel にコピー
//   3. Excel で「CSV UTF-8」形式で保存
//
// 市外局番の一覧
// http://www.soumu.go.jp/main_sosiki/joho_tsusin/top/tel_number/shigai_list.html
$src = __DIR__ . '/source.csv';

// 出力先
$dest = __DIR__ . '/../data/rules';

// 改行コード
$EOL = "\n";

// 固定ルール
$fixedRules = [
	'(120)(...)(.+)',
	'(570)(...)(.+)',
	'(800)(...)(.+)',
	'(990)(...)(.+)',
	'(20)(....)(.+)',
	'(50)(....)(.+)',
	'(60)(....)(.+)',
	'(70)(....)(.+)',
	'(80)(....)(.+)',
	'(90)(....)(.+)',
];

$codes = file($src, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$codes = array_values(array_unique($codes));

// 市外局番が長い順に並べる
usort($codes, function($x, $y) {
	$dlen = strlen($y) - strlen($x);
	if ($dlen < 0) return -1;
	if ($dlen > 0) return 1;
	return strcmp($x, $y);
});

$rules = array_map(function($code) {
	$clen = 5 - strlen($code);
	$cexp = str_repeat('.', $clen);
	return "(${code})(${cexp})(.+)";
}, $codes);

file_put_contents($dest, implode($EOL, array_merge($fixedRules, $rules)));
