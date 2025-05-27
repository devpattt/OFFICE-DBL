<?php
include '../includes/isset.php';
include "../conn.php";

$totalEmployees = 0;
$presentToday = 0;
$absentToday = 0;

$sqlTotal = "SELECT COUNT(*) as total FROM dbl_employees_acc";
$resultTotal = $conn->query($sqlTotal);
if ($resultTotal && $row = $resultTotal->fetch_assoc()) {
    $totalEmployees = (int)$row['total'];
}

$sqlPresent = "SELECT COUNT(*) as present FROM dbl_attendance_logs WHERE date = CURDATE() AND (status = 'Pending')";
$resultPresent = $conn->query($sqlPresent);
if ($resultPresent && $row = $resultPresent->fetch_assoc()) {
    $presentToday = (int)$row['present'];
}

$absentToday = $totalEmployees - $presentToday;

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../public/css/dashboard.css">
  <link rel="stylesheet" href="../public/css/main.css">
  <link rel="stylesheet" href="../public/css/darkmode.css">
  <link rel="stylesheet" href="../public/css/home.css">
  <link rel="icon" href="../public/img/DBL.png">
  <script type="text/javascript" src="../public/js/darkmode.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <title>DBL ISTS</title>
</head>
<body>

 <nav id="sidebar">
    <ul>
      <li>
        <span class="logo">DBL ISTS</span>
        <button onclick=toggleSidebar() id="toggle-btn">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg>
        </button>
      <li>
        <li class="active">
          <a href="home.php">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M520-640v-160q0-17 11.5-28.5T560-840h240q17 0 28.5 11.5T840-800v160q0 17-11.5 28.5T800-600H560q-17 0-28.5-11.5T520-640ZM120-480v-320q0-17 11.5-28.5T160-840h240q17 0 28.5 11.5T440-800v320q0 17-11.5 28.5T400-440H160q-17 0-28.5-11.5T120-480Zm400 320v-320q0-17 11.5-28.5T560-520h240q17 0 28.5 11.5T840-480v320q0 17-11.5 28.5T800-120H560q-17 0-28.5-11.5T520-160Zm-400 0v-160q0-17 11.5-28.5T160-360h240q17 0 28.5 11.5T440-320v160q0 17-11.5 28.5T400-120H160q-17 0-28.5-11.5T120-160Zm80-360h160v-240H200v240Zm400 320h160v-240H600v240Zm0-480h160v-80H600v80ZM200-200h160v-80H200v80Zm160-320Zm240-160Zm0 240ZM360-280Z"/></svg>
            <span>Dashboard</span>
          </a>
      </li>
      <li>
        <a href="map.php">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="M480-480q33 0 56.5-23.5T560-560q0-33-23.5-56.5T480-640q-33 0-56.5 23.5T400-560q0 33 23.5 56.5T480-480Zm0 294q122-112 181-203.5T720-552q0-109-69.5-178.5T480-800q-101 0-170.5 69.5T240-552q0 71 59 162.5T480-186Zm0 106Q319-217 239.5-334.5T160-552q0-150 96.5-239T480-880q127 0 223.5 89T800-552q0 100-79.5 217.5T480-80Zm0-480Z"/></svg>
          <span>Attendance Map</span>
        </a>
      </li>
    <li>
        <a href="attendance_logs.php">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="m576-160-56-56 104-104-104-104 56-56 104 104 104-104 56 56-104 104 104 104-56 56-104-104-104 104Zm79-360L513-662l56-56 85 85 170-170 56 57-225 226ZM80-280v-80h360v80H80Zm0-320v-80h360v80H80Z"/></svg>
          <span>Attendance Logs</span>
        </a>
      </li>
    <li>
    <a href="itinerary.php">
      <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M280-280h160v-160H280v160Zm240 0h160v-160H520v160ZM280-520h160v-160H280v160Zm240 0h160v-160H520v160ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z"/></svg>
      <span>Itinerary</span>
      </a>
      </li>
      <li>
      <li>
        <a href="employee_logs.php">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-40q0-17 11.5-28.5T280-880q17 0 28.5 11.5T320-840v40h320v-40q0-17 11.5-28.5T680-880q17 0 28.5 11.5T720-840v40h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Zm0-480h560v-80H200v80Zm0 0v-80 80Zm280 240q-17 0-28.5-11.5T440-440q0-17 11.5-28.5T480-480q17 0 28.5 11.5T520-440q0 17-11.5 28.5T480-400Zm-160 0q-17 0-28.5-11.5T280-440q0-17 11.5-28.5T320-480q17 0 28.5 11.5T360-440q0 17-11.5 28.5T320-400Zm320 0q-17 0-28.5-11.5T600-440q0-17 11.5-28.5T640-480q17 0 28.5 11.5T680-440q0 17-11.5 28.5T640-400ZM480-240q-17 0-28.5-11.5T440-280q0-17 11.5-28.5T480-320q17 0 28.5 11.5T520-280q0 17-11.5 28.5T480-240Zm-160 0q-17 0-28.5-11.5T280-280q0-17 11.5-28.5T320-320q17 0 28.5 11.5T360-280q0 17-11.5 28.5T320-240Zm320 0q-17 0-28.5-11.5T600-280q0-17 11.5-28.5T640-320q17 0 28.5 11.5T680-280q0 17-11.5 28.5T640-240Z"/></svg>
          <span>Itinerary Logs</span>
        </a>
      </li>
      <li>
        <a href="report.php">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="M320-480v-80h320v80H320Zm0-160v-80h320v80H320Zm-80 240h300q29 0 54 12.5t42 35.5l84 110v-558H240v400Zm0 240h442L573-303q-6-8-14.5-12.5T540-320H240v160Zm480 80H240q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h480q33 0 56.5 23.5T800-800v640q0 33-23.5 56.5T720-80Zm-480-80v-640 640Zm0-160v-80 80Z"/></svg>
          <span>Reports</span>
        </a>
      </li>
      <li>
          <a href="leavemanagement.php">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="M440-280h320v-22q0-45-44-71.5T600-400q-72 0-116 26.5T440-302v22Zm160-160q33 0 56.5-23.5T680-520q0-33-23.5-56.5T600-600q-33 0-56.5 23.5T520-520q0 33 23.5 56.5T600-440ZM160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h240l80 80h320q33 0 56.5 23.5T880-640v400q0 33-23.5 56.5T800-160H160Zm0-80h640v-400H447l-80-80H160v480Zm0 0v-480 480Z"/></svg>
                <span>Leave Management</span>
              </a>
        </li>
             <li>
        <a href="employees.php">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="M0-240v-63q0-43 44-70t116-27q13 0 25 .5t23 2.5q-14 21-21 44t-7 48v65H0Zm240 0v-65q0-32 17.5-58.5T307-410q32-20 76.5-30t96.5-10q53 0 97.5 10t76.5 30q32 20 49 46.5t17 58.5v65H240Zm540 0v-65q0-26-6.5-49T754-397q11-2 22.5-2.5t23.5-.5q72 0 116 26.5t44 70.5v63H780Zm-455-80h311q-10-20-55.5-35T480-370q-55 0-100.5 15T325-320ZM160-440q-33 0-56.5-23.5T80-520q0-34 23.5-57t56.5-23q34 0 57 23t23 57q0 33-23 56.5T160-440Zm640 0q-33 0-56.5-23.5T720-520q0-34 23.5-57t56.5-23q34 0 57 23t23 57q0 33-23 56.5T800-440Zm-320-40q-50 0-85-35t-35-85q0-51 35-85.5t85-34.5q51 0 85.5 34.5T600-600q0 50-34.5 85T480-480Zm0-80q17 0 28.5-11.5T520-600q0-17-11.5-28.5T480-640q-17 0-28.5 11.5T440-600q0 17 11.5 28.5T480-560Zm1 240Zm-1-280Z"/></svg>
          <span>Active Users</span>
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
            <?php
              $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
              date_default_timezone_set('Asia/Manila');
              $hour = (int)date('G');
              if ($hour >= 5 && $hour < 12) {
                  $greeting = "Good morning";
              } elseif ($hour >= 12 && $hour < 18) {
                  $greeting = "Good afternoon";
              } else {
                  $greeting = "Good evening";
              }
          ?>
          <div class="welcome-message">
              <h1>
                  <?php echo "$greeting, <span style='color:#3498db'>" . htmlspecialchars($username) . "</span>!"; ?>
              </h1>
              <p>Welcome to your dashboard. Wishing you a productive day ahead!</p>
          </div> 
  

    <div class="dashboard-container">
      <div class="info-cards">

        <div class="info-card purple">
          <i class="fas fa-users"></i>
          <div>
            <small>Total Employees</small>
            <h4 id="total-employees"><?php echo $totalEmployees; ?></h4>
          </div>
        </div>

        <div class="info-card teal">
          <i class="fas fa-user-check"></i>
          <div>
            <small>Present Today</small>
            <h4 id="present-today"><?php echo $presentToday; ?></h4>
          </div>
        </div>

        <div class="info-card orange">
            <i class="fas fa-user-times"></i>
            <div>
              <small>Absent Today</small>
              <h4 id="absent-today"><?php echo $absentToday; ?></h4>
            </div>
          </div>
      </div>
    </div>
    
    <div class="box">
        <h2 class="upcoming-holidays-title">Upcoming Holidays</h2>
          <table class="event-table">
            <thead>
              <tr>
                <th>Holiday</th>
                <th>Date</th>
                <th>Type</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody id="holidayTableBody">
            </tbody>
          </table>
        </div>
        
      <!--
        <div class="box">
          <h3>Task Status</h3>
          <div class="chart-container">
            <canvas id="itineraryChart"></canvas>
          </div>
          <div class="task-legend">
            <span><span class="dot gold"></span> Active</span>
            <span><span class="dot green"></span> Completed</span>
            <span><span class="dot red"></span> Ended</span>
          </div>
        </div>
      -->

