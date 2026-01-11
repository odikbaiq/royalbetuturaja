<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: sans-serif; line-height: 1.6;">
    <h2>Halo, {{ $contact->nama }}</h2>
    <p>Terima kasih telah menghubungi **Royal Betutu Raja**. Kami telah membaca pesan Anda mengenai "{{ $contact->subject }}".</p>

    <p><strong>Balasan kami:</strong></p>
    <div style="background: #f4f4f4; padding: 20px; border-left: 4px solid #007bff; margin: 15px 0;">
        {!! nl2br(e($replyContent)) !!}
    </div>

    <p>Jika ada pertanyaan lebih lanjut, silakan hubungi kami kembali.</p>
    <br>
    <p>Salam hangat,<br><strong>Tim Royal Betutu Raja</strong></p>
</body>
</html>
