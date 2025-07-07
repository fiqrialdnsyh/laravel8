<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScreenOverview;
use App\Models\ScreenItem;
use App\Models\ScreenApproval;
use Barryvdh\DomPDF\Facade\Pdf;

class ScreenController extends Controller
{
    // Simpan data dari form
    public function store(Request $request)
    {
        $validated = $request->validate([
            'contract_number' => 'required|string',
            'contract_period' => 'required|string',
            'contract_name' => 'required|string',
            'contractor' => 'required|string',
            'bring_in_out' => 'required|string',

            'status_material' => 'nullable|array',
            'status_material.*' => 'string',

            'items' => 'required|array',
            'items.*.name' => 'required|string',
            'items.*.spec' => 'required|string',
            'items.*.qty' => 'required|numeric',

            'reason' => 'nullable|string',
            'destination' => 'nullable|string',

            'vehicle_number' => 'nullable|string',
            'mobile_phone' => 'nullable|string',
            'driver_name' => 'nullable|string',

            'request_by' => 'nullable|string',
            'approval_by' => 'nullable|string',
        ]);

        $overview = ScreenOverview::create([
            'contract_number'   => $validated['contract_number'],
            'contract_period'   => $validated['contract_period'],
            'contract_name'     => $validated['contract_name'],
            'contractor'        => $validated['contractor'],
            'bring_in_out'      => $validated['bring_in_out'],
            'status_material'   => isset($validated['status_material']) ? json_encode($validated['status_material']) : null,
            'reason'            => $validated['reason'] ?? null,
            'destination'       => $validated['destination'] ?? null,
            'vehicle_number'    => $validated['vehicle_number'] ?? null,
            'mobile_phone'      => $validated['mobile_phone'] ?? null,
            'driver_name'       => $validated['driver_name'] ?? null,
        ]);

        foreach ($validated['items'] as $item) {
            ScreenItem::create([
                'screen_overview_id' => $overview->id,
                'item_name'          => $item['name'],
                'specification'      => $item['spec'],
                'quantity'           => $item['qty'],
            ]);
        }

        ScreenApproval::create([
            'screen_overview_id' => $overview->id,
            'request_by'         => $validated['request_by'] ?? null,
            'approval_by'        => $validated['approval_by'] ?? null,
        ]);

        return redirect()->route('overview')->with('success', 'Data berhasil disimpan!');
    }

    // Tampilkan semua overview
    public function overview(Request $request)
    {
        $query = ScreenOverview::with('approval');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('contract_name', 'like', "%$search%")
                    ->orWhere('contract_number', 'like', "%$search%")
                    ->orWhere('reason', 'like', "%$search%")
                    ->orWhere('destination', 'like', "%$search%");
            });
        }

        $overviews = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('overview', compact('overviews'));
    }

    // Tampilkan daftar approval
    public function approval(Request $request)
    {
        $query = ScreenOverview::with('approval');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('contract_name', 'like', "%$search%")
                    ->orWhere('contract_number', 'like', "%$search%")
                    ->orWhere('reason', 'like', "%$search%")
                    ->orWhere('destination', 'like', "%$search%");
            });
        }

        $approvals = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('approval', compact('approvals'));
    }

    // Tampilkan detail approval
    public function showApproval($id)
    {
        $overview = ScreenOverview::with(['items', 'approval'])->findOrFail($id);
        return view('approval.show', compact('overview'));
    }

    // Setujui dokumen
    public function approve($id)
    {
        $approval = ScreenApproval::where('screen_overview_id', $id)->firstOrFail();
        $approval->update(['approval_by' => 'Approved']);

        return redirect()->route('approval')->with('success', 'Dokumen berhasil disetujui.');
    }

    // Tolak dokumen
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejected_reason' => 'required|string|max:255',
        ]);

        $approval = ScreenApproval::where('screen_overview_id', $id)->firstOrFail();
        $approval->update([
            'approval_by' => 'Reject',
            'rejected_reason' => $request->rejected_reason,
        ]);
        return redirect()->route('approval')->with('success', 'Dokumen berhasil ditolak.');
    }

    // Tampilkan detail overview
    public function showOverview($id)
    {
        $overview = ScreenOverview::with(['items', 'approval'])->findOrFail($id);
        return view('overview.show', compact('overview'));
    }

    // Ekspor PDF
    public function exportPDF($id)
    {
        $overview = ScreenOverview::with(['items', 'approval'])->findOrFail($id);

        $pdf = PDF::loadView('overview.pdf', compact('overview'));
        return $pdf->download('overview_' . $overview->id . '.pdf');
    }

    // Halaman dashboard
    public function dashboard()
    {
        $approvedCount = \App\Models\ScreenApproval::where('approval_by', 'Approved')->count();
        $rejectedCount = \App\Models\ScreenApproval::where('approval_by', 'Reject')->count();
        $proposedCount = \App\Models\ScreenApproval::whereNull('approval_by')->count();

        return view('dashboard', compact('approvedCount', 'rejectedCount', 'proposedCount'));
    }


}
