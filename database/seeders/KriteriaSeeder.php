<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KriteriaSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $kriterias = [
            [
                'kode_kriteria' => 'K1',
                'nama_kriteria' => 'Daya listrik',
                'bobot' => 12,
                'tipe' => 'cost',
            ],
            [
                'kode_kriteria' => 'K2',
                'nama_kriteria' => 'Jumlah Tanggungan',
                'bobot' => 16,
                'tipe' => 'benefit',
            ],
            [
                'kode_kriteria' => 'K3',
                'nama_kriteria' => 'Status Pekerjaan',
                'bobot' => 18,
                'tipe' => 'benefit',
            ],
            [
                'kode_kriteria' => 'K4',
                'nama_kriteria' => 'Status Tempat tinggal',
                'bobot' => 10,
                'tipe' => 'benefit',
            ],
            [
                'kode_kriteria' => 'K5',
                'nama_kriteria' => 'Pendapatan',
                'bobot' => 25,
                'tipe' => 'cost',
            ],
            [
                'kode_kriteria' => 'K6',
                'nama_kriteria' => 'Jenis Pekerjaan',
                'bobot' => 14,
                'tipe' => 'benefit',
            ],
            [
                'kode_kriteria' => 'K7',
                'nama_kriteria' => 'Tipe Rumah',
                'bobot' => 5,
                'tipe' => 'cost',
            ],
        ];

        foreach ($kriterias as $kriteria) {
            DB::table('kriterias')->updateOrInsert(
                [
                    'kode_kriteria' => $kriteria['kode_kriteria'],
                ],
                [
                    'nama_kriteria' => $kriteria['nama_kriteria'],
                    'bobot' => $kriteria['bobot'],
                    'bobot_desimal' => $kriteria['bobot'] / 100,
                    'tipe' => $kriteria['tipe'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        $kriteriaIds = DB::table('kriterias')
            ->pluck('id', 'kode_kriteria')
            ->toArray();


        $subKriterias = [
            'K1' => [
                [
                    'nama_sub_kriteria' => '900VA / 1300 VA',
                    'nilai' => 100,
                ],
                [
                    'nama_sub_kriteria' => '2200 VA',
                    'nilai' => 80,
                ],
                [
                    'nama_sub_kriteria' => '3500 VA',
                    'nilai' => 60,
                ],
                [
                    'nama_sub_kriteria' => '5500 VA / 6600 VA',
                    'nilai' => 40,
                ],
            ],

            'K2' => [
                [
                    'nama_sub_kriteria' => '>= 5',
                    'nilai' => 100,
                ],
                [
                    'nama_sub_kriteria' => '3 - 4',
                    'nilai' => 80,
                ],
                [
                    'nama_sub_kriteria' => '< 3',
                    'nilai' => 60,
                ],
            ],

            'K3' => [
                [
                    'nama_sub_kriteria' => 'Pekerjaan Tidak Tetap (Hanya Suami atau Istri)',
                    'nilai' => 100,
                ],
                [
                    'nama_sub_kriteria' => 'Pekerjaan Tidak Tetap (Suami & Istri)',
                    'nilai' => 80,
                ],
                [
                    'nama_sub_kriteria' => 'Pekerjaan Tetap (Hanya Suami atau Istri)',
                    'nilai' => 60,
                ],
                [
                    'nama_sub_kriteria' => 'Pekerjaan Tetap (Suami & Istri)',
                    'nilai' => 40,
                ],
            ],

            'K4' => [
                [
                    'nama_sub_kriteria' => 'Kontrak',
                    'nilai' => 100,
                ],
                [
                    'nama_sub_kriteria' => 'Orang Tua',
                    'nilai' => 80,
                ],
                [
                    'nama_sub_kriteria' => 'Milik Sendiri',
                    'nilai' => 60,
                ],
            ],

            'K5' => [
                [
                    'nama_sub_kriteria' => '< 1.000.000',
                    'nilai' => 100,
                ],
                [
                    'nama_sub_kriteria' => '>= 1.000.000 - <= 2.000.000',
                    'nilai' => 80,
                ],
                [
                    'nama_sub_kriteria' => '> 2.000.000 - <= 3.000.000',
                    'nilai' => 60,
                ],
                [
                    'nama_sub_kriteria' => '> 3.000.000',
                    'nilai' => 40,
                ],
            ],

            'K6' => [
                [
                    'nama_sub_kriteria' => 'Honorer',
                    'nilai' => 100,
                ],
                [
                    'nama_sub_kriteria' => 'Wiraswasta',
                    'nilai' => 80,
                ],
                [
                    'nama_sub_kriteria' => 'Aparatur',
                    'nilai' => 40,
                ],
            ],

            'K7' => [
                [
                    'nama_sub_kriteria' => 'Tipe 21/24',
                    'nilai' => 100,
                ],
                [
                    'nama_sub_kriteria' => 'Tipe 36',
                    'nilai' => 80,
                ],
                [
                    'nama_sub_kriteria' => 'Tipe 45',
                    'nilai' => 60,
                ],
            ],
        ];

        foreach ($subKriterias as $kodeKriteria => $items) {
            foreach ($items as $item) {
                DB::table('sub_kriterias')->updateOrInsert(
                    [
                        'kriteria_id' => $kriteriaIds[$kodeKriteria],
                        'nama_sub_kriteria' => $item['nama_sub_kriteria'],
                    ],
                    [
                        'nilai' => $item['nilai'],
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
            }
        }
    }
}