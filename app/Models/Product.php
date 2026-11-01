<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'product_code',
        'title',
        'slug',
        'client_or_industry',
        'base_price',
        'short_summary',
        'full_description',
        'key_features',
        'tech_stack',
        'thumbnail_path',
        'gallery_images',
        'has_live_demo',
        'demo_url',
        'demo_usage_guide',
        'demo_credentials',
        'show_credentials_publicly',
        'demo_reset_notice',
        'demo_health_status',
        'last_checked_at',
        'last_http_code',
        'is_featured',
        'is_active',
        'view_count',
        'demo_click_count',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'key_features' => 'array',
            'tech_stack' => 'array',
            'gallery_images' => 'array',
            'demo_credentials' => 'array',
            'has_live_demo' => 'boolean',
            'show_credentials_publicly' => 'boolean',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'last_checked_at' => 'datetime',
            'base_price' => 'decimal:2',
            'view_count' => 'integer',
            'demo_click_count' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class, 'category_id');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'product_id');
    }

    public function agreements(): HasMany
    {
        return $this->hasMany(Agreement::class, 'product_id');
    }

    public function getPublicCredentialsAttribute(): array
    {
        if (!$this->show_credentials_publicly || empty($this->demo_credentials)) {
            return [];
        }

        return is_array($this->demo_credentials) ? $this->demo_credentials : [];
    }

    public function isOnline(): bool
    {
        return $this->demo_health_status === 'online';
    }

    public function getWhatsAppInquiryMessageAttribute(): string
    {
        $adminWa = SiteSetting::get('contact_whatsapp', '6281234567890');
        $cleanWa = preg_replace('/[^0-9]/', '', $adminWa);

        $text = "Halo Tim CYBICHI, saya telah melihat portofolio/demo di website dan tertarik untuk berdiskusi lebih lanjut:\n"
            . "------------------------------------------------\n"
            . "Nama Produk : {$this->title} (Kode: {$this->product_code})\n"
            . ($this->demo_url ? "Link Demo   : {$this->demo_url}\n" : "")
            . "Kebutuhan   : Pemasangan / Kustomisasi untuk Perusahaan Kami\n"
            . "------------------------------------------------\n"
            . "Mohon informasi mengenai estimasi biaya, alur kerja sama (MoU), dan pemasangannya. Terima kasih.";

        return "https://wa.me/{$cleanWa}?text=" . rawurlencode($text);
    }
}
