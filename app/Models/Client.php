<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $fillable = [
        'client_code',
        'contact_name',
        'job_title',
        'company_name',
        'whatsapp_number',
        'email',
        'identity_number',
        'address',
        'notes',
    ];

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'client_id')->latest();
    }

    public function agreements(): HasMany
    {
        return $this->hasMany(Agreement::class, 'client_id')->latest();
    }

    public function getCleanWhatsappAttribute(): string
    {
        $num = preg_replace('/[^0-9]/', '', $this->whatsapp_number);
        if (str_starts_with($num, '0')) {
            $num = '62' . substr($num, 1);
        }
        return $num;
    }
}
