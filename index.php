<?php
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://private-anon-93435963dd-visagium.apiary-mock.com/Attendance',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);
curl_close($curl);

$data = json_decode($response, true);

if (!is_array($data) || !isset($data['attendaces'])) {
    echo "<p style='color: red;'>Data attendaces tidak ditemukan!</p>";
    exit;
}

$attendances = $data['attendaces']; // Ambil semua data absensi
?>

<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sistem Absensi dengan Face Recognition</title>
        
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/fontawesome/css/all.min.css" rel="stylesheet">
        <link href="assets/css/index.css" rel="stylesheet">
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
    </head>

    <body>

        <nav class="navbar">
            <div class="container">
                <h2><img src="assets/img/logo-bpkp.png" alt="" height="30"><b> SISTEM ABSENSI DENGAN FACE RECOGNITION</b></h2>
            </div>
        </nav>
        
        <div class="layout">
            <h3><b>Rekap Presensi Harian</b></h3>
            
            <form method="POST" action="">
                <!-- <a href="export_excel.php<?php echo isset($_POST['tanggal']) ? '?tanggal=' . $_POST['tanggal'] : ''; ?>" class="btn">
                    <i class="fas fa-download"></i> Export Excel
                </a> -->
                <input type="date" name="tanggal" value="<?php echo isset($_POST['tanggal']) ? $_POST['tanggal'] : ''; ?>">
                <button class="btn" type="submit">Tampilkan</button>
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['tanggal'])) {
                $tanggalDipilih = date("Y-m-d", strtotime($_POST['tanggal']));

                // Filter data berdasarkan tanggal yang dipilih
                $filteredAttendances = array_filter($attendances, function($attendance) use ($tanggalDipilih) {
                    return strpos($attendance['clock_in_time'], $tanggalDipilih) === 0;
                });

                if (empty($filteredAttendances)) {
                    echo "<p style='color: red;'>Data untuk tanggal " . htmlspecialchars($tanggalDipilih) . " tidak ditemukan.</p>";
                } else {
                    tampilkanTabel($filteredAttendances);
                }
            } else {
                // Jika tidak memilih tanggal, tampilkan semua data
                tampilkanTabel($attendances);
            }

            // Fungsi untuk menampilkan tabel
            function tampilkanTabel($data) {
                echo "<table class='table table-bordered'>";
                echo "<tr>
                        <th scope='col'><center>No.</center></th>
                        <th scope='col'><center>NIP</center></th>
                        <th scope='col'><center>Nama Pegawai</center></th>
                        <th scope='col'><center>Tanggal</center></th>
                        <th scope='col'><center>Jam Masuk</center></th>
                        <th scope='col'><center>Jam Keluar</center></th>
                    </tr>";

                $no = 1;
                foreach ($data as $attendance) {
                    echo "<tr>";
                    echo "<td><center>" . $no++ . "</center></td>";
                    echo "<td><center>" . sprintf("%.0f", $attendance['employe_id']) . "</center></td>";
                    echo "<td><center>" . htmlspecialchars($attendance['name']) . "</center></td>";
                    echo "<td><center>" . date("d-m-Y", strtotime($attendance['clock_in_time'])) . "</center></td>";
                    echo "<td><center>" . date("H:i:s", strtotime($attendance['clock_in_time'])) . "</center></td>";
                    echo "<td><center>" . ($attendance['clock_out_time'] ? date("H:i:s", strtotime($attendance['clock_out_time'])) : "Belum Absen") . "</center></td>";
                    echo "</tr>";
                }

                echo "</table>";
            }
            ?>
        </div>

    </body>
</html>