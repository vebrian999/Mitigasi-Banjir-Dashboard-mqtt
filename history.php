<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History</title>
    <link rel="stylesheet" href="https://cdn.tailwindcss.com">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .scroll-container {
            max-height: 70vh; /* Sesuaikan tinggi maksimal sesuai kebutuhan */
            overflow-y: auto;
            width: 100%;
        }

        table.mx-auto {
            margin-left: auto;
            margin-right: auto;
        }
        
    </style>
</head>
<body class="min-h-screen">
    <div class="bg-green-600 py-4 flex justify-between px-6 text-white">
        <h1 class="font-semibold text-2xl">FDD FLOOD MONITORING</h1>
        <div class="flex justify-normal gap-3">
            <p class="font-semibold text-2xl" id="today">Today :</p>
            <h1 class="font-semibold text-2xl" id="clock"></h1>
        </div>
    </div>

    <div class="flex flex-col-1 gap-4">
        <div class="flex flex-col bg-gray-200 h-screen w-1/6  ">
            <ul class="text-sm font-medium mt-8 mr-4 ml-4">
                <a href="dashboard.php" class="flex gap-x-2 py-3 hover:bg-gray-400  ">
                    <li class="flex items-center">
                        <img class="w-5" src="./asset/graph.svg" alt="">
                    </li>
                    <li>
                        MONITORING BANJIR
                    </li>
                </a>
                <a href="history.php" class="flex gap-x-2 py-3 hover:bg-gray-400">
                    <li>
                        <img class="w-5" src="./asset/time.svg" alt="">
                    </li>
                    <li>
                        HISTORY
                    </li>
                </a>
            </ul>
        </div>

        <div class="flex mt-5 w-1/8 font-semibold text-3xl gap-x-2">
            <div class=" ">
                <img class="w-10" src="./asset/time.svg" alt="">
            </div>
            <div>
                <h1>History</h1>
            </div>
        </div>

        <div class="mt-20 w-1/2">
            <div class="text-center scroll-container">
            <?php
                $mysqlHost = "localhost";
                $mysqlUser = "root";
                $mysqlPassword = "";
                $mysqlDatabase = "banjir";

                $conn = new mysqli($mysqlHost, $mysqlUser, $mysqlPassword, $mysqlDatabase);

                if ($conn->connect_error) {
                    die("Koneksi gagal: " . $conn->connect_error);
                }

                $conn->select_db($mysqlDatabase);

                $sql = "SELECT * FROM databanjir1";
                $result = $conn->query($sql);

                if ($result !== false) {
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Mengambil nilai waktu dari kolom waktu
                            $waktu_terkirim = $row["waktu"];

                            // Format waktu dapat disesuaikan
                            $formatted_waktu = date("Y-m-d H:i:s", strtotime($waktu_terkirim));

                            echo "<div  class= ' flex w-full rounded-lg bg-red-50 m-4 p-4 '>
                                    <div>
                                        <div class='ml-2 border rounded-lg px-2 border-red-500 bg-red-100'>
                                            Waktu : " . $formatted_waktu . "
                                        </div>
                                        <div class='-ml-8'>
                                            Ketinggian Air: " . $row["jarak_air_cm"] . "
                                        </div>
                                        <div class='-ml-7'>
                                            Status : " . $row["status"] . "
                                        </div>
                                    </div>
                                </div>";
                        }
                    } else {
                        echo "Tidak ada data yang ditemukan.";
                    }

                    $result->free_result();
                } else {
                    echo "Error in query: " . $conn->error;
                }

                $conn->close();
                ?>
            </div>
        </div>
    </div>
</body>

    <script>
        function updateClock() {
            var now = new Date();
            var daysOfWeek = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            var dayOfWeek = daysOfWeek[now.getDay()];
            var month = months[now.getMonth()];
            var date = now.getDate();
            var hours = now.getHours();
            var minutes = now.getMinutes();
            var seconds = now.getSeconds();

            hours = (hours < 10) ? "0" + hours : hours;
            minutes = (minutes < 10) ? "0" + minutes : minutes;
            seconds = (seconds < 10) ? "0" + seconds : seconds;

            // Mengupdate elemen dengan ID "clock" dengan waktu yang baru
            document.getElementById("clock").innerHTML = dayOfWeek + ', ' + date + ' ' + month + ' ' + hours + ':' + minutes + ':' + seconds;

            // Menjadwalkan pemanggilan fungsi ini setiap detik
            setTimeout(updateClock, 1000);
        }

        // Memanggil fungsi updateClock untuk pertama kalinya
        updateClock();
    </script>
</html>
