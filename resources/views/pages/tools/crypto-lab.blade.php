@extends('layouts.workspace')

@section('content')
    <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        @foreach([
            ['title' => 'AES Demo', 'body' => 'Educational encryption and decryption of owned text with clear parameter display.'],
            ['title' => 'RSA Demo', 'body' => 'Keypair generation, signing, and verification for classroom workflows.'],
            ['title' => 'Hashing Lab', 'body' => 'Compare one-way hashing with reversible encryption and basic encodings.'],
            ['title' => 'Lawful Use', 'body' => 'No brute force tooling, ransomware behavior, or bypass techniques are included.'],
        ] as $card)
            <article class="fd-stat-card">
                <p class="text-xs uppercase tracking-[0.24em] text-slate-500">{{ $card['title'] }}</p>
                <p class="mt-4 text-sm leading-7 text-slate-300">{{ $card['body'] }}</p>
            </article>
        @endforeach
    </section>
@endsection
