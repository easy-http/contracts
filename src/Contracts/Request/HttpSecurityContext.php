<?php

namespace EasyHttp\Contracts\Contracts\Request;

interface HttpSecurityContext
{
    public function getCertificate(): string;
    public function getPrivateKey(): string;
    public function hasCertificate(): bool;
    public function hasPrivateKey(): bool;
    public function setCertificate(string $certificate): self;
    public function setPrivateKey(string $privateKey): self;
}
