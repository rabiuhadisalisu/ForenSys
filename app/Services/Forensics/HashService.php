<?php

namespace App\Services\Forensics;

class HashService
{
    /**
     * Return the safe hashing algorithms exposed by the workspace.
     *
     * @return array<int, string>
     */
    public function supportedAlgorithms(): array
    {
        return ['md5', 'sha1', 'sha256', 'sha512'];
    }
}
