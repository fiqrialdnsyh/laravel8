<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScreenApproval extends Model
{
    use HasFactory;

    protected $fillable = [
        'screen_overview_id',
        'request_by',
        'approval_by',
        'rejected_reason',
        'approved_by_username',
    ];

    public function overview()
    {
        return $this->belongsTo(\App\Models\ScreenOverview::class);
    }
}
