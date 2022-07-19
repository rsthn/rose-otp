# OTP Adapter for Rose

This extension adds TOTP/HOTP support to [Rose](https://github.com/rsthn/rose-core) to create secret codes and one-time tokens using the awesome [otphp](https://github.com/Spomky-Labs/otphp) library of Spomky-Labs.

<br/>

# Installation

```sh
composer require rsthn/rose-otp
```

## Configuration Section: `OTP`

<br/>

## Expression Functions

### `otp::create`

Creates a new secret key to be later used to generate one-time passwords.

```lisp
(otp::create)
```

### `otp::get` secretKey:string

Returns the current time-based password given a secret key.

```lisp
(otp::get (secretKey))
```
