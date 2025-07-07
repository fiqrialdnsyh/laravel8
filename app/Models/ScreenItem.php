<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScreenItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'screen_overview_id', // ✅ tambahkan ini
        'item_name',
        'specification',
        'quantity',
    ];

    // Relasi ke overview
    public function overview()
    {
        return $this->belongsTo(\App\Models\ScreenOverview::class);
    }
}
