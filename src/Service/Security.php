<?php

namespace App\Service;

use OTPHP\TOTP;

class Security
{
    /** @var TOTP */
    private $totp;

    /**
     * Security constructor.
     * @param string $secret
     * @throws \TypeError
     */
    public function __construct(string $secret)
    {
        $this->totp = TOTP::create($secret);
        $this->totp->setLabel('Personal API');
        $this->totp->setIssuer('Personal API');
    }

    public function check(string $otp)
    {
        return $this->totp->verify($otp);
    }

    public function getQrCodeUri()
    {
        return $this->totp->getQrCodeUri();
    }
}
