<?php
require_once __DIR__ . '/../vendor/autoload.php';

// ルールファイル生成方法
//
//   1. 市外局番の一覧 Word 形式を開く
//   2. Word ファイルの「市外局番」列を Excel にコピー
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

$tsv = file_get_contents($src);
$cols = ['code'];

$parser = new sharapeco\CSVParser\CSVParser([
	'csv_encoding' => 'UTF-8',
]);
$rows = $parser->parse($tsv, $cols);

$rows = array_filter($rows, function($row) {
	return preg_match('/\\A[0-9]+\\z/', trim($row['code']));
});

$codes = array_map(function($row) { return trim($row['code']); }, $rows);
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
