@extends('layouts.workspace')

@section('content')
    <section class="space-y-6">
        @foreach($tools as $family => $familyTools)
            <article class="fd-panel p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Tool Family</p>
                        <h2 class="mt-2 text-xl font-semibold text-white">{{ \Illuminate\Support\Str::headline($family) }}</h2>
                    </div>
                    <span class="fd-chip">{{ $familyTools->count() }} tools</span>
                </div>

                <div class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                    @foreach($familyTools as $tool)
                        <a href="{{ route('tools.show', $tool['slug']) }}" class="fd-panel-muted block p-5 transition hover:border-cyan-500/20 hover:bg-cyan-500/5">
                            <div class="flex items-center justify-between gap-4">
                                <p class="text-sm font-medium text-slate-100">{{ $tool['name'] }}</p>
                                <span class="fd-chip">{{ $tool['status'] }}</span>
                            </div>
                            <p class="mt-4 text-sm leading-6 text-slate-400">{{ $tool['description'] }}</p>
                        </a>
                    @endforeach
                </div>
            </article>
        @endforeach
    </section>
@endsection
