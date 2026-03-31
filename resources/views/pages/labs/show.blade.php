@extends('layouts.workspace')

@section('content')
    <section class="grid gap-6 2xl:grid-cols-[1.1fr_0.9fr]">
        <article class="fd-panel p-6">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Instructions</p>
            <p class="mt-6 text-sm leading-8 text-slate-300">{{ $scenario->instructions }}</p>

            <div class="mt-8">
                <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Assets</p>
                <div class="mt-4 space-y-3">
                    @forelse($scenario->assets as $asset)
                        <div class="fd-panel-muted p-4">
                            <p class="text-sm font-medium text-slate-100">{{ $asset->title }}</p>
                            <p class="mt-2 text-xs uppercase tracking-[0.18em] text-slate-500">{{ $asset->original_name }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">No assets attached yet.</p>
                    @endforelse
                </div>
            </div>
        </article>

        <article class="fd-panel p-6">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Assignments</p>
            <div class="mt-6 space-y-3">
                @forelse($scenario->assignments as $assignment)
                    <div class="fd-panel-muted p-4">
                        <p class="text-sm font-medium text-slate-100">{{ optional($assignment->user)->display_name ?? 'Learner' }}</p>
                        <p class="mt-2 text-sm text-slate-400">{{ \Illuminate\Support\Str::headline($assignment->status) }} · Score {{ $assignment->score ?? 'Pending' }}</p>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">No assignments created yet.</p>
                @endforelse
            </div>
        </article>
    </section>
@endsection
