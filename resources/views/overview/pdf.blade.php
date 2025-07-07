<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Request Bringing In / Out Material</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; }
        .table-bordered td, .table-bordered th {
            border: 1px solid black;
            padding: 6px;
            text-align: left;
        }
        .center { text-align: center; }
        .bold { font-weight: bold; }
        .mt-2 { margin-top: 10px; }
        .mt-4 { margin-top: 20px; }
        .checkbox { display: inline-block; width: 12px; height: 12px; border: 1px solid #000; margin-right: 4px; }
        .section-title { font-weight: bold; margin-top: 10px; }
        .small { font-size: 10px; }
    </style>
</head>
<body>

    <h3 class="center">REQUEST BRINGING IN / OUT MATERIAL</h3>

    <table>
        <tr>
            <td><strong>Date:</strong> {{ \Carbon\Carbon::parse($overview->created_at)->format('d F Y') }}</td>
            <td><strong>Area:</strong> PT KBS</td>
        </tr>
    </table>

    <div class="section-title">1. Overview of Contract</div>
    <table class="table-bordered">
        <tr>
            <td>a. Contract Number</td>
            <td>{{ $overview->contract_number }}</td>
            <td>c. Contract Period</td>
            <td>{{ $overview->contract_period }}</td>
        </tr>
        <tr>
            <td>b. Contract Name</td>
            <td>{{ $overview->contract_name }}</td>
            <td>d. Contractor</td>
            <td>{{ $overview->contractor }}</td>
        </tr>
    </table>

    <div class="section-title">2. Status of Material</div>
    <table style="width: 100%;">
        @php
            $statuses = json_decode($overview->status_material ?? '[]', true);
            $allStatusOptions = [
                'PT KP Product', 'PT KP by Product', 'Raw Material',
                'MRO/Warehouse Stock', 'Engineering Procurement for Construction',
                'Tool/Equipment/Heavy Equipment', 'Contruction Material',
                'Waste (Domestic/wood)', 'Etc'
            ];
        @endphp
        <tr>
            @foreach($allStatusOptions as $i => $label)
                <td>
                    <div class="checkbox" style="border:1px solid black; display:inline-block;">
                        @if(in_array($label, $statuses)) &#10003; @endif
                    </div>
                    {{ $label }}
                </td>
                @if(($i+1) % 3 == 0)</tr><tr>@endif
            @endforeach
        </tr>
    </table>

    <div class="section-title mt-2">3. Item Specification and Quantity</div>
    <table class="table-bordered">
        <thead>
            <tr class="bold center">
                <th>No</th>
                <th>Name</th>
                <th>Specification</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            @foreach($overview->items as $index => $item)
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td>{{ $item->item_name }}</td>
                    <td>{{ $item->specification }}</td>
                    <td>{{ $item->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title mt-2">4. Transporter & Destination</div>
    <table class="table-bordered">
        <tr>
            <td><strong>Transporter:</strong> {{ $overview->reason }}</td>
            <td><strong>Destination:</strong> {{ $overview->destination }}</td>
        </tr>
    </table>

    <div class="section-title mt-2">5. Transporter & Security Inspection</div>
    <table class="table-bordered">
        <tr>
            <td><strong>Vehicle Police Number</strong></td>
            <td>{{ $overview->vehicle_number }}</td>
        </tr>
        <tr>
            <td><strong>Driver Name</strong></td>
            <td>{{ $overview->driver_name }}</td>
        </tr>
        <tr>
            <td><strong>Mobile Phone</strong></td>
            <td>{{ $overview->mobile_phone }}</td>
        </tr>
        <tr>
            <td><strong>Signature</strong></td>
            <td>______________________</td>
        </tr>
    </table>

    <div class="mt-4 small">
        <p><strong>Notes:</strong></p>
        <ol>
            <li>This Request should be made in three sheets and distributed to requestor, approval, security</li>
            <li>Requestor should be Site Manager and approval should be made by PT. KP authorize area or Team Leader</li>
            <li>Copy of “Request Bringing In-Out Material” or detail such as invoice and delivery list should be attached</li>
            <li>All responsibility about theft is belonging to contractor except the material with PT. KP purchased</li>
        </ol>
    </div>

</body>
</html>
