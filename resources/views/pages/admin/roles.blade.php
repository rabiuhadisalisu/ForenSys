@extends('layouts.workspace')

@section('content')
    <section class="grid gap-4 lg:grid-cols-2">
        @forelse($roles as $role)
            <article class="fd-panel p-6">
                <div class="flex items-center justify-between gap-4">
                    <h2 class="text-lg font-semibold text-white">{{ $role->name }}</h2>
                    <span class="fd-chip">{{ $role->organization_id ? 'Org scope' : 'Global' }}</span>
                </div>
                <div class="mt-4 flex flex-wrap gap-2">
                    @forelse($role->permissions as $permission)
                        <span class="fd-chip">{{ $permission->name }}</span>
                    @empty
                        <span class="text-sm text-slate-500">No permissions attached.</span>
                    @endforelse
                </div>
            </article>
        @empty
            <article class="fd-panel p-6 text-sm text-slate-500">No roles configured yet.</article>
        @endforelse
    </section>
@endsection
