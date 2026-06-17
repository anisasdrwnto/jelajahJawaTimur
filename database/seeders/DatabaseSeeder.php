<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seeder Admin User
        User::updateOrCreate(
            ['mus_email' => 'admin@jelajahjatim.com'],
            [
                'mus_id_users' => 'ADM-' . strtoupper(Str::random(5)),
                'mus_name' => 'Administrator',
                'mus_password' => Hash::make('password123'),
                'mus_role' => 'ADM',
                'mus_createBy' => 'System',
                'mus_createDate' => now()
            ]
        );

        // 2. Seeder 3 Event Awal (Dari Desain Hardcode Anisa)
        $events = [
            [
                'eve_id_event' => 'EVE-' . strtoupper(Str::random(5)),
                'eve_nama_event' => 'Banyuwangi Ethno Carnival',
                'eve_deskripsi' => 'Rayakan keberagaman budaya lewat parade kostum etnik yang memukau di jantung Banyuwangi.',
                'eve_kategori' => 'Festival',
                'eve_tanggal' => '2026-07-18',
                'eve_lokasi' => 'Banyuwangi',
                'eve_gambar' => 'assets/event1.jpeg',
                'eve_kuota' => 100,
                'eve_createBy' => 'System',
                'eve_createDate' => now()
            ],
            [
                'eve_id_event' => 'EVE-' . strtoupper(Str::random(5)),
                'eve_nama_event' => 'Ijen Geopark Run 2026',
                'eve_deskripsi' => 'Tantang dirimu berlari melintasi jalur vulkanik dengan pemandangan Kawah Ijen yang tak terlupakan.',
                'eve_kategori' => 'Petualangan',
                'eve_tanggal' => '2026-08-23',
                'eve_lokasi' => 'Kawah Ijen, Bondowoso',
                'eve_gambar' => 'assets/event2.jpg',
                'eve_kuota' => 200,
                'eve_createBy' => 'System',
                'eve_createDate' => now()
            ],
            [
                'eve_id_event' => 'EVE-' . strtoupper(Str::random(5)),
                'eve_nama_event' => 'Gandrung Sewu',
                'eve_deskripsi' => 'Saksikan ribuan penari membawakan tarian Gandrung secara kolosal di tepi pantai Banyuwangi.',
                'eve_kategori' => 'Kebudayaan',
                'eve_tanggal' => '2026-07-25',
                'eve_lokasi' => 'Pantai Boom, Banyuwangi',
                'eve_gambar' => 'assets/event3.jpg',
                'eve_kuota' => 500,
                'eve_createBy' => 'System',
                'eve_createDate' => now()
            ]
        ];

        foreach ($events as $event) {
            Event::updateOrCreate(
                ['eve_nama_event' => $event['eve_nama_event']], // Jangan duplikat jika di run ulang
                $event
            );
        }
    }
}
