<?php

namespace Rose\Ext\Wind;

use OTPHP\TOTP;

use Rose\Errors\Error;
use Rose\Expr;

/**
 * Creates a new secret key to be later used to generate one-time passwords.
 * (otp::create)
 */
Expr::register('otp::create', function ($args)
{
	$otp = TOTP::create();
	return $otp->getSecret();
});

/**
 * Returns the current time-based password given a secret key.
 * (otp::get :secretKey)
 */
Expr::register('otp::get', function ($args)
{
	if (!$args->has(1))
		throw new Error('otp::get requires a secret key');

	$otp = TOTP::create($args->get(1));
	return $otp->now();
});
