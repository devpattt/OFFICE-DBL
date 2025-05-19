<?php
include '../conn.php';  

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all attendance logs with valid coordinates
$sql = "SELECT * FROM dbl_attendance_logs 
        WHERE lat_in IS NOT NULL AND lng_in IS NOT NULL 
        ORDER BY date DESC, time_in_raw DESC";
$result = $conn->query($sql);

$rows = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
}

// Get current active employees (latest check-ins without check-outs)
$activeEmployeesQuery = "SELECT al.*, 
                               CASE 
                                   WHEN al.time_out IS NULL OR al.time_out = '' THEN 'active'
                                   ELSE 'inactive'
                               END as current_status
                        FROM dbl_attendance_logs al
                        INNER JOIN (
                            SELECT employee_id, MAX(date) as max_date, MAX(time_in_raw) as max_time
                            FROM dbl_attendance_logs 
                            WHERE lat_in IS NOT NULL AND lng_in IS NOT NULL
                            GROUP BY employee_id
                        ) latest ON al.employee_id = latest.employee_id 
                                 AND al.date = latest.max_date 
                                 AND al.time_in_raw = latest.max_time
                        ORDER BY al.time_in_raw DESC";

$activeResult = $conn->query($activeEmployeesQuery);
$activeEmployees = [];
if ($activeResult && $activeResult->num_rows > 0) {
    while ($row = $activeResult->fetch_assoc()) {
        $activeEmployees[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/main.css">
    <link rel="stylesheet" href="../public/css/darkmode.css">
    <link rel="icon" href="../public/img/DBL.png">
    <link rel="stylesheet" href="../public/css/itinerary.css">
    <link rel="stylesheet" href="../public/css/map.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <script type="text/javascript" src="../public/js/darkmode.js" defer></script>
    <title>DBL ISTS - Employee Location Map</title>
    <style>
        .map-container {
            margin: 20px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }
        .map-header {
            background: #f8f9fa;
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }
        .employee-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: bold;
        }
        .status-active {
            background: #d4edda;
            color: #155724;
        }
        .status-inactive {
            background: #f8d7da;
            color: #721c24;
        }
        .controls {
            margin: 20px 0;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        .btn-primary {
            background: #007bff;
            color: white;
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .filter-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        #main-map {
            height: 500px;
            width: 100%;
            border-radius: 8px;
        }
        .legend {
            background: white;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            margin: 10px 0;
        }
        .legend-item {
            display: flex;
            align-items: center;
            margin: 5px 0;
        }
        .legend-color {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <!-- Your existing sidebar navigation here -->
 <nav id="sidebar">
    <ul>
      <li>
        <span class="logo">DBL ISTS</span>
        <button onclick=toggleSidebar() id="toggle-btn">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg>
        </button>
      <li>
        <li>
          <a href="home.php">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M520-640v-160q0-17 11.5-28.5T560-840h240q17 0 28.5 11.5T840-800v160q0 17-11.5 28.5T800-600H560q-17 0-28.5-11.5T520-640ZM120-480v-320q0-17 11.5-28.5T160-840h240q17 0 28.5 11.5T440-800v320q0 17-11.5 28.5T400-440H160q-17 0-28.5-11.5T120-480Zm400 320v-320q0-17 11.5-28.5T560-520h240q17 0 28.5 11.5T840-480v320q0 17-11.5 28.5T800-120H560q-17 0-28.5-11.5T520-160Zm-400 0v-160q0-17 11.5-28.5T160-360h240q17 0 28.5 11.5T440-320v160q0 17-11.5 28.5T400-120H160q-17 0-28.5-11.5T120-160Zm80-360h160v-240H200v240Zm400 320h160v-240H600v240Zm0-480h160v-80H600v80ZM200-200h160v-80H200v80Zm160-320Zm240-160Zm0 240ZM360-280Z"/></svg>
            <span>Dashboard</span>
          </a>
      </li>
    </li>
    <li>
    <a href="itinerary.php">
      <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M280-280h160v-160H280v160Zm240 0h160v-160H520v160ZM280-520h160v-160H280v160Zm240 0h160v-160H520v160ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z"/></svg>
      <span>Itinerary</span>
      </a>
      </li>
      <li>
        <a href="employees.php">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="M0-240v-63q0-43 44-70t116-27q13 0 25 .5t23 2.5q-14 21-21 44t-7 48v65H0Zm240 0v-65q0-32 17.5-58.5T307-410q32-20 76.5-30t96.5-10q53 0 97.5 10t76.5 30q32 20 49 46.5t17 58.5v65H240Zm540 0v-65q0-26-6.5-49T754-397q11-2 22.5-2.5t23.5-.5q72 0 116 26.5t44 70.5v63H780Zm-455-80h311q-10-20-55.5-35T480-370q-55 0-100.5 15T325-320ZM160-440q-33 0-56.5-23.5T80-520q0-34 23.5-57t56.5-23q34 0 57 23t23 57q0 33-23 56.5T160-440Zm640 0q-33 0-56.5-23.5T720-520q0-34 23.5-57t56.5-23q34 0 57 23t23 57q0 33-23 56.5T800-440Zm-320-40q-50 0-85-35t-35-85q0-51 35-85.5t85-34.5q51 0 85.5 34.5T600-600q0 50-34.5 85T480-480Zm0-80q17 0 28.5-11.5T520-600q0-17-11.5-28.5T480-640q-17 0-28.5 11.5T440-600q0 17 11.5 28.5T480-560Zm1 240Zm-1-280Z"/></svg>
          <span>Active Users</span>
        </a>
      </li>
      <li>
      <li>
        <a href="employee_logs.php">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-40q0-17 11.5-28.5T280-880q17 0 28.5 11.5T320-840v40h320v-40q0-17 11.5-28.5T680-880q17 0 28.5 11.5T720-840v40h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Zm0-480h560v-80H200v80Zm0 0v-80 80Zm280 240q-17 0-28.5-11.5T440-440q0-17 11.5-28.5T480-480q17 0 28.5 11.5T520-440q0 17-11.5 28.5T480-400Zm-160 0q-17 0-28.5-11.5T280-440q0-17 11.5-28.5T320-480q17 0 28.5 11.5T360-440q0 17-11.5 28.5T320-400Zm320 0q-17 0-28.5-11.5T600-440q0-17 11.5-28.5T640-480q17 0 28.5 11.5T680-440q0 17-11.5 28.5T640-400ZM480-240q-17 0-28.5-11.5T440-280q0-17 11.5-28.5T480-320q17 0 28.5 11.5T520-280q0 17-11.5 28.5T480-240Zm-160 0q-17 0-28.5-11.5T280-280q0-17 11.5-28.5T320-320q17 0 28.5 11.5T360-280q0 17-11.5 28.5T320-240Zm320 0q-17 0-28.5-11.5T600-280q0-17 11.5-28.5T640-320q17 0 28.5 11.5T680-280q0 17-11.5 28.5T640-240Z"/></svg>
          <span>Logs</span>
        </a>
      </li>
      <li>
        <a href="report.php">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="M320-480v-80h320v80H320Zm0-160v-80h320v80H320Zm-80 240h300q29 0 54 12.5t42 35.5l84 110v-558H240v400Zm0 240h442L573-303q-6-8-14.5-12.5T540-320H240v160Zm480 80H240q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h480q33 0 56.5 23.5T800-800v640q0 33-23.5 56.5T720-80Zm-480-80v-640 640Zm0-160v-80 80Z"/></svg>
          <span>Reports</span>
        </a>
      </li>
      <li  class="active">
        <a href="map.php">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="M480-480q33 0 56.5-23.5T560-560q0-33-23.5-56.5T480-640q-33 0-56.5 23.5T400-560q0 33 23.5 56.5T480-480Zm0 294q122-112 181-203.5T720-552q0-109-69.5-178.5T480-800q-101 0-170.5 69.5T240-552q0 71 59 162.5T480-186Zm0 106Q319-217 239.5-334.5T160-552q0-150 96.5-239T480-880q127 0 223.5 89T800-552q0 100-79.5 217.5T480-80Zm0-480Z"/></svg>
          <span>Map</span>
        </a>
      </li>
      <li>
          <a href="leavemanagement.php">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="M440-280h320v-22q0-45-44-71.5T600-400q-72 0-116 26.5T440-302v22Zm160-160q33 0 56.5-23.5T680-520q0-33-23.5-56.5T600-600q-33 0-56.5 23.5T520-520q0 33 23.5 56.5T600-440ZM160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h240l80 80h320q33 0 56.5 23.5T880-640v400q0 33-23.5 56.5T800-160H160Zm0-80h640v-400H447l-80-80H160v480Zm0 0v-480 480Z"/></svg>
                <span>Leave Management</span>
              </a>
        </li>
      <li>
        <a href="../logout.php">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="M440-440q17 0 28.5-11.5T480-480q0-17-11.5-28.5T440-520q-17 0-28.5 11.5T400-480q0 17 11.5 28.5T440-440ZM280-120v-80l240-40v-445q0-15-9-27t-23-14l-208-34v-80l220 36q44 8 72 41t28 77v512l-320 54Zm-160 0v-80h80v-560q0-34 23.5-57t56.5-23h400q34 0 57 23t23 57v560h80v80H120Zm160-80h400v-560H280v560Z"/></svg>
          <span>Sign Out</span>
        </a>
      </li>
      <li>
        <button id="theme-switch" class="darkmode-btn">
          <span class="icon sun">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M480-120q-150 0-255-105T120-480q0-150 105-255t255-105q14 0 27.5 1t26.5 3q-41 29-65.5 75.5T444-660q0 90 63 153t153 63q55 0 101-24.5t75-65.5q2 13 3 26.5t1 27.5q0 150-105 255T480-120Z"/></svg>
              <path fill="currentColor" d="M12 4.5A1.5 1.5 0 1 1 12 1.5a1.5 1.5 0 0 1 0 3Zm0 18a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Zm7.5-9a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0ZM6 12a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm12.02-5.52a1.5 1.5 0 1 1-2.12-2.12 1.5 1.5 0 0 1 2.12 2.12ZM6.1 17.9a1.5 1.5 0 1 1-2.12-2.12 1.5 1.5 0 0 1 2.12 2.12Zm0-11.8A1.5 1.5 0 1 1 3.98 3.98 1.5 1.5 0 0 1 6.1 6.1Zm11.8 11.8a1.5 1.5 0 1 1-2.12-2.12 1.5 1.5 0 0 1 2.12 2.12ZM12 8a4 4 0 1 1 0 8 4 4 0 0 1 0-8Z" />
            </svg>
          </span>
          <span class="icon moon">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M480-280q-83 0-141.5-58.5T280-480q0-83 58.5-141.5T480-680q83 0 141.5 58.5T680-480q0 83-58.5 141.5T480-280ZM200-440H40v-80h160v80Zm720 0H760v-80h160v80ZM440-760v-160h80v160h-80Zm0 720v-160h80v160h-80ZM256-650l-101-97 57-59 96 100-52 56Zm492 496-97-101 53-55 101 97-57 59Zm-98-550 97-101 59 57-100 96-56-52ZM154-212l101-97 55 53-97 101-59-57Z"/></svg>
              <path fill="currentColor" d="M21 12.79A9 9 0 0 1 11.21 3a7 7 0 1 0 9.79 9.79Z"/>
            </svg>
          </span>
          <span class="label">Dark Mode</span>
        </button>
      </li>  
    </ul>
  </nav>

    <main>
        <!-- Main map showing all locations -->
        <div class="map-container">
            <div class="map-header">
                <h3>All Employee Locations</h3>
            </div>
            <div id="main-map"></div>
        </div>

        <!-- Current Active Employees -->
        <h2>Current Active Employees</h2>
        <?php if (empty($activeEmployees)): ?>
            <p>No active employees currently checked in.</p>
        <?php else: ?>
            <?php foreach ($activeEmployees as $employee): ?>
                <div class="map-container">
                    <div class="map-header">
                        <div class="employee-info">
                            <div>
                                <strong><?= htmlspecialchars($employee['username']) ?></strong>
                                (ID: <?= htmlspecialchars($employee['employee_id']) ?>)
                                <br>
                                <small>
                                    Date: <?= htmlspecialchars($employee['date']) ?> | 
                                    Check-in: <?= htmlspecialchars($employee['time_in']) ?>
                                    <?php if ($employee['time_out']): ?>
                                        | Check-out: <?= htmlspecialchars($employee['time_out']) ?>
                                    <?php endif; ?>
                                </small>
                            </div>
                            <span class="status-badge <?= $employee['current_status'] === 'active' ? 'status-active' : 'status-inactive' ?>">
                                <?= ucfirst($employee['current_status']) ?>
                            </span>
                        </div>
                    </div>
                    <div id="map_<?= $employee['id'] ?>" style="height: 350px;"></div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- Historical Data -->
        <h2>Recent Check-ins/Check-outs</h2>
        <?php foreach (array_slice($rows, 0, 10) as $row): ?>
            <div class="map-container">
                <div class="map-header">
                    <div class="employee-info">
                        <div>
                            <strong><?= htmlspecialchars($row['username']) ?></strong>
                            (ID: <?= htmlspecialchars($row['employee_id']) ?>)
                            <br>
                            <small>
                                Date: <?= htmlspecialchars($row['date']) ?> | 
                                Status: <?= htmlspecialchars($row['status']) ?>
                                <?php if ($row['hours_worked']): ?>
                                    | Hours: <?= $row['hours_worked'] ?>
                                <?php endif; ?>
                            </small>
                        </div>
                    </div>
                </div>
                <div id="map_historical_<?= $row['id'] ?>" style="height: 300px;"></div>
            </div>
        <?php endforeach; ?>
    </main>

    <!-- Your existing modals and scripts -->
    <div id="logout-warning" style="display:none; position:fixed; bottom:30px; right:30px; background:#fff8db; color:#8a6d3b; border:1px solid #f0c36d; padding:15px 20px; z-index:1000; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.2);">
        <strong>Inactive for too long.</strong><br>
        Logging out in <span id="countdown">10</span> seconds...
    </div>

    <script>
        // Define geofenced locations
        const locations = [
            { id: "DBL ISTS", name: "DBL ISTS", lat: 14.73990, lng: 120.98754, radius: 50 },
            { id: "WL Headquarter", name: "WL Headquarter", lat: 14.737567, lng: 120.99018, radius: 50 },
            { id: "WL Bignay", name: "WL Bignay", lat: 14.747861, lng: 121.00390, radius: 50 },
            { id: "Labella Villa Homes", name: "Labella Villa Homes", lat: 14.74117, lng: 120.98624, radius: 50 },
            { id: "Biglite Makati", name: "Biglite Makati", lat: 14.53984, lng: 121.01433, radius: 50 },
            { id: "Demo Location", name: "Demo Location", lat: 14.73263, lng: 121.00270, radius: 50 },
            { id: "Weshop Taft", name: "Weshop Taft", lat: 14.56245, lng: 120.99612, radius: 50 },
            { id: "Kai Mall", name: "Kai Mall", lat: 14.75670, lng: 121.04391, radius: 50 },
            { id: "Ellec Parada", name: "Ellec Parada", lat: 14.69564, lng: 120.99530, radius: 50 }
        ];

        // Initialize main map
        let mainMap = L.map('main-map').setView([14.73990, 120.98754], 12);
        let geofenceVisible = true;
        let allMarkers = [];

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(mainMap);

        // Add geofences to main map
        function addGeofences() {
            locations.forEach(loc => {
                L.circle([loc.lat, loc.lng], {
                    color: 'blue',
                    fillColor: '#99ccff',
                    fillOpacity: 0.3,
                    radius: loc.radius
                }).addTo(mainMap).bindPopup(`<strong>${loc.name}</strong><br>Radius: ${loc.radius}m`);
            });
        }
        addGeofences();

        // Add all employee locations to main map
        const employeeData = [
            <?php foreach ($rows as $row): ?>
            {
                id: <?= $row['id'] ?>,
                employee_id: '<?= htmlspecialchars($row['employee_id']) ?>',
                username: '<?= htmlspecialchars($row['username']) ?>',
                date: '<?= htmlspecialchars($row['date']) ?>',
                lat_in: <?= $row['lat_in'] ?: 'null' ?>,
                lng_in: <?= $row['lng_in'] ?: 'null' ?>,
                lat_out: <?= $row['lat_out'] ?: 'null' ?>,
                lng_out: <?= $row['lng_out'] ?: 'null' ?>,
                time_in: '<?= htmlspecialchars($row['time_in']) ?>',
                time_out: '<?= htmlspecialchars($row['time_out']) ?>',
                location_in: '<?= htmlspecialchars($row['location_in']) ?>',
                location_out: '<?= htmlspecialchars($row['location_out']) ?>',
                status: '<?= htmlspecialchars($row['status']) ?>'
            },
            <?php endforeach; ?>
        ];

        // Add markers for all employees
        function addEmployeeMarkers() {
            employeeData.forEach(emp => {
                if (emp.lat_in && emp.lng_in) {
                    const checkInMarker = L.marker([emp.lat_in, emp.lng_in], {
                        icon: L.icon({
                            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png',
                            iconSize: [25, 41],
                            iconAnchor: [12, 41],
                            popupAnchor: [1, -34],
                        })
                    }).addTo(mainMap);
                    
                    checkInMarker.bindPopup(`
                        <strong>${emp.username}</strong><br>
                        ID: ${emp.employee_id}<br>
                        Date: ${emp.date}<br>
                        <strong>Check-in:</strong> ${emp.time_in}<br>
                        Location: ${emp.location_in}<br>
                        Status: ${emp.status}
                    `);
                    allMarkers.push(checkInMarker);
                }

                if (emp.lat_out && emp.lng_out) {
                    const checkOutMarker = L.marker([emp.lat_out, emp.lng_out], {
                        icon: L.icon({
                            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
                            iconSize: [25, 41],
                            iconAnchor: [12, 41],
                            popupAnchor: [1, -34],
                        })
                    }).addTo(mainMap);
                    
                    checkOutMarker.bindPopup(`
                        <strong>${emp.username}</strong><br>
                        ID: ${emp.employee_id}<br>
                        Date: ${emp.date}<br>
                        <strong>Check-out:</strong> ${emp.time_out}<br>
                        Location: ${emp.location_out}<br>
                        Status: ${emp.status}
                    `);
                    allMarkers.push(checkOutMarker);

                    // Draw line between check-in and check-out
                    if (emp.lat_in && emp.lng_in) {
                        L.polyline([[emp.lat_in, emp.lng_in], [emp.lat_out, emp.lng_out]], {
                            color: 'purple',
                            weight: 2,
                            opacity: 0.7
                        }).addTo(mainMap);
                    }
                }
            });
        }
        addEmployeeMarkers();

        // Individual maps for active employees
        <?php foreach ($activeEmployees as $employee): ?>
        (function() {
            const mapId = "map_<?= $employee['id'] ?>";
            const lat_in = <?= $employee['lat_in'] ?: 'null' ?>;
            const lng_in = <?= $employee['lng_in'] ?: 'null' ?>;
            const lat_out = <?= $employee['lat_out'] ?: 'null' ?>;
            const lng_out = <?= $employee['lng_out'] ?: 'null' ?>;

            if (!lat_in || !lng_in) return;

            const map = L.map(mapId).setView([lat_in, lng_in], 16);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Add check-in marker
            const checkInMarker = L.marker([lat_in, lng_in], {
                icon: L.icon({
                    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                })
            }).addTo(map);
            
            checkInMarker.bindPopup(`
                <strong>Check-in</strong><br>
                Time: <?= htmlspecialchars($employee['time_in']) ?><br>
                Location: <?= htmlspecialchars($employee['location_in']) ?>
            `).openPopup();

            // Add check-out marker if exists
            if (lat_out && lng_out) {
                const checkOutMarker = L.marker([lat_out, lng_out], {
                    icon: L.icon({
                        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
                        iconSize: [25, 41],
                        iconAnchor: [12, 41],
                        popupAnchor: [1, -34],
                    })
                }).addTo(map);
                
                checkOutMarker.bindPopup(`
                    <strong>Check-out</strong><br>
                    Time: <?= htmlspecialchars($employee['time_out']) ?><br>
                    Location: <?= htmlspecialchars($employee['location_out']) ?>
                `);

                // Draw line between check-in and check-out
                L.polyline([[lat_in, lng_in], [lat_out, lng_out]], {
                    color: 'blue',
                    weight: 3,
                    opacity: 0.8
                }).addTo(map);

                // Fit map to show both markers
                map.fitBounds([[lat_in, lng_in], [lat_out, lng_out]], {padding: [20, 20]});
            }

            // Add relevant geofences
            locations.forEach(loc => {
                const distance = map.distance([lat_in, lng_in], [loc.lat, loc.lng]);
                if (distance <= 200) { // Show geofences within 200m
                    L.circle([loc.lat, loc.lng], {
                        color: 'blue',
                        fillColor: '#99ccff',
                        fillOpacity: 0.2,
                        radius: loc.radius
                    }).addTo(map).bindPopup(loc.name);
                }
            });
        })();
        <?php endforeach; ?>

        // Historical maps
        <?php foreach (array_slice($rows, 0, 10) as $row): ?>
        (function() {
            const mapId = "map_historical_<?= $row['id'] ?>";
            const lat_in = <?= $row['lat_in'] ?: 'null' ?>;
            const lng_in = <?= $row['lng_in'] ?: 'null' ?>;
            const lat_out = <?= $row['lat_out'] ?: 'null' ?>;
            const lng_out = <?= $row['lng_out'] ?: 'null' ?>;

            if (!lat_in || !lng_in) return;

            const map = L.map(mapId).setView([lat_in, lng_in], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Add check-in marker
            L.marker([lat_in, lng_in], {
                icon: L.icon({
                    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                })
            }).addTo(map)
            .bindPopup(`<strong>Check-in:</strong><br><?= addslashes($row['location_in']) ?><br><?= addslashes($row['time_in']) ?>`)
            .openPopup();

            // Add check-out marker if exists
            if (lat_out && lng_out) {
                L.marker([lat_out, lng_out], {
                    icon: L.icon({
                        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
                        iconSize: [25, 41],
                        iconAnchor: [12, 41],
                        popupAnchor: [1, -34],
                    })
                }).addTo(map)
                .bindPopup(`<strong>Check-out:</strong><br><?= addslashes($row['location_out']) ?><br><?= addslashes($row['time_out']) ?>`);

                // Draw line between check-in and check-out
                L.polyline([[lat_in, lng_in], [lat_out, lng_out]], {
                    color: 'blue',
                    weight: 2,
                    opacity: 0.7
                }).addTo(map);

                // Fit map to show both markers
                map.fitBounds([[lat_in, lng_in], [lat_out, lng_out]], {padding: [20, 20]});
            }
        })();
        <?php endforeach; ?>

        // Control functions
        function showAllEmployees() {
            // This function could filter to show all employees
            console.log('Showing all employees');
        }

        function showActiveOnly() {
            // This function could filter to show only active employees
            console.log('Showing active employees only');
        }

        function showGeofences() {
            // Toggle geofence visibility
            geofenceVisible = !geofenceVisible;
            console.log('Toggling geofences:', geofenceVisible);
        }

        function filterByDate() {
            const selectedDate = document.getElementById('dateFilter').value;
            console.log('Filtering by date:', selectedDate);
            // Implement date filtering logic here
        }

        // Add user's current location if available
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(position => {
                const userLat = position.coords.latitude;
                const userLng = position.coords.longitude;
                
                L.marker([userLat, userLng], {
                    icon: L.icon({
                        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-blue.png',
                        iconSize: [25, 41],
                        iconAnchor: [12, 41],
                        popupAnchor: [1, -34],
                    })
                }).addTo(mainMap)
                .bindPopup("Your current location")
                .openPopup();
            });
        }
    </script>

    <script src="../public/js/session.js"></script>
    <script src="../public/js/main.js"></script>
</body>
</html>