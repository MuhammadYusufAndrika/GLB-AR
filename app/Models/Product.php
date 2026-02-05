<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'product_name',
        'description',
        'model_url',
        'poster_url',
        'qr_code_url',
        'category',
        'metadata',
        'view_count',
        'ar_activation_count',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'metadata' => 'array',
        'is_active' => 'boolean',
        'view_count' => 'integer',
        'ar_activation_count' => 'integer',
    ];

    /**
     * Increment view count for analytics.
     */
    public function incrementViews(): void
    {
        $this->increment('view_count');
    }

    /**
     * Increment AR activation count for analytics.
     */
    public function incrementArActivations(): void
    {
        $this->increment('ar_activation_count');
    }

    /**
     * Scope to get only active products.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get full URL for the 3D model.
     */
    public function getModelFullUrlAttribute(): string
    {
        if (filter_var($this->model_url, FILTER_VALIDATE_URL)) {
            return $this->model_url;
        }
        return asset('storage/' . $this->model_url);
    }

    /**
     * Get full URL for the poster image.
     */
    public function getPosterFullUrlAttribute(): ?string
    {
        if (!$this->poster_url) {
            return null;
        }
        if (filter_var($this->poster_url, FILTER_VALIDATE_URL)) {
            return $this->poster_url;
        }
        return asset('storage/' . $this->poster_url);
    }
}
