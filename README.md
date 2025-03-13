# Sistem Absensi

Sistem Absensi adalah aplikasi berbasis web yang digunakan untuk mencatat kehadiran karyawan dengan fitur pencatatan waktu masuk dan keluar secara real-time.

## Fitur Utama
- **Manajemen Pengguna**: Tambah, edit, dan hapus data karyawan.
- **Pencatatan Kehadiran**: Karyawan dapat melakukan clock-in dan clock-out.
- **Riwayat Kehadiran**: Melihat daftar kehadiran berdasarkan tanggal.

## Teknologi yang Digunakan
- **Backend**: PHP dengan framework CodeIgniter
- **Database**: MySQL
- **Frontend**: HTML, CSS, JavaScript (jQuery, Bootstrap)
- **API**: REST API untuk komunikasi data absensi

## Instalasi
1. **Clone repository**
   ```sh
   git clone https://github.com/fitraadm/sistem_absensi.git
   cd sistem_absensi
   ```

2. **Konfigurasi Database**
   - Buat database MySQL dengan nama `sistem_absensi`.
   - Import file `database.sql` yang ada di dalam folder `database`.
   - Sesuaikan konfigurasi database di `application/config/database.php`.

3. **Menjalankan Server**
   - Jalankan server lokal menggunakan XAMPP atau server PHP bawaan:
     ```sh
     php -S localhost:8000
     ```
   - Buka browser dan akses `http://localhost:8000`

## Cara Penggunaan
1. **Login sebagai admin atau karyawan**
2. **Karyawan dapat melakukan clock-in dan clock-out**
3. **Admin dapat mengelola data karyawan dan melihat riwayat kehadiran**

## Kontribusi
Jika ingin berkontribusi, silakan fork repository ini dan buat pull request dengan perubahan yang diinginkan.

## Lisensi
Proyek ini menggunakan lisensi MIT. Silakan gunakan dan modifikasi sesuai kebutuhan.
