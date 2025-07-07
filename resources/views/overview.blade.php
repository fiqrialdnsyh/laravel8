@extends('layouts.app')

@section('content')
<div class="w-full">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">OVERVIEW LIST</h1>
        <form method="GET" action="{{ route('overview') }}" class="flex items-center">
            <input type="text" name="search" placeholder="Type for search..." value="{{ request('search') }}"
                class="border rounded-l px-4 py-2 w-64">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-r hover:bg-blue-700">
                Search
            </button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border text-sm">
            <thead>
                <tr class="bg-gray-100 text-center">
                    <th class="px-4 py-2 border">No</th>
                    <th class="px-4 py-2 border">Date</th>
                    <th class="px-4 py-2 border">Bring</th>
                    <th class="px-4 py-2 border">Reason</th>
                    <th class="px-4 py-2 border">Destination</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($overviews as $index => $overview)
                <tr class="text-center">
                    <td class="border px-4 py-2">
                        {{ $loop->iteration + ($overviews->currentPage() - 1) * $overviews->perPage() }}
                    </td>
                    <td class="border px-4 py-2">{{ $overview->created_at->format('d - m - Y') }}</td>
                    <td class="border px-4 py-2">{{ $overview->bring_in_out }}</td>
                    <td class="border px-4 py-2 text-left">{{ $overview->reason }}</td>
                    <td class="border px-4 py-2 text-left">{{ $overview->destination }}</td>
                    <td class="border px-4 py-2">
                        @php
                            $status = optional($overview->approval)->approval_by;
                        @endphp
                        @if ($status == 'Approved')
                            <span class="bg-green-500 text-white px-3 py-1 rounded">Approved</span>
                        @elseif ($status == 'Reject')
                            <span class="bg-red-500 text-white px-3 py-1 rounded">Reject</span>
                        @else
                            <span class="bg-yellow-400 text-white px-3 py-1 rounded">Proposed</span>
                        @endif
                    </td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('overview.show', $overview->id) }}"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded">
                            View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-gray-500 py-4">Data not found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $overviews->links() }}
    </div>
</div>
@endsection
