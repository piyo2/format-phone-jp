# PhoneJP

Split Japanese phone number.

## Usage

```PHP
use sharapeco\real\PhoneJP;

// Basic
PhoneJP::split('0120444444'); // => '0120-444-444'

// Without zero prefix input
PhoneJP::split('120444444'); // => '0120-444-444'

// Without prefix output
PhoneJP::split('0120444444', false); // => '120-444-444'

// Set delimiter
PhoneJP::split('0120444444', true, ' '); // => '0120 444 444'
```

## Data source

- [総務省｜電気通信番号制度｜市外局番の一覧](http://www.soumu.go.jp/main_sosiki/joho_tsusin/top/tel_number/shigai_list.html) (2021-10-01)
