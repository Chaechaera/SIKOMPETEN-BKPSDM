<?php

namespace App\Izin\Http\Controllers\Auth;

use App\Izin\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use App\Izin\Models\User;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    /**
     * Verify the user's email from a signed verification link.
     */
    public function __invoke(Request $request, User $user): RedirectResponse
    {
        if (! hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            abort(403);
        }

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            $user->status = 'aktif';
            $user->save();

            event(new Verified($user));
        }

        return redirect('/login')
            ->with(
                'success',
                'Email berhasil diverifikasi. Silakan login.'
            );
    }
}
