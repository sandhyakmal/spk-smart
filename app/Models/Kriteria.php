<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $table = 'kriterias';

    protected $fillable = [
        'kode_kriteria',
        'nama_kriteria',
        'tipe',
        'bobot',
        'bobot_desimal',
    ];

    public function subKriterias()
    {
        return $this->hasMany(SubKriteria::class, 'kriteria_id');
    }

    public function nilais()
    {
        return $this->hasMany(Nilai::class);
    }
}