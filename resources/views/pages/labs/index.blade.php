@extends('layouts.workspace')

@section('content')
    <section class="grid gap-4 lg:grid-cols-2 xl:grid-cols-3">
        @forelse($scenarios as $scenario)
            <a href="{{ route('labs.show', $scenario) }}" class="fd-panel block p-6 transition hover:border-cyan-500/20 hover:bg-cyan-500/5">
                <div class="flex items-center justify-between gap-4">
                    <span class="fd-chip">{{ \Illuminate\Support\Str::headline($scenario->difficulty) }}</span>
                    <span class="fd-chip">{{ \Illuminate\Support\Str::headline($scenario->status) }}</span>
                </div>
                <h2 class="mt-6 text-xl font-semibold text-white">{{ $scenario->title }}</h2>
                <p class="mt-3 text-sm leading-7 text-slate-400">{{ $scenario->overview }}</p>
                <p class="mt-4 text-sm text-slate-500">{{ $scenario->assets_count }} assets · {{ $scenario->assignments_count }} assignments</p>
            </a>
        @empty
            <article class="fd-panel p-6 text-sm text-slate-500">No lab scenarios available yet.</article>
        @endforelse
    </section>

    <div>
        {{ $scenarios->links() }}
    </div>
@endsection
