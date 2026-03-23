<?php

namespace EasyHTTP\Contracts\Tests\Unit\Common;

use EasyHTTP\Contracts\Common\SecurityContext;
use EasyHTTP\Contracts\Tests\TestCase;

class ClientRequestSecurityTest extends TestCase
{
    /**
     * @test
     */
    public function itSetsInitialProperties()
    {
        $security = new SecurityContext();

        $this->assertFalse($security->hasCertificate());
        $this->assertFalse($security->hasPrivateKey());
    }

    /**
     * @test
     */
    public function itCanChangeItsData()
    {
        $security = new SecurityContext();

        $security->setCertificate('cert/cert.pem');
        $security->setPrivateKey('cert/private.pem');

        $this->assertSame('cert/cert.pem', $security->getCertificate());
        $this->assertSame('cert/private.pem', $security->getPrivateKey());
    }
}
