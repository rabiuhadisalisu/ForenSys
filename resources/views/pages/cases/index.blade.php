@extends('layouts.workspace')

@section('content')
    <article class="fd-panel overflow-hidden">
        <div class="flex flex-col gap-4 border-b border-slate-800/70 p-6 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex flex-wrap gap-3">
                <span class="fd-chip">All statuses</span>
                <span class="fd-chip">Severity tracked</span>
                <span class="fd-chip">Assignments visible</span>
            </div>
            <p class="text-sm text-slate-400">{{ $cases->total() }} cases in the active workspace.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="fd-table">
                <thead>
                    <tr>
                        <th>Case</th>
                        <th>Severity</th>
                        <th>Priority</th>
                        <th>Evidence</th>
                        <th>Reports</th>
                        <th>Members</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($cases as $case)
                        <tr>
                            <td>
                                <a href="{{ route('cases.show', $case) }}" class="font-medium text-slate-100 hover:text-cyan-100">{{ $case->title }}</a>
                                <p class="mt-1 text-xs uppercase tracking-[0.18em] text-slate-500">{{ $case->case_number }} · {{ \Illuminate\Support\Str::headline($case->status) }}</p>
                            </td>
                            <td>{{ \Illuminate\Support\Str::headline($case->severity) }}</td>
                            <td>{{ \Illuminate\Support\Str::headline($case->priority) }}</td>
                            <td>{{ $case->evidence_items_count }}</td>
                            <td>{{ $case->forensic_reports_count }}</td>
                            <td>{{ $case->members_count }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-slate-500">No cases are available yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </article>

    <div>
        {{ $cases->links() }}
    </div>
@endsection
