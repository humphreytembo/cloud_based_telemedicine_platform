@extends('doctor.layout')

@section('content')

<div style="width:100%;">

    <h2 style="
        margin-bottom:20px;
        color:#0f172a;
    ">
        Patient Messages
    </h2>

    @forelse($users as $user)

    <div style="
        background:#ffffff;
        padding:20px;
        margin-bottom:15px;
        border-radius:12px;
        display:flex;
        justify-content:space-between;
        align-items:center;
        width:100%;
        box-shadow:0 2px 8px rgba(0,0,0,0.08);
    ">

        <div>
            <strong style="
                font-size:16px;
                color:#111827;
            ">
                {{ $user->name }}
            </strong>
        </div>

        <div>
            <a href="{{ url('/chat/'.$user->id) }}" style="
                background:#2563eb;
                color:white;
                padding:10px 18px;
                border-radius:8px;
                text-decoration:none;
                font-size:14px;
                font-weight:600;
                display:inline-block;
            ">
                Open Chat
            </a>
        </div>

    </div>

    @empty

    <div style="
        background:#ffffff;
        padding:20px;
        border-radius:10px;
    ">
        No patient messages found.
    </div>

    @endforelse

</div>

@endsection