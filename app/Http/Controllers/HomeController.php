<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        // Ambil 3 event yang paling dekat/terbaru
        $events = Event::orderBy('eve_tanggal', 'asc')->take(3)->get();
        
        return view('home', compact('events'));
    }
}
