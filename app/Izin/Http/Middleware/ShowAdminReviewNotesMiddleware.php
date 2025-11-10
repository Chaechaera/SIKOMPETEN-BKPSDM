<?php

namespace App\Izin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class ShowAdminReviewNotesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ambil catatan review yang disimpan di cache
        //$noteusulan_kegiatan = Cache::get('pending_note_usulan_kegiatan_for_admin'); // ambil dan hapus dari cache

        //if ($noteusulan_kegiatan) {
            // Menyimpan note ke session untuk ditampilkan di dashboard
            //Session::flash('pending_note_usulan_kegiatan_for_admin', $noteusulan_kegiatan);
        //}

        // Ambil note dari cache
        /*if (Cache::has('pending_note_usulan_kegiatan_for_admin')) {
            $note = Cache::pull('pending_note_usulan_kegiatan_for_admin');
            // Simpan ke session flash agar muncul di view
            Session::flash('note_usulan_kegiatan', $note);
        }*/
        $user = Auth::user();

        if ($user) {
            // Key unik per admin
            $cacheKey = 'pending_note_usulan_kegiatan_for_admin_' . $user->id;

            if (Cache::has($cacheKey)) {
                // Ambil lalu hapus dari cache agar tidak muncul dua kali
                $noteusulan_kegiatan = Cache::pull($cacheKey);
                // Simpan sementara di session (flash)
                Session::flash('noteusulan_kegiatan', $noteusulan_kegiatan);
            }
        }
        
        return $next($request);
    }
}
