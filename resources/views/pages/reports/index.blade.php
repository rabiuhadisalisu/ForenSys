@extends('layouts.workspace')

@section('content')
    <article class="fd-panel overflow-hidden">
        <div class="border-b border-slate-800/70 p-6">
            <p class="text-sm text-slate-400">{{ $reports->total() }} reports available in the active workspace.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="fd-table">
                <thead>
                    <tr>
                        <th>Report</th>
                        <th>Case</th>
                        <th>Status</th>
                        <th>Author</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($reports as $report)
                        <tr>
                            <td>
                                <a href="{{ route('reports.show', $report) }}" class="font-medium text-slate-100 hover:text-cyan-100">{{ $report->title }}</a>
                                <p class="mt-1 text-xs uppercase tracking-[0.18em] text-slate-500">{{ $report->report_number }}</p>
                            </td>
                            <td>{{ optional($report->investigationCase)->case_number ?? 'Unlinked' }}</td>
                            <td>{{ \Illuminate\Support\Str::headline($report->status) }}</td>
                            <td>{{ optional($report->creator)->display_name ?? 'Unknown' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-slate-500">No reports drafted yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </article>

    <div>
        {{ $reports->links() }}
    </div>
@endsection
