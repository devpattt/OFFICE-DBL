const locations = [
  { id: "DBL ISTS", name: "DBL ISTS", lat: 14.73990, lng: 120.98754, radius: 50 },
  { id: "WL Headquarter", name: "WL Headquarter", lat: 14.737567, lng: 120.99018, radius: 50 },
  { id: "WL Bignay", name: "WL Bignay", lat: 14.747861, lng: 121.00390, radius: 50 },
  { id: "Labella Villa Homes", name: "Labella Villa Homes", lat: 14.74117 , lng: 120.98624, radius: 50 },
  { id: "Biglite Makati", name: "Biglite Makati", lat: 14.53984, lng: 121.01433, radius: 50 },
  { id: "Demo Location", name: "Demo Location", lat: 14.73263, lng: 121.00270, radius: 50 },
  { id: "Weshop Taft", name: "Weshop Taft", lat: 14.56245, lng: 120.99612, radius: 50 },
  { id: "Kai Mall", name: "Kai Mall", lat: 14.75670, lng: 121.04391, radius: 50 },
  { id: "Ellec Parada", name: "Ellec Parada", lat: 14.69564, lng: 120.99530, radius: 50 },
  { id: "Demo Location", name: "Demo Location", lat: 14.73254, lng: 121.00566, radius: 50 }
];

const map = L.map('map').setView([locations[0].lat, locations[0].lng], 13);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  maxZoom: 19,
  attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

locations.forEach(loc => {
  L.circle([loc.lat, loc.lng], {
    color: 'blue',
    fillColor: '#99ccff',
    fillOpacity: 0.3,
    radius: loc.radius
  }).addTo(map).bindPopup(loc.name);
});

const statusDiv = document.getElementById('status');
const clockInBtn = document.getElementById('clockInBtn');
const clockOutBtn = document.getElementById('clockOutBtn');
const messageDiv = document.getElementById('message');

let userPosition = null;
let isInsideGeofence = false;
let currentLocationName = "";
let userMarker = null;
let currentDate = new Date().toISOString().split('T')[0]; 

function checkGeofence(userLat, userLng) {
  let inside = false;
  let locationName = "";
  
  for (const loc of locations) {
    const distance = map.distance([userLat, userLng], [loc.lat, loc.lng]);
    if (distance <= loc.radius) {
      inside = true;
      locationName = loc.name;
      break;
    }
  }
  
  return { inside, locationName };
}

function showMessage(message, type) {
  messageDiv.textContent = message;
  messageDiv.style.display = 'block';
  messageDiv.className = type === 'success' ? 'message-success' : 'message-error';
  
  setTimeout(() => {
    messageDiv.style.display = 'none';
  }, 5000);
}

function handleAttendance(action) {
  if (!isInsideGeofence) {
    showMessage('You must be within a designated work area to clock in/out.', 'error');
    return;
  }
  
  clockInBtn.disabled = true;
  clockOutBtn.disabled = true;
  
  const data = {
    location: currentLocationName,
    latitude: userPosition.lat,
    longitude: userPosition.lng
  };
  
  // API call 
  fetch('../api/attendance_api.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(data)
  })
  .then(response => response.text())
  .then(result => {
    showMessage(result, result.includes('Error') ? 'error' : 'success');
    
    if (action === 'in' && !result.includes('Error')) {
      clockInBtn.disabled = true;
      clockOutBtn.disabled = false;
    } else if (action === 'out' && !result.includes('Error')) {
      clockInBtn.disabled = false;
      clockOutBtn.disabled = true;
    } else {
      updateButtonStates();
    }
  })
  .catch(error => {
    showMessage('Error: ' + error.message, 'error');
    updateButtonStates();
  });
}

function updateButtonStates() {
  fetch('../includes/check_status.php')
  .then(response => response.json())
  .then(data => {
    const currentDay = new Date().toISOString().split('T')[0];
    if (data.status === 'clocked-in' && currentDay === currentDate) {
      clockInBtn.disabled = true;
      clockOutBtn.disabled = false;
    } else if (data.status === 'clocked-out' && currentDay === currentDate) {
      clockInBtn.disabled = false;
      clockOutBtn.disabled = true;
    } else {
      clockInBtn.disabled = !isInsideGeofence;
      clockOutBtn.disabled = true;
    }
  })
  .catch(error => {
    console.error('Error checking status:', error);
    clockInBtn.disabled = !isInsideGeofence;
    clockOutBtn.disabled = !isInsideGeofence;
  });
}

function resetButtonStateAtMidnight() {
  const now = new Date();
  const nextMidnight = new Date();
  nextMidnight.setHours(24, 0, 0, 0);

  const timeUntilMidnight = nextMidnight - now;

  setTimeout(() => {
    currentDate = new Date().toISOString().split('T')[0]; 
    updateButtonStates(); 
    resetButtonStateAtMidnight(); 
  }, timeUntilMidnight);
}

function updateLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(position => {
      const userLat = position.coords.latitude;
      const userLng = position.coords.longitude;
    
      userPosition = { lat: userLat, lng: userLng };
      
      if (userMarker) {
        userMarker.setLatLng([userLat, userLng]);
      } else {
        userMarker = L.marker([userLat, userLng]).addTo(map);
      //userMarker.bindPopup("Your current location").openPopup();
        map.setView([userLat, userLng], 15);
      }
      
      const geofenceCheck = checkGeofence(userLat, userLng);
      isInsideGeofence = geofenceCheck.inside;
      currentLocationName = geofenceCheck.locationName;

      if (isInsideGeofence) {
        statusDiv.innerHTML = `<span class="success">You are inside ${currentLocationName}.</span>
                              <div class="location-details">Lat: ${userLat.toFixed(6)}, Lng: ${userLng.toFixed(6)}</div>`;
        statusDiv.className = 'success';
      } else {
        statusDiv.innerHTML = `<span class="error">You are outside all designated work areas.</span>
                              <div class="location-details">Lat: ${userLat.toFixed(6)}, Lng: ${userLng.toFixed(6)}</div>`;
        statusDiv.className = 'error';
      }
      
      updateButtonStates();
      
    }, error => {
      statusDiv.textContent = "Error getting location: " + error.message;
      statusDiv.className = 'error';
      
      clockInBtn.disabled = true;
      clockOutBtn.disabled = true;
    });
  } else {
    statusDiv.textContent = "Geolocation is not supported by this browser.";
    statusDiv.className = 'error';

    clockInBtn.disabled = true;
    clockOutBtn.disabled = true;
  }
}
 
clockInBtn.addEventListener('click', () => handleAttendance('in'));
clockOutBtn.addEventListener('click', () => handleAttendance('out'));

updateLocation();
resetButtonStateAtMidnight(); 
setInterval(updateLocation, 30000);
