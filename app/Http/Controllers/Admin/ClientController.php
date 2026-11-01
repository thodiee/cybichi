<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\SecurityAuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::withCount(['invoices', 'agreements']);

        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where(function ($q) use ($s) {
                $q->where('contact_name', 'like', "%{$s}%")
                    ->orWhere('company_name', 'like', "%{$s}%")
                    ->orWhere('client_code', 'like', "%{$s}%")
                    ->orWhere('whatsapp_number', 'like', "%{$s}%");
            });
        }

        $clients = $query->latest()->paginate(10)->withQueryString();
        return view('admin.clients.index', compact('clients'));
    }

    public function create()
    {
        $nextCode = 'CLN-' . date('Y') . '-' . str_pad(Client::count() + 1, 3, '0', STR_PAD_LEFT);
        return view('admin.clients.create', compact('nextCode'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_code' => 'required|string|max:30|unique:clients,client_code',
            'contact_name' => 'required|string|max:120',
            'job_title' => 'nullable|string|max:100',
            'company_name' => 'nullable|string|max:150',
            'whatsapp_number' => 'required|string|max:25',
            'email' => 'nullable|email|max:150',
            'identity_number' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $client = Client::create($validated);
        SecurityAuditLog::record('client_created', $client, null, $client->only(['client_code', 'contact_name', 'company_name']));

        return redirect()->route('admin.clients.index')
            ->with('success', "Data klien '{$client->contact_name}' berhasil disimpan!");
    }

    public function edit(Client $client)
    {
        return view('admin.clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'client_code' => 'required|string|max:30|unique:clients,client_code,' . $client->id,
            'contact_name' => 'required|string|max:120',
            'job_title' => 'nullable|string|max:100',
            'company_name' => 'nullable|string|max:150',
            'whatsapp_number' => 'required|string|max:25',
            'email' => 'nullable|email|max:150',
            'identity_number' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $old = $client->only(['contact_name', 'company_name', 'whatsapp_number']);
        $client->update($validated);
        SecurityAuditLog::record('client_updated', $client, $old, $client->only(['contact_name', 'company_name', 'whatsapp_number']));

        return redirect()->route('admin.clients.index')
            ->with('success', "Data klien '{$client->contact_name}' berhasil diperbarui!");
    }

    public function destroy(Client $client)
    {
        if ($client->invoices()->exists() || $client->agreements()->exists()) {
            return back()->with('error', 'Klien ini memiliki riwayat Invoice atau Kontrak aktif sehingga tidak dapat dihapus demi integritas data.');
        }

        $name = $client->contact_name;
        SecurityAuditLog::record('client_deleted', $client, ['name' => $name]);
        $client->delete();

        return redirect()->route('admin.clients.index')
            ->with('success', "Data klien '{$name}' telah dihapus.");
    }
}
