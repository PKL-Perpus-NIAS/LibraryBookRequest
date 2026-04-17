<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Arial', sans-serif; background-color: #f1f5f9; padding: 20px; }
        .card { background-color: white; padding: 30px; border-radius: 8px; border-top: 4px solid #003566; max-width: 500px; margin: 0 auto; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .title { color: #003566; font-size: 20px; font-weight: bold; margin-bottom: 15px; }
        .text { color: #334155; line-height: 1.6; }
        .book-title { font-weight: bold; color: #facc15; background: #003566; padding: 5px 10px; border-radius: 4px; display: inline-block; margin: 10px 0; }
        .footer { margin-top: 30px; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="card">
        <div class="title">Halo, {{ $bookRequest->requester_name }}! 🎉</div>
        <div class="text">
            Kabar gembira! Usulan buku yang kamu ajukan ke Perpustakaan UNAIR sekarang <b>sudah tersedia</b> dan siap untuk dipinjam/dibaca.
            <br>
            <div class="book-title">{{ $bookRequest->book_title }}</div>
            <br>
            Silakan kunjungi perpustakaan untuk mengecek koleksi tersebut. Terima kasih atas partisipasimu dalam memperkaya koleksi perpustakaan kita!
        </div>
        <div class="footer">
            Pesan ini dikirim otomatis oleh Sistem Pembinaan Koleksi (Binkol) Perpustakaan.
        </div>
    </div>
</body>
</html>