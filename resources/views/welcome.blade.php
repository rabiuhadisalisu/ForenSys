<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'ForenDesk') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=ibm-plex-sans:400,500,600,700|jetbrains-mono:400,500,700&display=swap" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="font-sans antialiased">
        <div class="relative overflow-hidden">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(34,211,238,0.14),transparent_26%),radial-gradient(circle_at_top_right,rgba(96,165,250,0.12),transparent_24%),linear-gradient(180deg,rgba(15,23,42,0.98),rgba(2,6,23,1))]"></div>

            <div class="relative z-10 mx-auto max-w-7xl px-6 py-10 lg:px-10">
                <header class="flex flex-col gap-6 border-b border-slate-800/70 pb-8 lg:flex-row lg:items-center lg:justify-between">
                    <x-application-logo />

                    <div class="flex flex-wrap items-center gap-3">
                        @auth
                            <a href="{{ route('command-center') }}" class="rounded-2xl border border-cyan-500/30 bg-cyan-500/10 px-5 py-3 text-sm font-medium text-cyan-100">Open Command Center</a>
                        @else
                            <a href="{{ route('login') }}" class="rounded-2xl border border-slate-700 bg-slate-900/70 px-5 py-3 text-sm font-medium text-slate-200">Log in</a>
                            <a href="{{ route('register') }}" class="rounded-2xl border border-cyan-500/30 bg-cyan-500/10 px-5 py-3 text-sm font-medium text-cyan-100">Create Workspace</a>
                        @endauth
                    </div>
                </header>

                <section class="grid gap-10 py-16 lg:grid-cols-[1.2fr_0.8fr] lg:items-center">
                    <div class="space-y-8">
                        <span class="fd-chip">Lawful Digital Forensics</span>
                        <div class="space-y-5">
                            <h1 class="max-w-4xl text-4xl font-semibold leading-tight text-white sm:text-5xl">
                                A browser-based forensic command center built for evidence review, education, and defensible workflows.
                            </h1>
                            <p class="max-w-3xl text-base leading-8 text-slate-400">
                                ForenDesk blends a secure evidence workspace, modular forensic utilities, case intelligence, and a student lab environment. It is designed for lawful digital forensics, metadata analysis, incident response training, and reporting, with explicit exclusion of exploit tooling and destructive operations.
                            </p>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-3">
                            <div class="fd-stat-card">
                                <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Cases</p>
                                <p class="mt-3 text-2xl font-semibold text-white">Case boards</p>
                                <p class="mt-2 text-sm text-slate-400">Severity, priority, timeline, and findings in a single workspace.</p>
                            </div>
                            <div class="fd-stat-card">
                                <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Evidence</p>
                                <p class="mt-3 text-2xl font-semibold text-white">Locker-ready</p>
                                <p class="mt-2 text-sm text-slate-400">Private storage, hash verification, metadata extraction, and custody logs.</p>
                            </div>
                            <div class="fd-stat-card">
                                <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Learning</p>
                                <p class="mt-3 text-2xl font-semibold text-white">Student labs</p>
                                <p class="mt-2 text-sm text-slate-400">Safe cryptography education and guided forensic scenarios for owned data.</p>
                            </div>
                        </div>
                    </div>

                    <div class="fd-panel p-6">
                        <div class="flex items-center justify-between border-b border-slate-800/70 pb-4">
                            <div>
                                <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Featured Tools</p>
                                <h2 class="mt-2 text-xl font-semibold text-white">Safe Utility Catalog</h2>
                            </div>
                            <span class="fd-chip">{{ $featuredTools->count() }} ready</span>
                        </div>

                        <div class="mt-5 space-y-3">
                            @foreach($featuredTools as $tool)
                                <div class="rounded-2xl border border-slate-800/80 bg-slate-900/60 p-4">
                                    <div class="flex items-center justify-between gap-4">
                                        <div>
                                            <p class="text-sm font-medium text-slate-100">{{ $tool['name'] }}</p>
                                            <p class="mt-2 text-sm leading-6 text-slate-400">{{ $tool['description'] }}</p>
                                        </div>
                                        <span class="rounded-full border border-slate-700 px-3 py-1 text-xs uppercase tracking-[0.2em] text-slate-500">{{ $tool['family'] }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </body>
</html>
