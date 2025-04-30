<?php
include "../conn.php";

$totalEmployees = 0;
$presentToday = 0;
$absentToday = 0;

$sqlTotal = "SELECT COUNT(*) as total FROM dbl_employees_acc";
$resultTotal = $conn->query($sqlTotal);
if ($resultTotal && $row = $resultTotal->fetch_assoc()) {
    $totalEmployees = (int)$row['total'];
}

$sqlPresent = "SELECT COUNT(*) as present FROM dbl_attendance_logs WHERE date = CURDATE() AND (status = 'On time' OR status = 'Late')";
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
  <link rel="stylesheet" href="../public/css/main.css">
  <link rel="stylesheet" href="../public/css/darkmode.css">
  <link rel="icon" href="../public/img/DBL.png">
  <script type="text/javascript" src="../public/js/darkmode.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <title>DBL ISTS</title>
</head>
<style>

:root {
  --base-color: white;
  --base-variant: #f7f8fa;
  --text-color: #1c1f2b;
  --secondary-text: #4e5566;
  --primary-color: #3a435d;
  --accent-color: #0071ff;
}

.darkmode {
  --base-color: #11121a;
  --base-variant: #1a1c2e;
  --text-color: #ffffff;
  --secondary-text: #a4a5b8;
  --primary-color: #3a435d;
  --accent-color: #0071ff;
}

.dashboard {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  justify-content: center;
  margin: 30px 15px;
}

.box-content {
  text-align: center;
  font-size: 2.2rem;
  color: var(--text-color);
  font-weight: bold;
  margin-top: 10px;
}

.box:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 24px rgba(0, 0, 0, 0.1);
}

.status-text {
  font-size: 1.1rem;
  color: var(--secondary-text);
  margin-top: 5px;
  text-align: center;
}

.highlight {
  color: var(--accent-color);
  font-weight: 600;
}

.box {
  background: var(--base-variant);
  border-radius: 16px;
  box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
  padding: 25px 20px;
  flex: 1 1 450px;
  min-height: 300px;
  transition: 0.3s ease-in-out;
  display: flex;
  flex-direction: column;
}

.chart-container {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
}

#itineraryChart {
  max-width: 200px;
  max-height: 300px;
  margin: 0 auto;
}

.task-legend {
  display: flex;
  justify-content: center;
  gap: 20px;
  margin-top: 15px;
  font-size: 12px;
  color: var(--secondary-text);
}

.dot {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  display: inline-block;
}

