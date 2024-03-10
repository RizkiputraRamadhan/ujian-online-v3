<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mapel extends Model
{
    use HasFactory;
    protected $table = 'mapel';
    protected $guarded = [];
    public function tahun(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class, 'tahunajaran_id', 'id');
    }
}