</div>
  </main>
  <div id="logout-warning" style="display:none; position:fixed; bottom:30px; right:30px; background:#fff8db; color:#8a6d3b; border:1px solid #f0c36d; padding:15px 20px; z-index:1000; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.2);">
      <strong>Inactive for too long.</strong><br>
      Logging out in <span id="countdown">10</span> seconds...
  </div>

  <div id="session-expired-modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.6); z-index:2000; justify-content:center; align-items:center;">
      <div style="background:#fff; padding:30px; border-radius:12px; text-align:center; max-width:400px; margin:auto; box-shadow:0 4px 20px rgba(0,0,0,0.3);">
          <h2 style="margin-bottom:10px;">Session Expired</h2>
          <p style="margin-bottom:20px;">You've been inactive for too long. Please log in again.</p>
          <button id="logout-confirm-btn" style="padding:10px 20px; background-color:#ef4444; color:white; border:none; border-radius:8px; cursor:pointer;">Okay</button>
      </div>
  </div>
  
<script src="../public/js/session.js"></script>
</body>
<script>
// This could be expanded with a complete dataset or API
function getPhilippinesHolidays(year) {
  return [
    { name: "New Year's Day", date: `January 1, ${year}`, type: "regular" },
    { name: "Araw ng Kagitingan", date: `April 9, ${year}`, type: "regular" },
    { name: "Maundy Thursday", date: "April 6, 2025", type: "regular" },
    { name: "Good Friday", date: "April 7, 2025", type: "regular" },
    { name: "Labor Day", date: `May 1, ${year}`, type: "regular" },
    { name: "Independence Day", date: `June 12, ${year}`, type: "regular" },
    { name: "National Heroes Day", date: `August 30, ${year}`, type: "regular" },
    { name: "Bonifacio Day", date: `November 30, ${year}`, type: "regular" },
    { name: "Christmas Day", date: `December 25, ${year}`, type: "regular" },
    { name: "Rizal Day", date: `December 30, ${year}`, type: "regular" },
    { name: "Chinese New Year", date: "February 10, 2025", type: "special" },
    { name: "EDSA Revolution", date: `February 25, ${year}`, type: "special" },
    { name: "All Saints' Day", date: `November 1, ${year}`, type: "special" },
    { name: "All Souls' Day", date: `November 2, ${year}`, type: "special" },
    { name: "Feast of the Immaculate Conception", date: `December 8, ${year}`, type: "special" },
  ];
}

