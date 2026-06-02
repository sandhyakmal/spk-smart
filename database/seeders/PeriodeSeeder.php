<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeriodeSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $periodes = [
            [
                'nama_periode' => 'Periode 2024',
                'tahun' => 2024,
            ],
            [
                'nama_periode' => 'Periode 2025',
                'tahun' => 2025,
            ],
            [
                'nama_periode' => 'Periode 2026',
                'tahun' => 2026,
            ],
        ];

        foreach ($periodes as $periode) {
            DB::table('periodes')->updateOrInsert(
                [
                    'tahun' => $periode['tahun'],
                ],
                [
                    'nama_periode' => $periode['nama_periode'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }
}