.gold { background-color: #ffc107; }
.green { background-color: #00c853; }
.red { background-color: #dc3545; }

.box h3 {
  font-size: 20px;
  font-weight: 600;
  margin-bottom: 15px;
  color: var(--primary-color);
  text-align: center;
}

canvas {
  max-width: 100%;
  height: 250px !important;
}

.status {
  font-weight: bold;
  text-align: center;
  background: #dc3545;
  color: #fff;
  padding: 8px 14px;
  border-radius: 10px;
  display: inline-block;
  margin-top: 15px;
}

.person {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-top: 12px;
}

.avatar {
  width: 42px;
  height: 42px;
  background: #bbb;
  border-radius: 50%;
}

.task-legend {
  display: flex;
  justify-content: space-evenly;
  margin-top: 18px;
  font-size: 14px;
  color: var(--secondary-text);
}

.task-legend span {
  display: flex;
  align-items: center;
  gap: 6px;
}

.dot {
  width: 12px;
  height: 12px;
  border-radius: 50%;
}

.green { background-color: #28a745; }
.orange { background-color: #ffc107; }
.red { background-color: #dc3545; }

.logo {
  font-size: 20px;
  font-weight: bold;
  margin-left: 10px;
  color: var(--accent-color);
}
  </style>
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
    </li>
    <a href="itinerary.php">
      <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M280-280h160v-160H280v160Zm240 0h160v-160H520v160ZM280-520h160v-160H280v160Zm240 0h160v-160H520v160ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z"/></svg>
      <span>Itinerary</span>
      </a>
      </li>
      <li>
        <a href="employees.php">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-40q0-17 11.5-28.5T280-880q17 0 28.5 11.5T320-840v40h320v-40q0-17 11.5-28.5T680-880q17 0 28.5 11.5T720-840v40h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Zm0-480h560v-80H200v80Zm0 0v-80 80Zm280 240q-17 0-28.5-11.5T440-440q0-17 11.5-28.5T480-480q17 0 28.5 11.5T520-440q0 17-11.5 28.5T480-400Zm-160 0q-17 0-28.5-11.5T280-440q0-17 11.5-28.5T320-480q17 0 28.5 11.5T360-440q0 17-11.5 28.5T320-400Zm320 0q-17 0-28.5-11.5T600-440q0-17 11.5-28.5T640-480q17 0 28.5 11.5T680-440q0 17-11.5 28.5T640-400ZM480-240q-17 0-28.5-11.5T440-280q0-17 11.5-28.5T480-320q17 0 28.5 11.5T520-280q0 17-11.5 28.5T480-240Zm-160 0q-17 0-28.5-11.5T280-280q0-17 11.5-28.5T320-320q17 0 28.5 11.5T360-280q0 17-11.5 28.5T320-240Zm320 0q-17 0-28.5-11.5T600-280q0-17 11.5-28.5T640-320q17 0 28.5 11.5T680-280q0 17-11.5 28.5T640-240Z"/></svg>
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
        <a href="../logout.php">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-240v-32q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v32q0 33-23.5 56.5T720-160H240q-33 0-56.5-23.5T160-240Zm80 0h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z"/></svg>
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
 
    <div class="dashboard">
    <div class="box">
      <h3>Daily Attendance</h3>
      <canvas id="attendanceChart"></canvas>
    </div>


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

 <!--
   <div class="box invite-box">
      <div>
        <h3>Invite to Office Meet-up</h3>
        <p><strong>Due:</strong> December 23, 2018</p>
        <div class="person">
          <div class="avatar"></div>
          <span>Jobert Ken Borda</span>
        </div>
      </div>
      <div class="status">Ended</div> 
    </div>  -->

</div>
  </main>
</body>
<script>
 const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
const attendanceChart = new Chart(attendanceCtx, {
  type: 'line',
  data: {
    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
    datasets: [{
      label: 'People Present',
      data: [23, 45, 38, 50, 41, 35, 28],
      borderColor: '#007bff',
      backgroundColor: 'rgba(0, 123, 255, 0.15)',
      tension: 0.4,
      fill: true,
      pointRadius: 5,
      pointHoverRadius: 7,
      pointBackgroundColor: '#007bff',
      pointHoverBackgroundColor: '#0056b3',
      pointBorderWidth: 2,
      pointHoverBorderWidth: 3
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: { display: false },
      tooltip: {
        backgroundColor: '#ffffff',
        titleColor: '#000',
        bodyColor: '#000',
        borderColor: '#007bff',
        borderWidth: 1,
        padding: 10,
        cornerRadius: 8
      }
    },
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          stepSize: 10,
          font: { size: 14 }
        },
        title: {
          display: true,
          text: 'Number of People',
          font: { size: 16, weight: 'bold' }
        },
        grid: {
          color: '#e0e0e0',
          drawBorder: false
        }
      },
      x: {
        ticks: { font: { size: 14 } },
        grid: {
          display: false
        }
      }
    },
    animation: {
      duration: 1000,
      easing: 'easeOutQuart'
    }
  }
});

// Adjust the canvas position after rendering the chart
document.getElementById('attendanceChart').style.marginLeft = '20px'; // Adjust this value as needed

  const itineraryCtx = document.getElementById('itineraryChart').getContext('2d');
  const centerTextPlugin = {
  id: 'centerText',
  beforeDraw(chart) {
    const { width, height } = chart;
    const ctx = chart.ctx;
    ctx.restore();
    
    // Calculate the completed percentage
    const total = chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
    const percent = Math.round((chart.data.datasets[0].data[1] / total) * 100);
    const text = percent + "%";
    
    // Set text style
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    ctx.font = 'bold 3rem poppins';
    
    // Draw the percentage text in the center
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
    cutout: '92%', // Controls the thickness of the ring
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
</html>