<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServicePackage extends Model
{
    protected $fillable = [
        'category_id',
        'package_name',
        'badge_text',
        'price_amount',
        'billing_period',
        'specifications',
        'cta_whatsapp_template',
        'is_highlighted',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'price_amount' => 'decimal:2',
            'specifications' => 'array',
            'is_highlighted' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class, 'category_id');
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price_amount, 0, ',', '.');
    }

    public function getWhatsAppUrlAttribute(): string
    {
        $adminWa = SiteSetting::get('contact_whatsapp', '6281234567890');
        $cleanWa = preg_replace('/[^0-9]/', '', $adminWa);

        $text = $this->cta_whatsapp_template;
        if (empty($text)) {
            $text = "Halo Tim CYBICHI, saya tertarik dengan layanan *{$this->package_name}* ({$this->formatted_price} {$this->billing_period}). Mohon info detail instalasi dan ketersediaannya. Terima kasih.";
        }

        return "https://wa.me/{$cleanWa}?text=" . rawurlencode($text);
    }
}
