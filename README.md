# PhoneJP

Japanese phone number validator/formatter.

## Usage

### Basic

```php
use piyo2\format\PhoneJP;

$f = new PhoneJP();

// Valid number
$f->validate('0120444444'); // => true
$f->format('0120444444'); // => '0120-444-444'
$f->formatIfValid('0120444444'); // => '0120-444-444'

// Invalid number
$f->validate('0127-12-3456'); // => false
$f->format('0127-12-3456'); // => '0127-12-3456' (= input value)
$f->formatIfValid('0127-12-3456'); // => null
```

### Force prefix

```php
$f = new PhoneJP();

$f->format('120444444'); // => '120-444-444'
$f->format('0120444444'); // => '0120-444-444'
$f->format('+81120444444'); // => '+81 120-444-444'

$f->setPrefixMode(PhoneJP::PREFIX_FORCE_DOMESTIC);
$f->format('120444444'); // => '0120-444-444'

$f->setPrefixMode(PhoneJP::PREFIX_FORCE_COUNTRY);
$f->format('120444444'); // => '+81 120-444-444'
```

### Set delimiter

```php
$f = new PhoneJP();

$f->setDelimiter(' ');
$f->format('0120444444'); // => '0120 444 444'

$f->setDelimiter('-');
$f->setCountryPrefixDelimiter('-');
$f->format('+81120444444'); // => '+81-120-444-444'
```

## Data source

- [総務省｜電気通信番号制度｜市外局番の一覧](http://www.soumu.go.jp/main_sosiki/joho_tsusin/top/tel_number/shigai_list.html) (2022-03-01)
