@php
    $workspaceUser = auth()->user();
    $activeOrganization = app()->bound('activeOrganization') ? app('activeOrganization') : $workspaceUser?->activeOrganization;
    $organizations = $workspaceUser?->organizations()->wherePivot('membership_status', 'active')->orderBy('name')->get() ?? collect();
    $navigation = [
        ['label' => 'Command Center', 'route' => 'command-center', 'key' => 'command-center'],
        ['label' => 'Cases', 'route' => 'cases.index', 'key' => 'cases'],
        ['label' => 'Tools', 'route' => 'tools.index', 'key' => 'tools'],
        ['label' => 'Crypto Lab', 'route' => 'crypto-lab.index', 'key' => 'crypto-lab'],
        ['label' => 'Reports', 'route' => 'reports.index', 'key' => 'reports'],
        ['label' => 'Audit', 'route' => 'audit.index', 'key' => 'audit'],
        ['label' => 'Labs', 'route' => 'labs.index', 'key' => 'labs'],
        ['label' => 'Admin', 'route' => 'admin.users.index', 'key' => 'admin'],
    ];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $pageTitle ?? 'ForenDesk' }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=ibm-plex-sans:400,500,600,700|jetbrains-mono:400,500,700&display=swap" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="font-sans antialiased">
        <div class="grid min-h-screen grid-cols-1 xl:grid-cols-[18rem_minmax(0,1fr)_20rem]">
            <aside class="border-b border-slate-800/70 bg-slate-950/90 px-6 py-8 xl:border-b-0 xl:border-r">
                <div class="space-y-8">
                    <a href="{{ route('command-center') }}" class="block">
                        <x-application-logo />
                    </a>

                    <div class="fd-panel-muted p-4">
                        <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Active Organization</p>
                        <div class="mt-3 space-y-2">
                            <p class="text-lg font-semibold text-slate-100">{{ $activeOrganization?->name ?? 'No organization' }}</p>
                            <p class="text-xs uppercase tracking-[0.22em] text-slate-500">{{ $activeOrganization?->code ?? 'Awaiting context' }}</p>
                        </div>

                        @if($organizations->isNotEmpty())
                            <form method="POST" action="{{ route('organizations.switch') }}" class="mt-4">
                                @csrf
                                <label for="organization_id" class="mb-2 block text-xs uppercase tracking-[0.18em] text-slate-500">Switch Workspace</label>
                                <select id="organization_id" name="organization_id" onchange="this.form.submit()" class="w-full rounded-2xl border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-slate-200 focus:border-cyan-500 focus:ring-cyan-500">
                                    @foreach($organizations as $organizationOption)
                                        <option value="{{ $organizationOption->id }}" @selected($organizationOption->is($activeOrganization))>
                                            {{ $organizationOption->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        @endif
                    </div>

                    <nav class="space-y-2">
                        @foreach($navigation as $item)
                            <a href="{{ route($item['route']) }}" class="fd-nav-link {{ ($activeNav ?? '') === $item['key'] ? 'fd-nav-link-active' : '' }}">
                                <span>{{ $item['label'] }}</span>
                                <span class="text-xs uppercase tracking-[0.22em] text-slate-600">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            </a>
                        @endforeach
                    </nav>

                    <div class="fd-panel-muted p-4">
                        <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Pinned Utilities</p>
                        <div class="mt-4 space-y-2 text-sm text-slate-300">
                            <a class="block rounded-xl border border-slate-800 px-3 py-2 hover:border-cyan-500/30 hover:text-cyan-100" href="{{ route('tools.show', 'hash-generator') }}">Hash Generator</a>
                            <a class="block rounded-xl border border-slate-800 px-3 py-2 hover:border-cyan-500/30 hover:text-cyan-100" href="{{ route('tools.show', 'metadata-viewer') }}">Metadata Viewer</a>
                            <a class="block rounded-xl border border-slate-800 px-3 py-2 hover:border-cyan-500/30 hover:text-cyan-100" href="{{ route('tools.show', 'signature-inspector') }}">Signature Inspector</a>
                        </div>
                    </div>
                </div>
            </aside>

            <main class="min-w-0 px-6 py-8 lg:px-10">
                <div class="mx-auto max-w-7xl space-y-8">
                    <div class="fd-panel p-6">
                        <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                            <div class="space-y-3">
                                <span class="fd-chip">Workspace Module</span>
                                <div>
                                    <h1 class="text-3xl font-semibold text-white">{{ $pageTitle ?? 'ForenDesk' }}</h1>
                                    <p class="mt-2 max-w-3xl text-sm leading-7 text-slate-400">{{ $pageDescription ?? 'Forensic operations workspace.' }}</p>
                                </div>
                            </div>

                            <div class="grid gap-3 text-sm text-slate-300 sm:grid-cols-2">
                                <div class="fd-panel-muted min-w-[13rem] p-4">
                                    <p class="text-xs uppercase tracking-[0.22em] text-slate-500">Analyst</p>
                                    <p class="mt-2 text-base font-medium text-slate-100">{{ $workspaceUser?->display_name ?? $workspaceUser?->name }}</p>
                                    <p class="mt-1 text-xs text-slate-500">{{ $workspaceUser?->job_title ?? 'Authenticated user' }}</p>
                                </div>
                                <div class="fd-panel-muted min-w-[13rem] p-4">
                                    <p class="text-xs uppercase tracking-[0.22em] text-slate-500">UTC Clock</p>
                                    <p class="mt-2 text-base font-medium text-slate-100">{{ now('UTC')->format('H:i') }}</p>
                                    <p class="mt-1 text-xs text-slate-500">{{ now('UTC')->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>

                        @if (session('status'))
                            <div class="mt-6 rounded-2xl border border-emerald-500/20 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-100">
                                {{ session('status') === 'organization-switched' ? 'Active organization updated.' : session('status') }}
                            </div>
                        @endif
                    </div>

                    @yield('content')
                </div>
            </main>

            <aside class="hidden border-l border-slate-800/70 bg-slate-950/80 px-6 py-8 xl:block">
                <div class="space-y-6">
                    <div class="fd-panel-muted p-5">
                        <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Operational Guardrails</p>
                        <ul class="mt-4 space-y-3 text-sm leading-6 text-slate-300">
                            <li>Lawful digital forensics and defensive learning only.</li>
                            <li>No exploit workflows, credential theft, or destructive automation.</li>
                            <li>Evidence access stays on private disks with signed delivery patterns.</li>
                        </ul>
                    </div>

                    <div class="fd-panel-muted p-5">
                        <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Quick Actions</p>
                        <div class="mt-4 space-y-2 text-sm">
                            <a class="block rounded-xl border border-slate-800 px-3 py-2 text-slate-300 hover:border-cyan-500/30 hover:text-cyan-100" href="{{ route('cases.index') }}">Open case board</a>
                            <a class="block rounded-xl border border-slate-800 px-3 py-2 text-slate-300 hover:border-cyan-500/30 hover:text-cyan-100" href="{{ route('reports.index') }}">Review reports</a>
                            <a class="block rounded-xl border border-slate-800 px-3 py-2 text-slate-300 hover:border-cyan-500/30 hover:text-cyan-100" href="{{ route('labs.index') }}">Inspect lab scenarios</a>
                        </div>
                    </div>

                    <div class="fd-panel-muted p-5">
                        <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Session</p>
                        <div class="mt-4 space-y-2 text-sm text-slate-300">
                            <p><span class="text-slate-500">Email:</span> {{ $workspaceUser?->email }}</p>
                            <p><span class="text-slate-500">Timezone:</span> {{ $workspaceUser?->timezone ?? 'UTC' }}</p>
                            <p><span class="text-slate-500">Organization:</span> {{ $activeOrganization?->slug ?? 'n/a' }}</p>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </body>
</html>
