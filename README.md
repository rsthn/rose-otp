# OTP Adapter for Rose

This extension adds TOTP/HOTP support to [Rose](https://github.com/rsthn/rose-core) to create secret codes and one-time tokens using the awesome [otphp](https://github.com/Spomky-Labs/otphp) library of Spomky-Labs.

<br/>

# Installation

```sh
composer require rsthn/rose-otp
```

## Configuration Section: `OTP`


|Field|Type|Name|Description|
|----|----|-----------|-------|
|host|`string`|SMTP host name.|Required
|username|`string`|Username for the SMTP server.|Required
|password|`string`|Password for the SMTP server.|Required
|port|`int`|Port number to connect.|Default is port `587`.
|secure|`boolean`, `string`|SMTP secure connection mode.|Default is `true`.<br/>Use `explicit` if port is 587, `implicit` otherwise.<br/>Set to `false` to disable and to `true` to use automatic detection based on port number.
|from|`string`|Email address of the sender.|Optional
|fromName|`string`|Name of the sender.|Optional


## Expression Functions

### `mail::send` name:string value:string ...

```lisp
(mail::send
	RCPT 'example@host.com'
	SUBJECT 'This is a test.'
	BODY '<b>Thanks for reading this email.</b>'
)
```
