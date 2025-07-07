@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center justify-center min-h-screen w-full">
    <div class="w-full max-w-4xl flex flex-col gap-6">
        <!-- Approved -->
        <div class="w-full">
            <div class="bg-green-600 rounded-lg flex flex-col items-center justify-center py-10">
                <span class="text-5xl text-white font-bold">{{ $approvedCount }}</span>
                <span class="text-white text-lg mt-2">Approved</span>
            </div>
        </div>
        <!-- Proposed & Reject -->
        <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-yellow-500 rounded-lg flex flex-col items-center justify-center py-10">
                <span class="text-5xl text-white font-bold">{{ $proposedCount }}</span>
                <span class="text-white text-lg mt-2">Proposed</span>
            </div>
            <div class="bg-red-500 rounded-lg flex flex-col items-center justify-center py-10">
                <span class="text-5xl text-white font-bold">{{ $rejectedCount }}</span>
                <span class="text-white text-lg mt-2">Reject</span>
            </div>
        </div>
    </div>
</div>
@endsection
