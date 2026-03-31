<?php

namespace App\Services\Forensics;

class MetadataService
{
    /**
     * Normalize extracted metadata into a shape suitable for display panels.
     *
     * @param  array<string, mixed>  $metadata
     * @return array<string, mixed>
     */
    public function normalize(array $metadata): array
    {
        return $metadata;
    }
}
