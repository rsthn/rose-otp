<?php

namespace Rose\Ext\Wind;

use OTPHP\TOTP;

use Rose\Configuration;
use Rose\Errors\Error;
use Rose\Expr;

/**
 * Creates a new secret key to be later used to generate one-time passwords.
 * (otp::create)
 */
Expr::register('otp::create', function ($args)
{
	$config = Configuration::getInstance()->OTP;
	$otp = TOTP::create(null, $config?->get('period') ?? 30, $config?->get('hash') ?? 'sha1', $config?->get('digits') ?? 7);
	return $otp->getSecret();
});

/**
 * Returns the current time-based password given a secret key.
 * (otp::get :secretKey [:tokenTime])
 */
Expr::register('otp::get', function ($args)
{
	$config = Configuration::getInstance()->OTP;

	if (!$args->has(1))
		throw new Error('otp::get requires a secret key');

	$otp = TOTP::create($args->get(1), $config?->get('period') ?? 30, $config?->get('hash') ?? 'sha1', $config?->get('digits') ?? 7);
	return $args->has(2) ? $otp->at($args->get(2)) : $otp->now();
});

/**
 * Verifies the specified token to check if it is valid, returns boolean.
 * (otp::verify :secretKey :token)
 */
Expr::register('otp::verify', function ($args)
{
	$config = Configuration::getInstance()->OTP;

	if (!$args->has(1))
		throw new Error('otp::verify requires a secret key');

	if (!$args->has(2))
		throw new Error('otp::verify requires a token');

	$otp = TOTP::create($args->get(1), $config?->get('period') ?? 30, $config?->get('hash') ?? 'sha1', $config?->get('digits') ?? 7);
	return $otp->verify($args->get(2), null, $config?->get('tolerance') ?? 3);
});

/**
 * Returns the OTP-AUTH URI to be used in OTP clients (like Authy or Google Authenticator).
 * (otp::uri :secretKey :label [:issuer] [:logoUrl])
 */
Expr::register('otp::uri', function ($args)
{
	$config = Configuration::getInstance()->OTP;

	if (!$args->has(1))
		throw new Error('otp::uri requires a secret key');

	if (!$args->has(2))
		throw new Error('otp::uri requires a label');

	$otp = TOTP::create($args->get(1), $config?->get('period') ?? 30, $config?->get('hash') ?? 'sha1', $config?->get('digits') ?? 7);

	$otp->setLabel($args->get(2));

	if ($args->has(3) && $args->get(3))
		$otp->setIssuer($args->get(3));

	$tmp = $otp->getProvisioningUri();

	if ($args->has(4) && $args->get(4))
		$tmp .= '&image=' . urlencode($args->get(4));

	return $tmp;
});
