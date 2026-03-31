@extends('layouts.workspace')

@section('content')
    <section class="grid gap-6 2xl:grid-cols-[1.1fr_0.9fr]">
        <article class="fd-panel p-6">
            <div class="flex flex-wrap gap-2">
                <span class="fd-chip">{{ $tool['family'] }}</span>
                <span class="fd-chip">{{ $tool['status'] }}</span>
            </div>

            <div class="mt-6">
                <h2 class="text-2xl font-semibold text-white">{{ $tool['name'] }}</h2>
                <p class="mt-4 max-w-3xl text-sm leading-7 text-slate-400">{{ $tool['description'] }}</p>
            </div>

            <div class="mt-8 fd-panel-muted p-5">
                <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Phase 1-2 Workbench</p>
                <p class="mt-3 text-sm leading-7 text-slate-300">
                    This route is wired for the future AJAX tool sheet. In later phases it will accept validated input, run a dedicated service class, capture a tool run record, and render structured results without a full page reload.
                </p>
            </div>
        </article>

        <article class="fd-panel p-6">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Safety Constraints</p>
            <div class="mt-6 space-y-3 text-sm leading-7 text-slate-300">
                <p>Only user-supplied text, owned evidence, and sanctioned lab data should be processed here.</p>
                <p>No exploit development, credential extraction, stealth workflows, or unauthorized access operations will be added to this environment.</p>
                <p>Every future execution path will be logged to `tool_runs` and scoped to the active organization.</p>
            </div>
        </article>
    </section>
@endsection
