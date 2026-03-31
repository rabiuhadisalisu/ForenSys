<?php

namespace App\Services\Forensics;

class DiffService
{
    /**
     * Return a lightweight placeholder for future safe diff summaries.
     *
     * @param  array<int, string>  $lines
     * @return array<string, int>
     */
    public function summarize(array $lines): array
    {
        return [
            'lines' => count($lines),
        ];
    }
}
