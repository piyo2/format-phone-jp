<?php

$source = $argv[1] ?? null;
if (!$source) {
	echo 'Usage:', PHP_EOL;
	echo '  php make.php source.txt > data/rules';
	exit;
}

$codes = [];
$lines = file($source, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
foreach ($lines as $line) {
	$codes[$line] = true;
}

$codes = array_keys($codes);

usort($codes, function($a, $b) {
	if (strlen($a) !== strlen($b)) return $b <=> $a;
	return $a <=> $b;
});

$special = [
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

const EOL = "\n";
foreach ($special as $rule) {
	echo $rule, EOL;
}
foreach ($codes as $code) {
	echo "({$code})(", str_repeat('.', 5 - strlen($code)), ')(.+)', EOL;
}
