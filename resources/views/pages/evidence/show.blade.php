@extends('layouts.workspace')

@section('content')
    <section class="grid gap-4 lg:grid-cols-4">
        <article class="fd-stat-card">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Reference</p>
            <p class="mt-4 text-xl font-semibold text-white">{{ $evidence->reference_id }}</p>
        </article>
        <article class="fd-stat-card">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Size</p>
            <p class="mt-4 text-xl font-semibold text-white">{{ number_format($evidence->size_bytes) }} B</p>
        </article>
        <article class="fd-stat-card">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Processing</p>
            <p class="mt-4 text-xl font-semibold text-white">{{ \Illuminate\Support\Str::headline($evidence->processing_status) }}</p>
        </article>
        <article class="fd-stat-card">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Tool Runs</p>
            <p class="mt-4 text-xl font-semibold text-white">{{ $evidence->tool_runs_count }}</p>
        </article>
    </section>

    <section class="grid gap-6 2xl:grid-cols-[1.15fr_0.85fr]">
        <div class="space-y-6">
            <article class="fd-panel p-6">
                <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Integrity</p>
                <div class="mt-6 space-y-3">
                    @forelse($evidence->hashes as $hash)
                        <div class="fd-panel-muted p-4">
                            <div class="flex items-center justify-between gap-4">
                                <p class="text-sm font-medium text-slate-100">{{ strtoupper($hash->algorithm) }}</p>
                                @if($hash->is_primary)
                                    <span class="fd-chip">Primary</span>
                                @endif
                            </div>
                            <p class="mt-3 break-all font-mono text-xs text-slate-400">{{ $hash->hash_value }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">No hashes recorded yet.</p>
                    @endforelse
                </div>
            </article>

            <article class="fd-panel p-6">
                <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Metadata Extraction</p>
                <div class="mt-6 space-y-4">
                    @forelse($evidence->metadataRecords as $record)
                        <div class="fd-panel-muted p-4">
                            <p class="text-sm font-medium text-slate-100">{{ $record->extractor }}</p>
                            <pre class="mt-4 overflow-x-auto rounded-xl bg-slate-950 p-4 font-mono text-xs text-slate-300">{{ json_encode($record->summary_json ?? $record->metadata_json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">Metadata extraction has not run yet.</p>
                    @endforelse
                </div>
            </article>
        </div>

        <div class="space-y-6">
            <article class="fd-panel p-6">
                <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Custody Log</p>
                <div class="mt-6 space-y-3">
                    @forelse($evidence->custodyLogs as $log)
                        <div class="border-l border-slate-800 pl-4">
                            <p class="text-sm font-medium text-slate-100">{{ \Illuminate\Support\Str::headline($log->action) }}</p>
                            <p class="mt-1 text-xs uppercase tracking-[0.18em] text-slate-500">{{ optional($log->occurred_at)->format('M d, Y H:i') }}</p>
                            <p class="mt-2 text-sm text-slate-400">{{ $log->from_party }} → {{ $log->to_party }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">No custody records yet.</p>
                    @endforelse
                </div>
            </article>

            <article class="fd-panel p-6">
                <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Notes</p>
                <div class="mt-6 space-y-3">
                    @forelse($evidence->notes as $note)
                        <div class="fd-panel-muted p-4">
                            <p class="text-sm font-medium text-slate-100">{{ optional($note->user)->display_name ?? 'Analyst' }}</p>
                            <p class="mt-2 text-sm leading-6 text-slate-400">{{ $note->content }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">No evidence notes yet.</p>
                    @endforelse
                </div>
            </article>
        </div>
    </section>
@endsection