function getNextHolidays(count = 5) {
  const currentYear = new Date().getFullYear();
  const today = new Date();
  today.setHours(0, 0, 0, 0);
  
  const allHolidays = [
    ...getPhilippinesHolidays(currentYear),
    ...getPhilippinesHolidays(currentYear + 1)
  ];
  
  const upcomingHolidays = allHolidays.filter(holiday => {
    const holidayDate = new Date(holiday.date);
    return holidayDate >= today;
  });
  
  upcomingHolidays.sort((a, b) => new Date(a.date) - new Date(b.date));
  
  return upcomingHolidays.slice(0, count);
}

function updateHolidayTable() {
  const tableBody = document.getElementById("holidayTableBody");
  const nextHolidays = getNextHolidays(5);
  
  tableBody.innerHTML = "";

  nextHolidays.forEach(holiday => {
    const holidayDate = new Date(holiday.date);
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    
    const status = holidayDate.getTime() === today.getTime() ? "active" : "upcoming";
    
    const row = document.createElement("tr");
    row.innerHTML = `
      <td>${holiday.name}</td>
      <td>${holiday.date}</td>
      <td><span class="status ${holiday.type}">${capitalize(holiday.type)}</span></td>
      <td><span class="status ${status}">${capitalize(status)}</span></td>
    `;
    
    tableBody.appendChild(row);
  });
}

