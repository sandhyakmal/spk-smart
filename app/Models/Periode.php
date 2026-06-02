<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;

    protected $table = 'periodes';

    protected $fillable = [
        'nama_periode',
        'tahun',
        'status',
    ];

    public function nilais()
    {
        return $this->hasMany(Nilai::class);
    }

    public function hasilPerhitungans()
    {
        return $this->hasMany(HasilPerhitungan::class);
    }
}