<?php

namespace App\Izin\Http\Controllers\Auth;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_RefSubunitkerjas;
use App\Izin\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // ambil semua data sub unit kerja
        $subunitkerjas = Izin_RefSubunitkerjas::all();

        // kirim ke inertia register.vue
        return view('auth.register', [
            'subunitkerjas' => $subunitkerjas
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nip' => 'required|string|max:16',
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'subunitkerja_id' => 'nullable|exists:ref_subunitkerjas,id',
        ]);

        // Jika role = admin, cek apakah subunitkerja ini sudah ada admin
        if ($request->role === 'admin' && ! $request->subunitkerja_id) {
            throw ValidationException::withMessages(['subunitkerja_id' => 'Pilih Sub Unit Kerja OPD untuk akun admin']);
        }
        if ($request->role === 'admin') {
            $exists = User::where('subunitkerja_id', $request->subunitkerja_id)
                      ->where('role', 'admin')
                      ->exists();
            if ($exists) {
                throw ValidationException::withMessages(['subunitkerja_id' => 'Sub Unit Kerja OPD ini sudah memiliki admin']);
            }
        }

        $user = User::create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'role' => 'admin',
            'subunitkerja_id' => $request->subunitkerja_id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('admin.dashboard', absolute: false));
    }
}
