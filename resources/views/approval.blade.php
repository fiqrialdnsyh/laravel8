@extends('layouts.app')

@section('content')
<div class="w-full">
    <h1 class="text-2xl font-bold text-center mb-6">APPROVAL LIST</h1>
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-end mb-4">
        <form method="GET" action="{{ route('approval') }}" class="flex items-center w-full md:w-auto">
            <input type="text" name="search" placeholder="Type for search..." value="{{ request('search') }}"
                class="border rounded-l px-4 py-2 w-full md:w-96">
            <button type="submit"
                class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-4 py-2 rounded-r hover:opacity-90">
                Search
            </button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full border text-sm bg-white">
            <thead>
                <tr class="bg-gray-100 text-center">
                    <th class="border px-4 py-2">No</th>
                    <th class="border px-4 py-2">Date</th>
                    <th class="border px-4 py-2">Reason</th>
                    <th class="border px-4 py-2">Destination</th>
                    <th class="border px-4 py-2">Status</th>
                    <th class="border px-4 py-2">Bring IN/OUT</th>
                    <th class="border px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($approvals as $index => $overview)
                <tr class="text-center">
                    <td class="border px-4 py-2">
                        {{ $loop->iteration + ($approvals->currentPage() - 1) * $approvals->perPage() }}
                    </td>
                    <td class="border px-4 py-2">{{ $overview->created_at->format('d-m-Y') }}</td>
                    <td class="border px-4 py-2">{{ $overview->reason }}</td>
                    <td class="border px-4 py-2">{{ $overview->destination }}</td>
                    <td class="border px-4 py-2">
                        @php
                            $status = optional($overview->approval)->approval_by;
                        @endphp
                        @if ($status == 'Approved')
                            <span class="bg-green-400 text-white px-3 py-1 rounded">Approved</span>
                        @elseif ($status == 'Reject')
                            <span class="bg-red-400 text-white px-3 py-1 rounded">Reject</span>
                        @else
                            <span class="bg-yellow-400 text-white px-3 py-1 rounded">Proposed</span>
                        @endif
                    </td>
                    <td class="border px-4 py-2">{{ $overview->bring_in_out }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('approval.show', $overview->id) }}"
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
        {{ $approvals->links() }}
    </div>
</div>
@endsection
