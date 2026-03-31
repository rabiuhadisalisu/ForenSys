@extends('layouts.workspace')

@section('content')
    <article class="fd-panel overflow-hidden">
        <div class="overflow-x-auto">
            <table class="fd-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Job Title</th>
                        <th>Active Organization</th>
                        <th>Verified</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($users as $user)
                        <tr>
                            <td>
                                <p class="font-medium text-slate-100">{{ $user->display_name ?? $user->name }}</p>
                                <p class="mt-1 text-xs text-slate-500">{{ $user->email }}</p>
                            </td>
                            <td>{{ $user->job_title ?? 'n/a' }}</td>
                            <td>{{ optional($user->activeOrganization)->name ?? 'None' }}</td>
                            <td>{{ $user->email_verified_at ? 'Yes' : 'No' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-slate-500">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </article>

    <div>
        {{ $users->links() }}
    </div>
@endsection
