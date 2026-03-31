@extends('layouts.workspace')

@section('content')
    <section class="grid gap-4 lg:grid-cols-3">
        <article class="fd-stat-card">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Evidence Items</p>
            <p class="mt-4 text-3xl font-semibold text-white">{{ $case->evidence_items_count }}</p>
        </article>
        <article class="fd-stat-card">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Reports</p>
            <p class="mt-4 text-3xl font-semibold text-white">{{ $case->forensic_reports_count }}</p>
        </article>
        <article class="fd-stat-card">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Audit Events</p>
            <p class="mt-4 text-3xl font-semibold text-white">{{ $case->audit_logs_count }}</p>
        </article>
    </section>

    <section class="grid gap-6 2xl:grid-cols-[1.15fr_0.85fr]">
        <div class="space-y-6">
            <article class="fd-panel p-6">
                <div class="flex flex-wrap gap-2">
                    <span class="fd-chip">{{ \Illuminate\Support\Str::headline($case->status) }}</span>
                    <span class="fd-chip">{{ \Illuminate\Support\Str::headline($case->classification) }}</span>
                    @foreach($case->labels as $label)
                        <span class="fd-chip">{{ $label->name }}</span>
                    @endforeach
                </div>

                <div class="mt-6 grid gap-4 md:grid-cols-2">
                    <div class="fd-panel-muted p-5">
                        <p class="text-xs uppercase tracking-[0.22em] text-slate-500">Lead Analyst</p>
                        <p class="mt-3 text-lg font-medium text-slate-100">{{ optional($case->leadAnalyst)->display_name ?? 'Unassigned' }}</p>
                    </div>
                    <div class="fd-panel-muted p-5">
                        <p class="text-xs uppercase tracking-[0.22em] text-slate-500">Opened</p>
                        <p class="mt-3 text-lg font-medium text-slate-100">{{ optional($case->opened_at)->format('M d, Y H:i') ?? 'Pending' }}</p>
                    </div>
                </div>
            </article>

            <article class="fd-panel p-6">
                <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Evidence</p>
                <div class="mt-6 space-y-3">
                    @forelse($case->evidenceItems as $item)
                        <a href="{{ route('evidence.show', $item) }}" class="fd-panel-muted block p-4">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <p class="text-sm font-medium text-slate-100">{{ $item->display_name }}</p>
                                    <p class="mt-1 text-xs uppercase tracking-[0.18em] text-slate-500">{{ $item->reference_id }}</p>
                                </div>
                                <span class="fd-chip">{{ $item->processing_status }}</span>
                            </div>
                        </a>
                    @empty
                        <p class="text-sm text-slate-500">No evidence has been attached to this case.</p>
                    @endforelse
                </div>
            </article>
        </div>

        <div class="space-y-6">
            <article class="fd-panel p-6">
                <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Timeline</p>
                <div class="mt-6 space-y-4">
                    @forelse($case->timelineEvents as $event)
                        <div class="border-l border-slate-800 pl-4">
                            <p class="text-sm font-medium text-slate-100">{{ $event->title }}</p>
                            <p class="mt-1 text-xs uppercase tracking-[0.18em] text-slate-500">{{ optional($event->event_at)->format('M d, Y H:i') }}</p>
                            <p class="mt-2 text-sm text-slate-400">{{ $event->description }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">No timeline events recorded yet.</p>
                    @endforelse
                </div>
            </article>

            <article class="fd-panel p-6">
                <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Notes</p>
                <div class="mt-6 space-y-4">
                    @forelse($case->notes as $note)
                        <div class="fd-panel-muted p-4">
                            <div class="flex items-center justify-between gap-4">
                                <p class="text-sm font-medium text-slate-100">{{ $note->title ?: \Illuminate\Support\Str::headline($note->note_type) }}</p>
                                <span class="fd-chip">{{ $note->visibility }}</span>
                            </div>
                            <p class="mt-3 text-sm leading-6 text-slate-400">{{ $note->content }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">No notes added yet.</p>
                    @endforelse
                </div>
            </article>
        </div>
    </section>
@endsection
