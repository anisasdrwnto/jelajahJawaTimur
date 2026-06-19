<?php

namespace Database\Seeders;

use App\Models\MstEventPC1;
use App\Models\MstEventPc2;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seeder Admin → masuk PC 1
        DB::connection('db_pc1')->table('mst_users')->updateOrInsert(
            ['mus_email' => 'admin@jelajahjatim.com'],
            [
                'mus_id_users'   => 'ADM-' . strtoupper(Str::random(5)),
                'mus_name'       => 'Administrator',
                'mus_password'   => Hash::make('password123'),
                'mus_role'       => 'ADM',
                'mus_createBy'   => 'System',
                'mus_createDate' => now()
            ]
        );

        // 2. Seeder Event → routing ke PC1/PC2
        $kategoriPc1 = ['Festival', 'Kebudayaan'];

        $events = [
            [
                'eve_id_event'   => 'EVE-' . strtoupper(Str::random(5)),
                'eve_nama_event' => 'Banyuwangi Ethno Carnival',
                'eve_deskripsi'  => 'Rayakan keberagaman budaya lewat parade kostum etnik yang memukau di jantung Banyuwangi.',
                'eve_kategori'   => 'Festival',      // → PC 1
                'eve_tanggal'    => '2026-07-18',
                'eve_lokasi'     => 'Banyuwangi',
                'eve_gambar'     => 'assets/event1.jpeg',
                'eve_kuota'      => 100,
                'eve_createBy'   => 'System',
                'eve_createDate' => now()
            ],
            [
                'eve_id_event'   => 'EVE-' . strtoupper(Str::random(5)),
                'eve_nama_event' => 'Ijen Geopark Run 2026',
                'eve_deskripsi'  => 'Tantang dirimu berlari melintasi jalur vulkanik dengan pemandangan Kawah Ijen yang tak terlupakan.',
                'eve_kategori'   => 'Petualangan',   // → PC 2
                'eve_tanggal'    => '2026-08-23',
                'eve_lokasi'     => 'Kawah Ijen, Bondowoso',
                'eve_gambar'     => 'assets/event2.jpg',
                'eve_kuota'      => 200,
                'eve_createBy'   => 'System',
                'eve_createDate' => now()
            ],
            [
                'eve_id_event'   => 'EVE-' . strtoupper(Str::random(5)),
                'eve_nama_event' => 'Gandrung Sewu',
                'eve_deskripsi'  => 'Saksikan ribuan penari membawakan tarian Gandrung secara kolosal di tepi pantai Banyuwangi.',
                'eve_kategori'   => 'Kebudayaan',    // → PC 1
                'eve_tanggal'    => '2026-07-25',
                'eve_lokasi'     => 'Pantai Boom, Banyuwangi',
                'eve_gambar'     => 'assets/event3.jpg',
                'eve_kuota'      => 500,
                'eve_createBy'   => 'System',
                'eve_createDate' => now()
            ]
        ];

        foreach ($events as $event) {
            if (in_array($event['eve_kategori'], $kategoriPc1)) {
                MstEventPC1::updateOrCreate(
                    ['eve_nama_event' => $event['eve_nama_event']],
                    $event
                );
            } else {
                MstEventPc2::updateOrCreate(
                    ['eve_nama_event' => $event['eve_nama_event']],
                    $event
                );
            }
        }
    }
}