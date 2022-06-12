<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BacklinkLog extends Model
{
    use HasFactory;

    protected $table = 'backlinks_log';
    protected $guarded = ['id'];

    public function backlink()
    {
        return $this->belongsTo(Backlink::class);
    }
}