function capitalize(str) {
  return str.charAt(0).toUpperCase() + str.slice(1);
}

document.addEventListener("DOMContentLoaded", updateHolidayTable);

setInterval(() => {
  updateHolidayTable();
}, 86400000); 
</script>

<script>
const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
const attendanceChart = new Chart(attendanceCtx, {
  type: 'line',
  data: {
    labels: ['Dec', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
    datasets: [
      {
        label: 'Last 6 Months',
        data: [25, 38, 28, 35, 50, 28, 32],
        borderColor: '#007bff',
        backgroundColor: 'rgba(0, 123, 255, 0.1)',
        borderWidth: 3,
        tension: 0.4,
        fill: true,
        pointRadius: 3,
        pointHoverRadius: 5
      },
      {
        label: 'Previous',
        data: [20, 25, 18, 30, 20, 28, 38],
        borderColor: '#26a69a',
        backgroundColor: 'rgba(38, 166, 154, 0.1)',
        borderWidth: 3,
        tension: 0.4,
        fill: true,
        pointRadius: 3,
        pointHoverRadius: 5
      }
    ]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        display: true,
        position: 'top',
        labels: {
          usePointStyle: true,
          boxWidth: 6
        }
      },
      tooltip: {
        backgroundColor: 'rgba(255, 255, 255, 0.9)',
        titleColor: '#1c1f2b',
        bodyColor: '#1c1f2b',
        borderColor: '#e0e0e0',
        borderWidth: 1,
        padding: 10,
        cornerRadius: 6,
        displayColors: false
      }
    },
    scales: {
      y: {
        beginAtZero: true,
        max: 100,
        ticks: {
          stepSize: 25
        },
        grid: {
          color: 'rgba(0, 0, 0, 0.05)'
        }
      },
      x: {
        grid: {
          display: false
        }
      }
    }
  }
});

document.getElementById('attendanceChart').style.marginLeft = '20px'; 

  const itineraryCtx = document.getElementById('itineraryChart').getContext('2d');
  const centerTextPlugin = {
  id: 'centerText',
  beforeDraw(chart) {
    const { width, height } = chart;
    const ctx = chart.ctx;
    ctx.restore();

    const total = chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
    const percent = Math.round((chart.data.datasets[0].data[1] / total) * 100);
    const text = percent + "%";
    
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    ctx.font = 'bold 3rem poppins';
    
    ctx.fillStyle = "#00c853";  
    ctx.fillText(text, width / 2, height / 2);
    ctx.save();
  }
};
new Chart(itineraryCtx, {
  type: 'doughnut',
  data: {
    datasets: [{
      data: [20, 60, 20],
      backgroundColor: ['#ffc107', '#00c853', '#dc3545'],  
      borderWidth: 0,
      borderRadius: 0  
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    cutout: '92%', 
    plugins: {
      legend: {
        display: true,
        position: 'bottom',
        labels: {
          usePointStyle: true,
          pointStyle: 'circle',
          padding: 20,
          font: {
            size: 12
          }
        }
      }
    }
  },
  plugins: [centerTextPlugin]
});

</script>
<script src="../public/js/main.js"></script>
<script src="../public/js/dashboard.js"></script>
</html>