<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/main.css">
    <link rel="stylesheet" href="../public/css/darkmode.css">
    <link rel="icon" href="../public/img/DBL.png">
        <link rel="stylesheet" href="../public/css/attendance.css">
    <script type="text/javascript" src="../public/js/darkmode.js" defer></script>
    <title>DBL ISTS</title>
  </head>
<body>
<nav id="sidebar">
    <ul>
      <li>
        <span class="logo">DBL ISTS</span>
        <button onclick=toggleSidebar() id="toggle-btn">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m313-480 155 156q11 11 11.5 27.5T468-268q-11 11-28 11t-28-11L228-452q-6-6-8.5-13t-2.5-15q0-8 2.5-15t8.5-13l184-184q11-11 27.5-11.5T468-692q11 11 11 28t-11 28L313-480Zm264 0 155 156q11 11 11.5 27.5T732-268q-11 11-28 11t-28-11L492-452q-6-6-8.5-13t-2.5-15q0-8 2.5-15t8.5-13l184-184q11-11 27.5-11.5T732-692q11 11 11 28t-11 28L577-480Z"/></svg>
        </button>
      <li>
        <li>
        <a href="home.php">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M520-640v-160q0-17 11.5-28.5T560-840h240q17 0 28.5 11.5T840-800v160q0 17-11.5 28.5T800-600H560q-17 0-28.5-11.5T520-640ZM120-480v-320q0-17 11.5-28.5T160-840h240q17 0 28.5 11.5T440-800v320q0 17-11.5 28.5T400-440H160q-17 0-28.5-11.5T120-480Zm400 320v-320q0-17 11.5-28.5T560-520h240q17 0 28.5 11.5T840-480v320q0 17-11.5 28.5T800-120H560q-17 0-28.5-11.5T520-160Zm-400 0v-160q0-17 11.5-28.5T160-360h240q17 0 28.5 11.5T440-320v160q0 17-11.5 28.5T400-120H160q-17 0-28.5-11.5T120-160Zm80-360h160v-240H200v240Zm400 320h160v-240H600v240Zm0-480h160v-80H600v80ZM200-200h160v-80H200v80Zm160-320Zm240-160Zm0 240ZM360-280Z"/></svg>
          <span>Dashboard</span>
        </a>
      </li>
    <li class="active">
    <a href="main.php">
      <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M280-280h160v-160H280v160Zm240 0h160v-160H520v160ZM280-520h160v-160H280v160Zm240 0h160v-160H520v160ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z"/></svg>
      <span>In/Out</span>
    </a>
      </li>
      <li>
        <a href="iterinary.php">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-40q0-17 11.5-28.5T280-880q17 0 28.5 11.5T320-840v40h320v-40q0-17 11.5-28.5T680-880q17 0 28.5 11.5T720-840v40h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Zm0-480h560v-80H200v80Zm0 0v-80 80Zm280 240q-17 0-28.5-11.5T440-440q0-17 11.5-28.5T480-480q17 0 28.5 11.5T520-440q0 17-11.5 28.5T480-400Zm-160 0q-17 0-28.5-11.5T280-440q0-17 11.5-28.5T320-480q17 0 28.5 11.5T360-440q0 17-11.5 28.5T320-400Zm320 0q-17 0-28.5-11.5T600-440q0-17 11.5-28.5T640-480q17 0 28.5 11.5T680-440q0 17-11.5 28.5T640-400ZM480-240q-17 0-28.5-11.5T440-280q0-17 11.5-28.5T480-320q17 0 28.5 11.5T520-280q0 17-11.5 28.5T480-240Zm-160 0q-17 0-28.5-11.5T280-280q0-17 11.5-28.5T320-320q17 0 28.5 11.5T360-280q0 17-11.5 28.5T320-240Zm320 0q-17 0-28.5-11.5T600-280q0-17 11.5-28.5T640-320q17 0 28.5 11.5T680-280q0 17-11.5 28.5T640-240Z"/></svg>
          <span>Iterinary</span>
        </a>
      </li>
      </li>
      <li>
        <a href="reports.php">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-40q0-17 11.5-28.5T280-880q17 0 28.5 11.5T320-840v40h320v-40q0-17 11.5-28.5T680-880q17 0 28.5 11.5T720-840v40h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Zm0-480h560v-80H200v80Zm0 0v-80 80Zm280 240q-17 0-28.5-11.5T440-440q0-17 11.5-28.5T480-480q17 0 28.5 11.5T520-440q0 17-11.5 28.5T480-400Zm-160 0q-17 0-28.5-11.5T280-440q0-17 11.5-28.5T320-480q17 0 28.5 11.5T360-440q0 17-11.5 28.5T320-400Zm320 0q-17 0-28.5-11.5T600-440q0-17 11.5-28.5T640-480q17 0 28.5 11.5T680-440q0 17-11.5 28.5T640-400ZM480-240q-17 0-28.5-11.5T440-280q0-17 11.5-28.5T480-320q17 0 28.5 11.5T520-280q0 17-11.5 28.5T480-240Zm-160 0q-17 0-28.5-11.5T280-280q0-17 11.5-28.5T320-320q17 0 28.5 11.5T360-280q0 17-11.5 28.5T320-240Zm320 0q-17 0-28.5-11.5T600-280q0-17 11.5-28.5T640-320q17 0 28.5 11.5T680-280q0 17-11.5 28.5T640-240Z"/></svg>
          <span>Reports</span>
        </a>
      </li>
      <li>
        <a href="map.php">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-240v-32q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v32q0 33-23.5 56.5T720-160H240q-33 0-56.5-23.5T160-240Zm80 0h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z"/></svg>
          <span>Map</span>
        </a>
      </li>
      <li>
        <a href="profile.php">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-240v-32q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v32q0 33-23.5 56.5T720-160H240q-33 0-56.5-23.5T160-240Zm80 0h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z"/></svg>
          <span>Profile</span>
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
      <div class="clock-in-container">
      <button id="clock-in-btn" onclick="openClockInModal()">Clock In</button>
      </div>

  <div class="container mt-5">
    <h2>Attendance Logs</h2>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Date</th>
          <th>Clock In</th>
          <th>Clock Out</th>
          <th>Status</th>
          <th>Location</th>
        </tr>
      </thead>
      <tbody id="attendance-logs">
      </tbody>
    </table>
  </div>

  <div id="clock-in-modal" style="display: none;">
    <div class="modal-content">
      <h2>Clock In</h2>
      <p>Time: <span id="clock-in-time"></span></p>
      <p>Location: <span id="clock-in-location"></span></p>
      <input type="hidden" id="clock-in-lat">
      <input type="hidden" id="clock-in-lng">
      <button onclick="submitClockIn()">Submit</button>
      <button onclick="closeClockInModal()">Cancel</button>
    </div>
  </div>

  <div id="confirmation-modal" style="display: none;">
    <div class="modal-content">
      <h2>Confirmation</h2>
      <p id="confirmation-message"></p>
      <button onclick="closeConfirmationModal()">OK</button>
    </div>
  </div>

  <script>
    function openClockInModal() {
      const now = new Date();
      const options = { weekday: 'long', year: 'numeric', month: 'numeric', day: 'numeric', hour: 'numeric', minute: 'numeric', hour12: true };
      document.getElementById('clock-in-time').innerText = now.toLocaleString('en-US', options);

      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((position) => {
          const { latitude, longitude } = position.coords;
          document.getElementById('clock-in-lat').value = latitude;
          document.getElementById('clock-in-lng').value = longitude;

          // Use Google Maps Geocoding API to get the address
          const apiKey = 'YOUR_GOOGLE_MAPS_API_KEY'; // Replace with your API key
          const geocodeUrl = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${latitude},${longitude}&key=${apiKey}`;

          fetch(geocodeUrl)
            .then((response) => response.json())
            .then((data) => {
              if (data.status === 'OK' && data.results.length > 0) {
                const address = data.results[0].formatted_address;
                document.getElementById('clock-in-location').innerText = address;
              } else {
                document.getElementById('clock-in-location').innerText = 'Address not found';
              }
            })
            .catch((error) => {
              console.error('Error fetching address:', error);
              document.getElementById('clock-in-location').innerText = 'Error fetching address';
            });
        });
      } else {
        document.getElementById('clock-in-location').innerText = 'Location not available';
      }

      document.getElementById('clock-in-modal').style.display = 'block';
    }

    function closeClockInModal() {
      document.getElementById('clock-in-modal').style.display = 'none';
    }

    function submitClockIn() {
      const location = document.getElementById('clock-in-location').innerText;
      const latitude = document.getElementById('clock-in-lat').value;
      const longitude = document.getElementById('clock-in-lng').value;

      fetch('../includes/attendance.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ location, latitude, longitude }),
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error('Session expired. Please log in again.');
          }
          return response.text();
        })
        .then((data) => {
          document.getElementById('confirmation-message').innerText = data;
          document.getElementById('confirmation-modal').style.display = 'block';
          closeClockInModal();
          fetchAttendanceLogs();

          const clockInBtn = document.getElementById('clock-in-btn');
          clockInBtn.innerText = 'Clock Out';
          clockInBtn.onclick = submitClockOut; 
        })
        .catch((error) => {
          alert(error.message); 
          window.location.href = '../login.php'; 
        });
    }

    function closeConfirmationModal() {
      document.getElementById('confirmation-modal').style.display = 'none';
    }

    function fetchAttendanceLogs() {
      fetch('../includes/fetch_attendance.php')
        .then((response) => response.json())
        .then((data) => {
          const tableBody = document.getElementById('attendance-logs');
          tableBody.innerHTML = ''; 

          let isClockedIn = false;

          data.forEach((log) => {
            const row = `
              <tr>
                <td>${log.date}</td>
                <td>${log.time_in || 'N/A'}</td>
                <td>${log.time_out || 'N/A'}</td>
                <td>${log.status}</td>
                <td>${log.location_in || 'N/A'}</td>
              </tr>
            `;
            tableBody.innerHTML += row;

            if (log.time_out === 'N/A') {
              isClockedIn = true;
            }
          });

          const clockInBtn = document.getElementById('clock-in-btn');
          if (isClockedIn) {
            clockInBtn.innerText = 'Clock Out';
            clockInBtn.onclick = submitClockOut;
          } else {
            clockInBtn.innerText = 'Clock In';
            clockInBtn.onclick = openClockInModal;
          }
        })
        .catch((error) => console.error('Error fetching attendance logs:', error));
    }

    document.addEventListener('DOMContentLoaded', fetchAttendanceLogs);

    function submitClockOut() {
      const location = document.getElementById('clock-in-location').innerText;
      const latitude = document.getElementById('clock-in-lat').value;
      const longitude = document.getElementById('clock-in-lng').value;

      fetch('../includes/attendance.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ location, latitude, longitude, clockOut: true }), // Include location data
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error('Session expired. Please log in again.');
          }
          return response.text();
        })
        .then((data) => {
          document.getElementById('confirmation-message').innerText = data;
          document.getElementById('confirmation-modal').style.display = 'block';
          fetchAttendanceLogs();

          const clockInBtn = document.getElementById('clock-in-btn');
          clockInBtn.innerText = 'Clock In';
          clockInBtn.onclick = openClockInModal; // Reset the button functionality
        })
        .catch((error) => {
          alert(error.message);
          window.location.href = '../login.php';
        });
    }
  </script>
</main>
</body>
<script src="../public/js/main.js"></script>
</html>