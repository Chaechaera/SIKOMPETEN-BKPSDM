<!DOCTYPE html>
<html>
<head>
    <title>Email Terverifikasi</title>
    <style>
        body {
            font-family: 'Merriweather', serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }

        .header {
            background-color: #244031;
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }

        .content-container {
            background-color: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .message {
            margin-bottom: 20px;
            line-height: 1.8;
        }

        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #244031;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            color: #666;
            font-size: 14px;
        }

        .accent-text {
            color: #C4A484;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Email Terverifikasi</h2>
    </div>
    
    <div class="content-container">
        <div class="message">
            <p>Halo <strong>{{ $user->name }}</strong>,</p>
            
            <p>Email Anda telah berhasil diverifikasi oleh administrator. Anda sekarang dapat mengakses semua fitur yang tersedia di sistem kami.</p>
            
            <p>Jika Anda memiliki pertanyaan atau memerlukan bantuan, jangan ragu untuk menghubungi kami.</p>
            
            <a href="{{ route('login') }}" class="button">Login ke Sistem</a>
        </div>

        <p class="accent-text">Terima kasih telah menggunakan layanan kami.</p>
    </div>

    <div class="footer">
        <p>{{ config('app.name') }}</p>
        <p>© {{ date('Y') }} Powered by PT BIPTEK Tokodata Indonesia</p>
    </div>
</body>
</html>