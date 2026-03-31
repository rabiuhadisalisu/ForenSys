@extends('layouts.workspace')

@section('content')
    <section class="grid gap-4 md:grid-cols-2">
        <article class="fd-stat-card">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Evidence Storage</p>
            <p class="mt-4 text-3xl font-semibold text-white">{{ number_format($evidenceBytes) }} B</p>
        </article>
        <article class="fd-stat-card">
            <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Lab Assets</p>
            <p class="mt-4 text-3xl font-semibold text-white">{{ number_format($labAssetBytes) }} B</p>
        </article>
    </section>

    <article class="fd-panel overflow-hidden">
        <div class="overflow-x-auto">
            <table class="fd-table">
                <thead>
                    <tr>
                        <th>Evidence</th>
                        <th>Reference</th>
                        <th>Size</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($recentEvidence as $item)
                        <tr>
                            <td>{{ $item->display_name }}</td>
                            <td>{{ $item->reference_id }}</td>
                            <td>{{ number_format($item->size_bytes) }} B</td>
                            <td>{{ \Illuminate\Support\Str::headline($item->processing_status) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-slate-500">No evidence records available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </article>
@endsection
