<?php

namespace App\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ToolCatalog
{
    /**
     * Safe forensic and learning utilities exposed in the Phase 1-2 workspace.
     */
    public static function all(): Collection
    {
        return collect([
            [
                'slug' => 'hash-generator',
                'name' => 'Hash Generator',
                'family' => 'integrity',
                'status' => 'ready',
                'description' => 'Generate SHA-256, SHA-1, and MD5 digests for owned text and uploaded evidence references.',
                'tags' => ['hashing', 'integrity', 'verification'],
            ],
            [
                'slug' => 'hash-verifier',
                'name' => 'Hash Verifier',
                'family' => 'integrity',
                'status' => 'ready',
                'description' => 'Compare captured evidence hashes against expected values and preserve verification history.',
                'tags' => ['validation', 'chain-of-custody'],
            ],
            [
                'slug' => 'metadata-viewer',
                'name' => 'Metadata Viewer',
                'family' => 'evidence',
                'status' => 'ready',
                'description' => 'Inspect normalized file metadata extracted from safe preview pipelines.',
                'tags' => ['metadata', 'timeline', 'inspection'],
            ],
            [
                'slug' => 'signature-inspector',
                'name' => 'File Signature Inspector',
                'family' => 'evidence',
                'status' => 'ready',
                'description' => 'Review file magic bytes, extension mismatches, and signature confidence.',
                'tags' => ['file-signature', 'validation'],
            ],
            [
                'slug' => 'hex-text-viewer',
                'name' => 'Hex & Text Viewer',
                'family' => 'inspection',
                'status' => 'ready',
                'description' => 'Render safe slices of binary or text content in analyst-friendly panels.',
                'tags' => ['hex', 'text', 'preview'],
            ],
            [
                'slug' => 'json-formatter',
                'name' => 'JSON Formatter',
                'family' => 'parsing',
                'status' => 'ready',
                'description' => 'Format, validate, and annotate JSON payloads during case review.',
                'tags' => ['json', 'validation'],
            ],
            [
                'slug' => 'timestamp-converter',
                'name' => 'Timestamp Converter',
                'family' => 'timeline',
                'status' => 'ready',
                'description' => 'Translate Unix, ISO-8601, and Windows-style timestamps into analyst-readable time.',
                'tags' => ['timestamps', 'timeline'],
            ],
            [
                'slug' => 'base64-workbench',
                'name' => 'Base64 Workbench',
                'family' => 'encoding',
                'status' => 'ready',
                'description' => 'Perform safe encoding and decoding for user-supplied content.',
                'tags' => ['base64', 'encoding'],
            ],
            [
                'slug' => 'text-diff',
                'name' => 'Text Diff',
                'family' => 'comparison',
                'status' => 'planned',
                'description' => 'Compare textual artifacts while preserving context for reporting.',
                'tags' => ['diff', 'comparison'],
            ],
            [
                'slug' => 'crypto-learning-lab',
                'name' => 'Cryptography Learning Lab',
                'family' => 'education',
                'status' => 'planned',
                'description' => 'Educational AES, RSA, signing, and hashing workflows for user-owned data only.',
                'tags' => ['crypto', 'education'],
            ],
        ])->values();
    }

    public static function findOrFail(string $slug): array
    {
        $tool = self::all()->firstWhere('slug', $slug);

        if (! $tool) {
            throw new NotFoundHttpException(sprintf('Tool [%s] was not found.', $slug));
        }

        return Arr::wrap($tool);
    }
}
