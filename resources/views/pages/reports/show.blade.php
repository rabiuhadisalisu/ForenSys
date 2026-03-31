@extends('layouts.workspace')

@section('content')
    <section class="grid gap-6 2xl:grid-cols-[1.1fr_0.9fr]">
        <article class="fd-panel p-6">
            <div class="flex flex-wrap gap-2">
                <span class="fd-chip">{{ \Illuminate\Support\Str::headline($report->status) }}</span>
                <span class="fd-chip">{{ $report->template_key }}</span>
            </div>

            <div class="mt-6 space-y-4">
                @forelse($report->sections as $section)
                    <div class="fd-panel-muted p-5">
                        <p class="text-sm font-medium text-slate-100">{{ $section->title }}</p>
                        <p class="mt-3 text-sm leading-7 text-slate-400">{{ $section->content }}</p>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">No report sections created yet.</p>
                @endforelse
            </div>
        </article>

        <article class="fd-panel p-6">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Version History</p>
            <div class="mt-6 space-y-3">
                @forelse($report->versions as $version)
                    <div class="fd-panel-muted p-4">
                        <p class="text-sm font-medium text-slate-100">Version {{ $version->version_number }}</p>
                        <p class="mt-2 text-sm text-slate-400">{{ $version->change_summary }}</p>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">No version snapshots yet.</p>
                @endforelse
            </div>
        </article>
    </section>
@endsection
