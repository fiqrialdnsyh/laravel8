@extends('layouts.app')

@section('content')
<div class="px-8 py-6 max-w-6xl mx-auto">

    <h1 class="text-center text-xl font-bold mb-6">APPROVAL VIEW</h1>

    <div class="bg-white shadow p-6 rounded-md">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2">Contract of Bring {{ $overview->bring_in_out }}</h2>

        {{-- Overview Contract --}}
        <div class="grid grid-cols-2 text-sm mb-6">
            <div class="space-y-2">
                <div><strong>Contract Number</strong><br>{{ $overview->contract_number }}</div>
                <div><strong>Contract Name</strong><br>{{ $overview->contract_name }}</div>
            </div>
            <div class="space-y-2">
                <div><strong>Contract Periode</strong><br>{{ $overview->contract_period }}</div>
                <div><strong>Contractor</strong><br>{{ $overview->contractor }}</div>
            </div>
        </div>

        {{-- Status Material --}}
        <div class="mb-6">
            <h3 class="font-semibold mb-2">Status of Material</h3>
            @php
                $status = json_decode($overview->status_material ?? '[]', true);
            @endphp
            <div class="grid grid-cols-2 md:grid-cols-3 gap-2 text-sm">
                @foreach ([
                    'PT KP Product',
                    'PT KP by Product',
                    'Raw Material',
                    'MRO/Warehouse Stock',
                    'Engineering Procurement for Construction',
                    'Contruction Material',
                    'Waste (Domestic/wood)',
                    'Tool/Equipment/Heavy Equipment',
                    'Etc'
                ] as $material)
                    <label class="inline-flex items-center space-x-2">
                        <input type="checkbox" disabled {{ in_array($material, $status ?? []) ? 'checked' : '' }}>
                        <span>{{ $material }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Item Table --}}
        <div class="mb-6">
            <h3 class="font-semibold mb-2">Item Spesification and Quantity</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm border">
                    <thead class="bg-gray-100 text-left">
                        <tr>
                            <th class="border px-4 py-2">ITEM NAME</th>
                            <th class="border px-4 py-2">SPESIFICATION</th>
                            <th class="border px-4 py-2">QUANTITY</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($overview->items as $item)
                        <tr>
                            <td class="border px-4 py-2">{{ $item->item_name }}</td>
                            <td class="border px-4 py-2">{{ $item->specification }}</td>
                            <td class="border px-4 py-2">{{ $item->quantity }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Reason & Destination --}}
        <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
            <div>
                <strong>Reason</strong><br>
                {{ $overview->reason }}
            </div>
            <div>
                <strong>Destination</strong><br>
                {{ $overview->destination }}
            </div>
        </div>

        {{-- Transporter Info --}}
        <div class="grid grid-cols-3 gap-4 text-sm mb-6">
            <div>
                <strong>Vehicle Police Number</strong><br>
                {{ $overview->vehicle_number }}
            </div>
            <div>
                <strong>Driver Name</strong><br>
                {{ $overview->driver_name }}
            </div>
            <div>
                <strong>Mobile Phone</strong><br>
                {{ $overview->mobile_phone }}
            </div>
        </div>

        {{-- Request Info --}}
        <div class="mb-6 text-sm">
            <div class="inline-block px-4 py-2 bg-blue-900 text-white rounded">
                <strong>Request by:</strong><br>
                {{ $overview->approval->request_by ?? '-' }}<br>
                <small>{{ $overview->created_at->format('d F, Y H:i:s') }}</small>
            </div>
        </div>

        {{-- Action Button --}}
        <div class="flex justify-end gap-4">
            <button onclick="openApproveModal()" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Approve
            </button>

            <button onclick="openRejectModal()" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                Reject
            </button>
        </div>
    </div>
</div>

{{-- Modal Approve --}}
<div id="approveModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white w-[400px] p-6 rounded shadow-lg text-sm text-center">
        <h2 class="text-lg font-semibold mb-3">Konfirmasi Persetujuan</h2>
        <p class="mb-4 leading-relaxed">
            Anda akan menyetujui dokumen ini. Pastikan data yang tercantum sudah benar dan sesuai. Setelah disetujui, data akan tersimpan sebagai persetujuan resmi.
        </p>
        <form method="POST" action="{{ route('approval.approve', $overview->id) }}">
            @csrf
            <div class="flex justify-center gap-2">
                <button type="button" onclick="closeApproveModal()" class="px-4 py-2 bg-yellow-500 rounded hover:bg-yellow-700 text-white">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Setujui
                </button>
            </div>
        </form>
    </div>
</div>


{{-- Modal Reject --}}
<div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white w-[400px] p-6 rounded shadow-lg text-sm text-center">
        <h2 class="text-lg font-semibold mb-3">Tolak Dokumen</h2>
        <p class="mb-3 leading-relaxed">
            Harap berikan alasan yang jelas mengapa dokumen ini ditolak agar dapat menjadi bahan evaluasi.
        </p>
        <form method="POST" action="{{ route('approval.reject', $overview->id) }}">
            @csrf
            <label class="block mb-2 text-left font-medium">Alasan Penolakan</label>
            <textarea name="rejected_reason" class="w-full border p-2 rounded mb-4 text-left" rows="3" placeholder="Tulis alasan anda..." required></textarea>
            <div class="flex justify-center gap-2">
                <button type="button" onclick="closeRejectModal()" class="px-4 py-2 bg-yellow-500 rounded hover:bg-yellow-700 text-white">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    Tolak
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openRejectModal() {
        document.getElementById('rejectModal').classList.remove('hidden');
    }
    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
    }

    function openApproveModal() {
        document.getElementById('approveModal').classList.remove('hidden');
    }
    function closeApproveModal() {
        document.getElementById('approveModal').classList.add('hidden');
    }
</script>
@endpush
