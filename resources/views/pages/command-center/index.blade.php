@extends('layouts.workspace')

@section('content')
    <section class="grid gap-4 md:grid-cols-2 2xl:grid-cols-4">
        @foreach($stats as $stat)
            <article class="fd-stat-card">
                <p class="text-xs uppercase tracking-[0.24em] text-slate-500">{{ $stat['label'] }}</p>
                <p class="mt-4 text-3xl font-semibold text-white">{{ number_format($stat['value']) }}</p>
                <p class="mt-3 text-sm text-slate-400">{{ $stat['caption'] }}</p>
            </article>
        @endforeach
    </section>

    <section class="grid gap-6 2xl:grid-cols-[1.25fr_0.75fr]">
        <div class="space-y-6">
            <article class="fd-panel p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Recent Cases</p>
                        <h2 class="mt-2 text-xl font-semibold text-white">Active investigations</h2>
                    </div>
                    <a href="{{ route('cases.index') }}" class="fd-chip">Open board</a>
                </div>

                <div class="mt-6 overflow-hidden rounded-2xl border border-slate-800/80">
                    <table class="fd-table">
                        <thead>
                            <tr>
                                <th>Case</th>
                                <th>Status</th>
                                <th>Evidence</th>
                                <th>Reports</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @forelse($recentCases as $case)
                                <tr>
                                    <td>
                                        <a href="{{ route('cases.show', $case) }}" class="font-medium text-slate-100 hover:text-cyan-100">{{ $case->title }}</a>
                                        <p class="mt-1 text-xs uppercase tracking-[0.18em] text-slate-500">{{ $case->case_number }}</p>
                                    </td>
                                    <td>{{ \Illuminate\Support\Str::headline($case->status) }}</td>
                                    <td>{{ $case->evidence_items_count }}</td>
                                    <td>{{ $case->forensic_reports_count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-slate-500">No active cases yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </article>

            <article class="fd-panel p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Evidence Locker</p>
                        <h2 class="mt-2 text-xl font-semibold text-white">Recent evidence activity</h2>
                    </div>
                </div>

                <div class="mt-6 grid gap-4 md:grid-cols-2">
                    @forelse($recentEvidence as $item)
                        <a href="{{ route('evidence.show', $item) }}" class="fd-panel-muted block p-5 transition hover:border-cyan-500/20 hover:bg-cyan-500/5">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm font-medium text-slate-100">{{ $item->display_name }}</p>
                                    <p class="mt-2 text-xs uppercase tracking-[0.18em] text-slate-500">{{ $item->reference_id }}</p>
                                </div>
                                <span class="rounded-full border border-slate-700 px-3 py-1 text-xs uppercase tracking-[0.2em] text-slate-500">{{ $item->category }}</span>
                            </div>
                            <p class="mt-4 text-sm text-slate-400">{{ number_format($item->size_bytes) }} bytes · {{ $item->processing_status }}</p>
                        </a>
                    @empty
                        <div class="fd-panel-muted p-5 text-sm text-slate-500">No evidence uploaded yet.</div>
                    @endforelse
                </div>
            </article>
        </div>

        <div class="space-y-6">
            <article class="fd-panel p-6">
                <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Processing Queue</p>
                <h2 class="mt-2 text-xl font-semibold text-white">Active jobs</h2>

                <div class="mt-6 space-y-3">
                    @forelse($processingJobs as $job)
                        <div class="fd-panel-muted p-4">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <p class="text-sm font-medium text-slate-100">{{ $job->job_type }}</p>
                                    <p class="mt-1 text-xs uppercase tracking-[0.18em] text-slate-500">{{ $job->queue }} queue</p>
                                </div>
                                <span class="fd-chip">{{ $job->status }}</span>
                            </div>
                            <div class="mt-4 h-2 rounded-full bg-slate-800">
                                <div class="h-2 rounded-full bg-cyan-400" style="width: {{ $job->progress }}%"></div>
                            </div>
                        </div>
                    @empty
                        <div class="fd-panel-muted p-4 text-sm text-slate-500">No processing jobs are queued.</div>
                    @endforelse
                </div>
            </article>

            <article class="fd-panel p-6">
                <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Activity Feed</p>
                <h2 class="mt-2 text-xl font-semibold text-white">Recent audit trail</h2>

                <div class="mt-6 space-y-4">
                    @forelse($activityFeed as $entry)
                        <div class="border-l border-slate-800 pl-4">
                            <p class="text-sm font-medium text-slate-100">{{ $entry->action }}</p>
                            <p class="mt-1 text-sm text-slate-400">{{ optional($entry->user)->display_name ?? 'System' }} · {{ optional($entry->occurred_at)->diffForHumans() }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">No audit activity captured yet.</p>
                    @endforelse
                </div>
            </article>

            <article class="fd-panel p-6">
                <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Featured Tools</p>
                <div class="mt-6 space-y-3">
                    @foreach($featuredTools as $tool)
                        <a href="{{ route('tools.show', $tool['slug']) }}" class="fd-panel-muted block p-4 transition hover:border-cyan-500/20">
                            <p class="text-sm font-medium text-slate-100">{{ $tool['name'] }}</p>
                            <p class="mt-2 text-sm text-slate-400">{{ $tool['description'] }}</p>
                        </a>
                    @endforeach
                </div>
            </article>
        </div>
    </section>
@endsection
