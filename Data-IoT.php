<?php
$channel_id = "2749400"; 
$read_api_key = "5V3J4I0L6AY0DMX0"; 

$url = "https://api.thingspeak.com/channels/$channel_id/feeds.json?api_key=$read_api_key";
$response = file_get_contents($url);
$data = json_decode($response, true);

if (isset($data['feeds'])) {
    $all_feeds = $data['feeds'];
    $date_filter = '2024-11-24'; // Hanya menampilkan data simulasi di tanggal 24 November 2024 untuk laporan
    $feeds = array_filter($all_feeds, function ($feed) use ($date_filter) {
        $datetime = new DateTime($feed['created_at']);
        return $datetime->format('Y-m-d') === $date_filter;
    });
} else {
    echo "Data tidak tersedia.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data ThingSpeak</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: small;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Data dari ThingSpeak</h1>
    <?php if (!empty($feeds)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Waktu</th>
                    <th>Field 1<br>
                        Sensor Cahaya (Smart Lamp)
                    </th>
                    <th>Field 2 <br>
                        Sensor Gerak (Smart Lamp)
                    </th>
                    <th>Field 3 <br>
                        Sensor Suhu (Smart Watering Plant)
                    </th>
                    <th>Field 4 <br>
                        Sensor Kelembapan (Smart Watering Plant)
                    </th>
                    <th>Field 5 <br>
                        Sensor Suhu (Smart AC)
                    </th>
                    <th>Field 6 <br>
                        Sensor Gerak (Smart AC)
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($feeds as $feed): ?>
                    <tr>
                        <td><?php echo $feed['entry_id']; ?></td>
                        <td>
                            <?php 
                                $datetime = new DateTime($feed['created_at']);
                                echo $datetime->format('y-m-d, H:i:s');
                            ?>
                        </td>
                        <td><?php echo $feed['field1'] ?? ''; ?></td>
                        <td><?php echo $feed['field2'] ?? ''; ?></td>
                        <td><?php echo $feed['field3'] ?? ''; ?></td>
                        <td><?php echo $feed['field4'] ?? ''; ?></td>
                        <td><?php echo $feed['field5'] ?? ''; ?></td>
                        <td><?php echo $feed['field6'] ?? ''; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tidak ada data untuk tanggal <?php echo $date_filter; ?>.</p>
    <?php endif; ?>
</body>
</html>
