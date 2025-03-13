# Sistem Absensi

Sistem Absensi adalah aplikasi berbasis web yang digunakan untuk mencatat kehadiran karyawan dengan fitur pencatatan waktu masuk dan keluar secara real-time.

## Fitur Utama
- **Manajemen Pengguna**: Tambah, edit, dan hapus data karyawan.
- **Pencatatan Kehadiran**: Karyawan dapat melakukan clock-in dan clock-out.
- **Riwayat Kehadiran**: Melihat daftar kehadiran berdasarkan tanggal.
- **Terintegrasi dengan API**: Menggunakan API eksternal untuk mengelola data absensi.

## Teknologi yang Digunakan
- **Backend**: PHP
- **Database**: API eksternal (tidak menggunakan MySQL secara langsung)
- **Frontend**: HTML, CSS, JavaScript (jQuery, Bootstrap)
- **API**: REST API untuk komunikasi data absensi

## Instalasi
1. **Clone repository**
   ```sh
   git clone https://github.com/fitraadm/sistem_absensi.git
   cd sistem_absensi
   ```

2. **Konfigurasi API**
   - Buka file `index.php`
   - Sesuaikan konfigurasi API endpoint pada bagian yang berkaitan dengan absensi:
     ```php
     CURLOPT_URL => 'https://private-anon-93435963dd-visagium.apiary-mock.com/Attendance',
     ```

3. **Menjalankan Server**
   - Jalankan server lokal menggunakan XAMPP atau server PHP bawaan:
     ```sh
     php -S localhost:8000
     ```
   - Buka browser dan akses `http://localhost:8000`

## Cara Penggunaan
1. **Karyawan melakukan clock-in dan clock-out melalui sistem**
2. **Jalankan `index.php`**
3. **Admin dapat mengelola data karyawan dan melihat riwayat kehadiran melalui API**

## Kontribusi
Jika ingin berkontribusi, silakan fork repository ini dan buat pull request dengan perubahan yang diinginkan.

## Lisensi
Proyek ini menggunakan lisensi MIT. Silakan gunakan dan modifikasi sesuai kebutuhan.

