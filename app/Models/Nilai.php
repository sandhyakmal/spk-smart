<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 'nilais';

    protected $fillable = [
        'periode_id',
        'alternatif_id',
        'kriteria_id',
        'sub_kriteria_id',
        'nilai',
    ];

    public function alternatif()
    {
        return $this->belongsTo(Alternatif::class, 'alternatif_id');
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id');
    }

    public function subKriteria()
    {
        return $this->belongsTo(SubKriteria::class, 'sub_kriteria_id');
    }
}