<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'setting_group',
        'setting_key',
        'setting_value',
        'setting_type',
        'updated_by',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'updated_at' => 'datetime',
        ];
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::rememberForever("site_setting_{$key}", function () use ($key, $default) {
            $setting = static::where('setting_key', $key)->first();
            if (!$setting) {
                return $default;
            }

            if ($setting->setting_type === 'json') {
                return json_decode($setting->setting_value, true) ?: $default;
            }

            if ($setting->setting_type === 'boolean') {
                return filter_var($setting->setting_value, FILTER_VALIDATE_BOOLEAN);
            }

            return $setting->setting_value ?? $default;
        });
    }

    public static function set(string $key, mixed $value, string $group = 'general', string $type = 'text', ?int $userId = null): void
    {
        $valToStore = is_array($value) ? json_encode($value) : (string) $value;

        static::updateOrCreate(
            ['setting_key' => $key],
            [
                'setting_group' => $group,
                'setting_value' => $valToStore,
                'setting_type' => $type,
                'updated_by' => $userId,
                'updated_at' => now(),
            ]
        );

        Cache::forget("site_setting_{$key}");
        Cache::forget('landing_page_data');
    }

    public static function getAllGrouped(): array
    {
        return static::all()->groupBy('setting_group')->map(function ($items) {
            return $items->pluck('setting_value', 'setting_key');
        })->toArray();
    }
}
