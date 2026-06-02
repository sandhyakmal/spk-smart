<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlternatifNilaiSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $periode = DB::table('periodes')
            ->where('tahun', 2026)
            ->first();

        if (!$periode) {
            throw new \Exception('Periode tahun 2026 belum ada. Jalankan PeriodeSeeder terlebih dahulu.');
        }

        $kriteriaIds = DB::table('kriterias')
            ->pluck('id', 'kode_kriteria')
            ->toArray();

        $alternatifs = [
            'Jasmin' => [
                'K1' => 60,
                'K2' => 60,
                'K3' => 60,
                'K4' => 60,
                'K5' => 40,
                'K6' => 80,
                'K7' => 60,
            ],
            'Aswir' => [
                'K1' => 100,
                'K2' => 80,
                'K3' => 40,
                'K4' => 60,
                'K5' => 60,
                'K6' => 80,
                'K7' => 80,
            ],
            'Herman' => [
                'K1' => 100,
                'K2' => 100,
                'K3' => 80,
                'K4' => 100,
                'K5' => 80,
                'K6' => 100,
                'K7' => 100,
            ],
            'Suripto' => [
                'K1' => 80,
                'K2' => 80,
                'K3' => 40,
                'K4' => 60,
                'K5' => 40,
                'K6' => 80,
                'K7' => 80,
            ],
        ];

        foreach ($alternatifs as $namaAlternatif => $nilaiKriterias) {
            DB::table('alternatifs')->updateOrInsert(
                [
                    'nama_alternatif' => $namaAlternatif,
                ],
                [
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );

            $alternatif = DB::table('alternatifs')
                ->where('nama_alternatif', $namaAlternatif)
                ->first();

            foreach ($nilaiKriterias as $kodeKriteria => $nilai) {
                if (!isset($kriteriaIds[$kodeKriteria])) {
                    throw new \Exception("Kriteria {$kodeKriteria} belum ada. Jalankan KriteriaSeeder terlebih dahulu.");
                }

                $kriteriaId = $kriteriaIds[$kodeKriteria];

                $subKriteria = DB::table('sub_kriterias')
                    ->where('kriteria_id', $kriteriaId)
                    ->where('nilai', $nilai)
                    ->first();

                if (!$subKriteria) {
                    throw new \Exception("Sub kriteria untuk {$kodeKriteria} dengan nilai {$nilai} belum ada.");
                }

                DB::table('nilais')->updateOrInsert(
                    [
                        'periode_id' => $periode->id,
                        'alternatif_id' => $alternatif->id,
                        'kriteria_id' => $kriteriaId,
                    ],
                    [
                        'sub_kriteria_id' => $subKriteria->id,
                        'nilai' => null,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
            }
        }
    }
}