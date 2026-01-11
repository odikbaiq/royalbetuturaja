# TODO: Perbaikan Alur Reservasi dan Integrasi Midtrans

## 1. PaymentController.php - Perbaikan Utama
- [x] Tambahkan verifikasi signature key Midtrans di callback method
- [x] Sesuaikan status flow: pending -> approved -> waiting_payment -> completed
- [x] Perbaiki logika update status di callback
- [x] Tambahkan try-catch yang lebih komprehensif

## 2. ReservationController.php - Download Tiket
- [x] Pastikan downloadTicket method sudah benar (sudah ada)

## 3. Routes/web.php - Routing
- [x] Pastikan semua route payment sudah benar (sudah ada)

## 4. bootstrap/app.php - CSRF Exemption
- [x] Pastikan CSRF exemption untuk /midtrans/callback sudah benar (sudah ada)

## 5. View Blade - Contoh Tombol Bayar
- [x] Buat contoh kode view untuk tombol "Bayar Sekarang" dengan Midtrans Snap JS

## 6. Testing
- [ ] Test alur lengkap dari reservasi hingga download tiket
