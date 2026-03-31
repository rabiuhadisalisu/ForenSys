@extends('layouts.workspace')

@section('content')
    <article class="fd-panel overflow-hidden">
        <div class="overflow-x-auto">
            <table class="fd-table">
                <thead>
                    <tr>
                        <th>Job Type</th>
                        <th>Queue</th>
                        <th>Status</th>
                        <th>Progress</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($jobs as $job)
                        <tr>
                            <td>{{ $job->job_type }}</td>
                            <td>{{ $job->queue }}</td>
                            <td>{{ \Illuminate\Support\Str::headline($job->status) }}</td>
                            <td>{{ $job->progress }}%</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-slate-500">No processing jobs queued.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </article>

    <div>
        {{ $jobs->links() }}
    </div>
@endsection
