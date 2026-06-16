<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $totalEvent = Event::count();
        $totalPengguna = User::count();
        $tiketTerjual = Pendaftaran::count();
        $lokasiAktif = Event::distinct('eve_lokasi')->count('eve_lokasi');

        return view('dashboard', compact('totalEvent', 'totalPengguna', 'tiketTerjual', 'lokasiAktif'));
    }
}
