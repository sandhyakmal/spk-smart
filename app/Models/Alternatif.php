<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alternatif extends Model
{
    use HasFactory;

    protected $table = 'alternatifs';

    protected $fillable = [
        'nama_alternatif',
    ];

    public function nilais()
    {
        return $this->hasMany(Nilai::class, 'alternatif_id');
    }
}
