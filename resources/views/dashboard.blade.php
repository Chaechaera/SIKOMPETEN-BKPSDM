@php
    if (Auth::user()->hasRole('superadmin')) {
        header("Location: " . route('superadmin.dashboard'));
        exit;
    } elseif (Auth::user()->hasRole('admin')) {
        header("Location: " . route('admin.dashboard'));
        exit;
    } else {
        header("Location: " . route('user.dashboard'));
        exit;
    }
@endphp
