<?php

namespace App\Izin\Http\Controllers\Auth;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Laporankegiatans;
use App\Izin\Models\Izin_Laporanpesertakegiatans;
use App\Izin\Models\Izin_Sertifikats;
use App\Izin\Models\Izin_Usulankegiatans;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SuperadminController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.superadmin');
    }
}
