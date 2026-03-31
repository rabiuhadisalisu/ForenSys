@extends('layouts.workspace')

@section('content')
    <article class="fd-panel overflow-hidden">
        <div class="overflow-x-auto">
            <table class="fd-table">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Actor</th>
                        <th>Case</th>
                        <th>Evidence</th>
                        <th>Severity</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($auditLogs as $log)
                        <tr>
                            <td>{{ $log->action }}</td>
                            <td>{{ optional($log->user)->display_name ?? 'System' }}</td>
                            <td>{{ optional($log->investigationCase)->case_number ?? 'n/a' }}</td>
                            <td>{{ optional($log->evidenceItem)->reference_id ?? 'n/a' }}</td>
                            <td>{{ \Illuminate\Support\Str::headline($log->severity) }}</td>
                            <td>{{ optional($log->occurred_at)->format('M d, Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-slate-500">No audit logs available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </article>

    <div>
        {{ $auditLogs->links() }}
    </div>
@endsection
