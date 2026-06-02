<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubKriteria extends Model
{
    protected $table = 'sub_kriterias';

    protected $fillable = [
        'kriteria_id',
        'nama_sub_kriteria',
        'nilai',
    ];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }
}