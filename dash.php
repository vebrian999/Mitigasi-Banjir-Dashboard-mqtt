<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Banjir</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>

    <h2>Data Banjir</h2>

    <table id="banjirTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Waktu</th>
                <th>Jarak Air (cm)</th>
                <th>status</th>
                <!-- Tambahkan kolom lain sesuai dengan struktur tabel -->
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <script>
        // Membuat fungsi untuk mengambil data dari server dan mengisi tabel
        async function fetchDataAndPopulateTable() {
            try {
                const response = await fetch('getData.php');
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const data = await response.json();

                // Mendapatkan referensi tabel
                const tableBody = document.querySelector('#banjirTable tbody');

                // Mengosongkan isi tabel sebelum mengisi data baru
                tableBody.innerHTML = '';

                // Menambahkan data ke dalam tabel
                data.forEach(row => {
                    const tableRow = document.createElement('tr');
                    tableRow.innerHTML = `
                        <td>${row.id}</td>
                        <td>${row.waktu}</td>
                        <td>${row.jarak_air_cm}</td>
                        <td>${row.status}</td>
                        <!-- Tambahkan kolom lain sesuai dengan struktur tabel -->
                    `;
                    tableBody.appendChild(tableRow);
                });
            } catch (error) {
                console.error('Error fetching or parsing data:', error);
            }
        }

        // Memanggil fungsi fetchDataAndPopulateTable untuk pertama kalinya
        fetchDataAndPopulateTable();

        // Skrip JavaScript untuk melakukan refresh setiap 15 detik
        setInterval(fetchDataAndPopulateTable, 15000);
    </script>

</body>
</html>
