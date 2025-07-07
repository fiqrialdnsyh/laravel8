<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScreenOverview extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_number',
        'contract_period',
        'contract_name',
        'contractor',
        'bring_in_out',
        'status_material',
        'reason',
        'destination',
        'vehicle_number',
        'mobile_phone',
        'driver_name',
    ];

    // Relasi ke approval
    public function approval()
    {
        return $this->hasOne(\App\Models\ScreenApproval::class);
    }

    // Relasi ke item
    public function items()
    {
        return $this->hasMany(\App\Models\ScreenItem::class);
    }
}
