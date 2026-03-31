<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ForenDesk') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=ibm-plex-sans:400,500,600,700|jetbrains-mono:400,500,700&display=swap" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="font-sans antialiased">
        <div class="relative flex min-h-screen items-center justify-center overflow-hidden px-6 py-12">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(34,211,238,0.08),transparent_25%),linear-gradient(180deg,rgba(15,23,42,0.95),rgba(2,6,23,1))]"></div>

            <div class="relative z-10 grid w-full max-w-6xl gap-8 lg:grid-cols-[1.1fr_0.9fr]">
                <div class="fd-panel hidden p-10 lg:block">
                    <x-application-logo class="mb-10" />

                    <div class="space-y-6">
                        <span class="fd-chip">Lawful Forensics Workspace</span>
                        <div>
                            <h1 class="max-w-xl text-4xl font-semibold leading-tight text-white">
                                Browser-based forensic operations for students, labs, and controlled investigation workflows.
                            </h1>
                            <p class="mt-4 max-w-2xl text-sm leading-7 text-slate-400">
                                ForenDesk is built for evidence review, case coordination, integrity verification, reporting, and defensive learning. It excludes exploit tooling, credential theft, malware workflows, and destructive automation.
                            </p>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="fd-panel-muted p-5">
                                <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Command Center</p>
                                <p class="mt-3 text-sm text-slate-300">Track active cases, evidence locker state, queued processing tasks, and recent audit activity.</p>
                            </div>
                            <div class="fd-panel-muted p-5">
                                <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Evidence Guardrails</p>
                                <p class="mt-3 text-sm text-slate-300">Private storage, signed access patterns, audit trails, and safe preview-first analysis flows.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="fd-panel w-full max-w-xl self-center p-8">
                    <div class="mb-8 lg:hidden">
                        <x-application-logo />
                    </div>

                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
