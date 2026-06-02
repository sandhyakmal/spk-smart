<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HasilPerhitungan extends Model
{
    use HasFactory;

    protected $table = 'hasil_perhitungans';

    protected $fillable = [
        'periode_id',
        'alternatif_id',
        'nilai_utility',
        'nilai_akhir',
        'ranking',
    ];

    protected $casts = [
        'nilai_utility' => 'array',
        'nilai_akhir'   => 'decimal:4',
    ];

    // Relasi ke Periode
    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    // Relasi ke Alternatif
    public function alternatif()
    {
        return $this->belongsTo(Alternatif::class);
    }
}
