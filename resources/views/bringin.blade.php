@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center min-h-screen w-full bg-gray-100 py-8">
    <div class="w-full max-w-5xl flex flex-col gap-6">
        <form id="main-form" method="POST" action="{{ route('screen.save') }}">
            @csrf

            <!-- Overview of Contract -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="font-bold text-lg mb-4">Overview of Contract</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Contract Number</label>
                        <input type="text" name="contract_number" class="mt-1 w-full border rounded px-3 py-2" placeholder="Insert Contract Number">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Contract Periode</label>
                        <input type="text" name="contract_period" class="mt-1 w-full border rounded px-3 py-2" placeholder="Insert Contract Periode">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Contract Name</label>
                        <input type="text" name="contract_name" class="mt-1 w-full border rounded px-3 py-2" placeholder="Insert Contract Name">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Contractor</label>
                        <input type="text" name="contractor" class="mt-1 w-full border rounded px-3 py-2" placeholder="Insert Contractor">
                    </div>
                    <div class="md:col-span-2 flex items-center mt-2">
                        <label class="block text-sm font-medium mr-2">Bring In/Out</label>
                        <select name="bring_in_out" class="border rounded px-3 py-2">
                            <option disabled selected>Pilih opsi</option>
                            <option value="Bring In">Bring In</option>
                            <option value="Bring Out">Bring Out</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Status of Material -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="font-bold text-lg mb-4">Status of Material</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    @php
                        $materials = [
                            'PT KP Product', 'PT KP by Product', 'Raw Material',
                            'MRO/Warehouse Stock', 'Engineering Procurement for Construction',
                            'Construction Material', 'Waste (Domestic/wood)',
                            'Tool/Equipment/Heavy Equipment', 'Etc'
                        ];
                    @endphp
                    @foreach(array_chunk($materials, ceil(count($materials) / 2)) as $group)
                        <div class="space-y-1">
                            @foreach($group as $material)
                                <label class="block">
                                    <input type="checkbox" name="status_material[]" value="{{ $material }}" class="mr-2">
                                    {{ $material }}
                                </label>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Item Specification and Quantity -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="font-bold text-lg mb-4">Item Specification and Quantity</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full border text-sm" id="item-table">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 border">ITEM NAME</th>
                                <th class="px-4 py-2 border">SPECIFICATION</th>
                                <th class="px-4 py-2 border">QUANTITY</th>
                                <th class="px-4 py-2 border w-10">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="item-table-body">
                            <tr>
                                <td class="border px-4 py-2">
                                    <input type="text" name="items[0][name]" class="w-full border rounded px-2 py-1" placeholder="Item Name">
                                </td>
                                <td class="border px-4 py-2">
                                    <input type="text" name="items[0][spec]" class="w-full border rounded px-2 py-1" placeholder="Specification">
                                </td>
                                <td class="border px-4 py-2">
                                    <input type="number" name="items[0][qty]" class="w-full border rounded px-2 py-1" placeholder="Quantity">
                                </td>
                                <td class="border px-4 py-2 text-center">
                                    <button type="button" onclick="removeRow(this)" class="text-red-500 font-bold">-</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" onclick="addRow()" class="mt-3 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        + Tambah Baris
                    </button>
                </div>
            </div>

            <!-- Reason & Destination -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="font-bold text-lg mb-4">Reason & Destination</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Reason</label>
                        <input type="text" name="reason" class="mt-1 w-full border rounded px-3 py-2" placeholder="Insert Reason">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Destination</label>
                        <input type="text" name="destination" class="mt-1 w-full border rounded px-3 py-2" placeholder="Insert Destination">
                    </div>
                </div>
            </div>

            <!-- Transporter -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="font-bold text-lg mb-4">Transporter Info</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Vehicle Police Number</label>
                        <input type="text" name="vehicle_number" class="mt-1 w-full border rounded px-3 py-2" placeholder="Insert No Vehicle">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Mobile Phone</label>
                        <input type="text" name="mobile_phone" class="mt-1 w-full border rounded px-3 py-2" placeholder="Insert Phone Number">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Driver Name</label>
                        <input type="text" name="driver_name" class="mt-1 w-full border rounded px-3 py-2" placeholder="Insert Driver Name">
                    </div>
                </div>
            </div>

            <!-- Approval Info (tanpa status) -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="font-bold text-lg mb-4">Approval Info</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Request By</label>
                        <select name="request_by" class="mt-1 w-full border rounded px-3 py-2" required>
                            <option disabled selected>Request By</option>
                            <option value="Krakatau Posco">Krakatau Posco</option>
                            <option value="Krakatau Bandar Samudera">Krakatau Bandar Samudera</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Approval By</label>
                        <select name="approval_by" class="mt-1 w-full border rounded px-3 py-2" required>
                            <option disabled selected>Approval By</option>
                            <option value="Krakatau Posco">Krakatau Posco</option>
                            <option value="Krakatau Bandar Samudera">Krakatau Bandar Samudera</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-4">
                <button type="submit" class="bg-indigo-500 text-white px-10 py-3 rounded shadow hover:bg-indigo-600">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let itemIndex = 1;

    function addRow() {
        const tbody = document.getElementById('item-table-body');
        const row = document.createElement('tr');

        row.innerHTML = `
            <td class="border px-4 py-2">
                <input type="text" name="items[${itemIndex}][name]" class="w-full border rounded px-2 py-1" placeholder="Item Name">
            </td>
            <td class="border px-4 py-2">
                <input type="text" name="items[${itemIndex}][spec]" class="w-full border rounded px-2 py-1" placeholder="Specification">
            </td>
            <td class="border px-4 py-2">
                <input type="number" name="items[${itemIndex}][qty]" class="w-full border rounded px-2 py-1" placeholder="Quantity">
            </td>
            <td class="border px-4 py-2 text-center">
                <button type="button" onclick="removeRow(this)" class="text-red-500 font-bold">-</button>
            </td>
        `;

        tbody.appendChild(row);
        itemIndex++;
    }

    function removeRow(button) {
        const row = button.closest('tr');
        row.remove();
    }
</script>
@endpush
