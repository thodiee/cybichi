<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Agreement extends Model
{
    protected $fillable = [
        'uuid',
        'agreement_number',
        'client_id',
        'product_id',
        'invoice_id',
        'template_type',
        'project_name',
        'agreement_date',
        'start_date',
        'estimated_completion_date',
        'warranty_period_months',
        'contract_value',
        'payment_terms_summary',
        'scope_of_work',
        'agreement_clauses_html',
        'status',
        'verification_hash',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'agreement_date' => 'date',
            'start_date' => 'date',
            'estimated_completion_date' => 'date',
            'contract_value' => 'decimal:2',
            'warranty_period_months' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function ($agreement) {
            if (empty($agreement->uuid)) {
                $agreement->uuid = (string) Str::uuid();
            }
            if (empty($agreement->verification_hash)) {
                $agreement->verification_hash = hash('sha256', $agreement->uuid . '-' . microtime(true) . '-' . Str::random(16));
            }
        });
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getFormattedContractValueAttribute(): string
    {
        return 'Rp ' . number_format($this->contract_value, 0, ',', '.');
    }

    public function getSignedPortalUrlAttribute(): string
    {
        return url('/doc/view/' . $this->uuid);
    }

    public function getVerificationUrlAttribute(): string
    {
        return url('/verify/doc/' . $this->verification_hash);
    }
}
