@extends('layouts.workspace')

@section('content')
    <article class="fd-panel overflow-hidden">
        <div class="overflow-x-auto">
            <table class="fd-table">
                <thead>
                    <tr>
                        <th>Group</th>
                        <th>Key</th>
                        <th>Scope</th>
                        <th>Public</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($settings as $setting)
                        <tr>
                            <td>{{ $setting->group }}</td>
                            <td>{{ $setting->key }}</td>
                            <td>{{ $setting->scope_key }}</td>
                            <td>{{ $setting->is_public ? 'Yes' : 'No' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-slate-500">No settings recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </article>
@endsection
