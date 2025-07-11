@extends('layouts.app')

@section('content')
<div class="w-full px-6 py-4 relative">
    <!-- Tombol Kembali -->
    <a href="{{ route('overview') }}" class="absolute top-4 right-6 text-2xl text-gray-500 hover:text-black">
        &olarr;
    </a>

    <h1 class="text-2xl font-bold text-center mb-6">OVERVIEW DETAIL</h1>

    <div class="bg-white border shadow-md p-6 rounded-md text-sm">
        <!-- Header -->
        <h2 class="text-lg font-bold border-b pb-2 mb-4">Contract of Bring In</h2>

        <!-- Overview of Contract -->
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <p class="font-semibold">Overview of Contract</p>
                <p><strong>Contract Number:</strong> {{ $overview->contract_number }}</p>
                <p><strong>Contract Name:</strong> {{ $overview->contract_name }}</p>
            </div>
            <div>
                <p><strong>Contract Period:</strong> {{ $overview->contract_period }}</p>
                <p><strong>Contractor:</strong> {{ $overview->contractor }}</p>
            </div>
        </div>

        <!-- Status of Material -->
        <p class="font-semibold mb-2">Status of Material</p>
        <div class="grid grid-cols-3 gap-2 mb-6">
            @php
                $statuses = json_decode($overview->status_material ?? '[]', true);
                $allStatusOptions = [
                    'PT KP Product', 'PT KP by Product', 'Raw Material',
                    'MRO/Warehouse Stock', 'Engineering Procurement for Construction',
                    'Contruction Material', 'Waste (Domestic/wood)',
                    'Tool/Equipment/Heavy Equipment', 'Etc'
                ];
            @endphp
            @foreach($allStatusOptions as $label)
                <label class="flex items-center">
                    <input type="checkbox" disabled {{ in_array($label, $statuses) ? 'checked' : '' }}>
                    <span class="ml-2">{{ $label }}</span>
                </label>
            @endforeach
        </div>

        <!-- Item Spesifikasi -->
        <p class="font-semibold mb-2">Item Spesification and Quantity</p>
        <table class="w-full text-sm border mb-6">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-2 py-1">ITEM NAME</th>
                    <th class="border px-2 py-1">SPESIFICATION</th>
                    <th class="border px-2 py-1">QUANTITY</th>
                </tr>
            </thead>
            <tbody>
                @foreach($overview->items as $item)
                <tr>
                    <td class="border px-2 py-1">{{ $item->item_name }}</td>
                    <td class="border px-2 py-1">{{ $item->specification }}</td>
                    <td class="border px-2 py-1">{{ $item->quantity }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Reason & Transporter -->
        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <p class="font-semibold">Reason & Destination</p>
                <p><strong>Reason:</strong> {{ $overview->reason }}</p>
                <p><strong>Destination:</strong> {{ $overview->destination }}</p>
            </div>
            <div>
                <p class="font-semibold">Transporter & Security Inspection</p>
                <div class="grid grid-cols-3 gap-4">
                    <p><strong>Vehicle Police Number:</strong><br>{{ $overview->vehicle_number }}</p>
                    <p><strong>Driver Name:</strong><br>{{ $overview->driver_name }}</p>
                    <p><strong>Mobile Phone:</strong><br>{{ $overview->mobile_phone }}</p>
                </div>
            </div>
        </div>

        <!-- Footer Section -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8">
    <!-- Request By -->
    <div class="bg-blue-900 text-white p-4 rounded text-sm">
        <p class="uppercase text-xs font-semibold">Request by</p>
        <p class="font-bold">{{ $overview->approval->request_by ?? '-' }}</p>
        <p class="text-xs mt-1">
        {{ \Carbon\Carbon::parse($overview->approval->updated_at)->format('d F Y H:i:s') }}
        </p>
    </div>

    <!-- Approved or Rejected By -->
    @php
        $approvalStatus = $overview->approval->approval_by ?? 'Proposed';
        $isApproved = $approvalStatus === 'Approved';
        $isRejected = $approvalStatus === 'Reject';
        $boxColor = $isApproved ? 'bg-blue-900' : ($isRejected ? 'bg-red-700' : 'bg-gray-400');
    @endphp

    @if(!$isRejected && !$isApproved)
        <div class="bg-gray-200 text-black p-4 rounded text-sm flex items-center justify-center">
            <p class="text-center font-semibold">Waiting for Approval</p>
        </div>
    @else
        <div class="{{ $boxColor }} text-white p-4 rounded text-sm">
            <p class="uppercase text-xs font-semibold">
                {{ $isApproved ? 'Approved by' : 'Rejected by' }}
            </p>
            <p class="font-bold">{{ $overview->approval->approved_by_username ?? '-' }}</p>
            <p class="text-xs mt-1">
            {{ \Carbon\Carbon::parse($overview->approval->updated_at)->format('d F Y H:i:s') }}
            </p>
        </div>
    @endif

    <!-- Status + Action -->
    <div class="p-4 rounded text-sm border border-white">
        <p class="uppercase text-xs font-semibold mb-2">Status:</p>
        <div class="flex flex-wrap gap-2">
            <span class="px-4 py-2 rounded text-white text-sm font-semibold
                @if($isApproved) bg-green-500
                @elseif($isRejected) bg-red-500
                @else bg-yellow-500 @endif">
                {{ $approvalStatus }}
            </span>

            @if($isApproved)
                <a href="{{ route('overview.exportPdf', $overview->id) }}"
                    class="bg-yellow-500 hover:bg-orange-500 text-white px-4 py-2 rounded text-sm font-semibold">
                    Print PDF
                </a>
            @endif
        </div>
    </div>
</div>

    </div>
</div>
@endsection
