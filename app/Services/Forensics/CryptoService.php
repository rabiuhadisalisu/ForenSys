<?php

namespace App\Services\Forensics;

class CryptoService
{
    /**
     * Provide guardrails for educational cryptography tooling.
     *
     * @return array<int, string>
     */
    public function allowedWorkflows(): array
    {
        return ['aes-demo', 'rsa-demo', 'signing-demo', 'hashing-demo'];
    }
}
