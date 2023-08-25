# OTP Adapter for Rose

Adds TOTP/HOTP support to [Rose](https://github.com/rsthn/rose-core) to create secret codes and one-time tokens using the awesome [otphp](https://github.com/Spomky-Labs/otphp) library of Spomky-Labs.

# Installation

```sh
composer require rsthn/rose-otp
```

## Configuration Section: `OTP`

|Field|Type|Description|Default|
|----|----|-----------|-------|
|hash|`string`|Hash function to use.|sha1
|digits|`integer`|Number of digits to use for the generated one-time passwords.|7
|period|`integer`|Period to generate new tokens (in seconds).|30
|tolerance|`integer`|Number of seconds to tolerate as leeway when verifying tokens.|0

## Expression Functions

### `otp::create`

Creates a new secret key to be later used to generate one-time passwords. The output is a 64-byte random string which is later converted to Base32 resulting in a string with a maximum length of 128 chars that should be stored in a safe place to be used later.

The OTP settings are obtained from the OTP configuration section.

```lisp
(set secretKey (otp::create))
```

### `otp::get` secretKey:string [tokenTime:integer]

Returns the current time-based token given a secret key. Can be used to show it to the user via safe means such as email, SMS or a custom made app. Although if the user has an authenticator app such as Google Authenticator or Authy, it is recommended to use that with the `otp::uri` function instead.

```lisp
(otp::get (secretKey))
```

### `otp::verify` secretKey:string token:string

Verifies the specified token to check if it is valid, returns boolean.

```lisp
(when-not (otp::verify (secretKey) "123123")
	(throw "OTP code is incorrect")
)
```

### `otp::uri` secretKey:string label:string [issuer:string]

Returns the OTP-AUTH URI to be used in OTP clients (like Authy or Google Authenticator).

```lisp
(otp::uri (secretKey) "Zork")
```
