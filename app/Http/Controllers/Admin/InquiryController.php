<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\SecurityAuditLog;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inquiry::with(['product', 'invoice']);

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where(function ($q) use ($s) {
                $q->where('inquiry_code', 'like', "%{$s}%")
                    ->orWhere('client_name', 'like', "%{$s}%")
                    ->orWhere('company_name', 'like', "%{$s}%")
                    ->orWhere('whatsapp_number', 'like', "%{$s}%");
            });
        }

        $inquiries = $query->latest()->paginate(10)->withQueryString();
        return view('admin.inquiries.index', compact('inquiries'));
    }

    public function updateStatus(Request $request, Inquiry $inquiry)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,contacted,negotiation,converted_to_invoice,archived',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $old = $inquiry->status;
        $inquiry->update($validated);

        SecurityAuditLog::record('inquiry_status_updated', $inquiry, ['status' => $old], ['status' => $validated['status']]);

        return back()->with('success', "Status prospek '{$inquiry->inquiry_code}' berhasil diperbarui.");
    }
}
