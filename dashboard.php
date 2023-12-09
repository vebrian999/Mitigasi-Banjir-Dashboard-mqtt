<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <!-- <script src="chart.js/Chart.js"></script> -->
</head>

<body>
    <div class="bg-green-600 py-4 flex justify-between px-6 text-white">
        <div class="flex gap-x-4">
        <img class="w-16" src="asset/logoFFD.png" alt="">
        <h1 class="font-semibold text-2xl">FDD FLOOD MONITORING</h1>
        </div>
        <div class="flex justify-normal gap-3">
            <p class="font-semibold text-2xl" id="today">Today :</p>
            <h1 class="font-semibold text-2xl" id="clock"></h1>
        </div>
    </div>

    <div class="flex flex-col-2 gap-4">
        <div class="flex flex-col bg-gray-200 h-screen w-1/5 z-40">
        <!-- <div>
            <img class="" src="./asset/LOGO.png" alt="">
        </div> -->
            <ul class="text-sm font-medium mt-8 mr-4 ml-4">
                <a href="dashboard.php" class="flex gap-x-2 py-3 hover:bg-gray-400 ">
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

        <div class="flex w-full justify-between mt-5">
            <div class="w-1/4 font-semibold text-3xl flex gap-x-3">
                
                <div class="pt-2">
                    <img class="w-10" src="./asset/graph.svg" alt="">
                </div>
                <div>
                <h1>Dashboard</h1>
                </div>
            </div>
<!-- <div class="flex flex-">
    <div class="px-2 py-2 bg-green-300">
    </div>
    <div class="px-2 py-2 bg-red-300">
    </div>
</div> -->
            <div class="pr-8 mt-40 absolute bg-gray-400">
                <div class="flex ml-10 mt-4 gap-2">
                    <img src="./asset/graph.svg" alt="">
                    <h1 class="text-white font-semibold text-lg">Grafik Monitoring Banjir</h1>
                </div>
                <div class="m-4 w-full justify-start">
                    <canvas class="mx-auto bg-white " id="barChart" width="1175" height="400"></canvas>
                </div>
            </div>

            <div class="flex flex-col w-1/4 gap-y-3">
                <div class="flex">
                    <h1 class="flex items-center px-1 font-semibold">Status Saat ini :</h1>
                    <?php
                    // Parameter koneksi database
                    $host = 'localhost';
                    $username = 'root';
                    $password = '';
                    $database = 'banjir';

                    // Membuat koneksi ke database
                    $conn = new mysqli($host, $username, $password, $database);

                    // Memeriksa koneksi
                    if ($conn->connect_error) {
                        die("Koneksi gagal: " . $conn->connect_error);
                    }

                    // Memilih database
                    $conn->select_db($database);

                    $sql = "SELECT * FROM databanjir";
                    $result = $conn->query($sql);

                    if ($result !== false) {
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $status = $row["status"];
                            $jarakAirCm = $row["jarak_air_cm"];

                            // Memeriksa status untuk menentukan warna latar
                            if ($status === "Jarak Air Aman") {
                                $bgColor = "bg-green-500";
                            } elseif ($status === "Jarak Air Bahaya") {
                                $bgColor = "bg-red-600";
                            } else {
                                $bgColor = "bg-gray-500"; // Ganti dengan warna default jika status tidak dikenali
                            }

                            echo "<h1 class='$bgColor py-2 w-32 text-center text-white'>$status</h1>";
                        } else {
                            echo "<h1 class='bg-red-600 py-2 w-32 text-center text-white'>N/A</h1>";
                        }

                        // Menutup koneksi
                        $conn->close();
                    } else {
                        echo "Error in query: " . $conn->error;
                    }
                    ?>
                </div>
                <div class="flex">
                    <h1 class="flex items-center px-1 -ml-4 font-semibold ">Jarak Air Saat ini :</h1>
                    <?php
                    // Parameter koneksi database
                    $host = 'localhost';
                    $username = 'root';
                    $password = '';
                    $database = 'banjir';

                    // Membuat koneksi ke database
                    $conn = new mysqli($host, $username, $password, $database);

                    // Memeriksa koneksi
                    if ($conn->connect_error) {
                        die("Koneksi gagal: " . $conn->connect_error);
                    }

                    // Memilih database
                    $conn->select_db($database);

                    $sql = "SELECT * FROM databanjir";
                    $result = $conn->query($sql);

                    if ($result !== false) {
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $jarakAirCm = $row["jarak_air_cm"];
                            
                            // Memeriksa tinggi air untuk menentukan warna latar
                            if ($jarakAirCm < 150) {
                                $bgColor = "bg-red-600";
                            } else {
                                $bgColor = "bg-green-500";
                            }

                            echo "<h1 class='$bgColor py-2 w-32 text-center -ml-0.5 text-white'>$jarakAirCm</h1>";
                        } else {
                            echo "<h1 class='bg-red-600 py-2 w-32 text-center text-white'>N/A</h1>";
                        }

                        // Menutup koneksi
                        $conn->close();
                    } else {
                        echo "Error in query: " . $conn->error;
                    }
                    ?>
                </div>
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

<!-- Bagian JavaScript di HTML -->
<!-- Bagian JavaScript di HTML -->
<script>
var lineChart;

async function drawChart() {
    try {
        const response = await fetch('getData.php');
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();

        const legend = data.map(entry => entry.status);
        const labels = data.map(entry => entry.waktu);
        const values = data.map(entry => entry.jarak_air_cm);

        var ctx = document.getElementById('barChart').getContext('2d');

        // Mengatur warna berdasarkan nilai jarak_air_cm
        var backgroundColors = values.map(value => value < 100 ? 'rgba(255, 0, 0, 0.2)' : 'rgba(0, 255, 0, 0.2)');
        var borderColors = values.map(value => value < 100 ? 'rgba(255, 0, 0, 1)' : 'rgba(0, 255, 0, 1)');

        // Hapus chart yang sudah ada jika ada
        if (lineChart) {
            lineChart.destroy();
        }

        lineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jarak Air (cm)',
                    data: values,
                    backgroundColor: backgroundColors,
                    borderColor: borderColors,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    },
                    x: {
                        display: false // Menyembunyikan sumbu x (labels) waktu
                    }
                },
                plugins: {
                    zoom: {
                        pan: {
                            enabled: true,
                            mode: 'x'
                        },
                        zoom: {
                            wheel: {
                                enabled: true,
                            },
                            pinch: {
                                enabled: true
                            }
                        }
                    },
                    legend: {
                        display: true// Menyembunyikan legend
                    }
                }
            }
        });
    } catch (error) {
        console.error('Error fetching or parsing data:', error);
    }
}

drawChart();

setInterval(drawChart, 15000);

</script>



    <script>
        // Skrip JavaScript untuk melakukan refresh setiap 7 detik
        setInterval(function(){
            location.reload();
        }, 15000);
    </script>

</html>