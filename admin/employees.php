<?php
include '../includes/isset.php';
include '../conn.php';

$departments = [];
$dept_sql = "SELECT department FROM dbl_employees_dept";  
$dept_result = $conn->query($dept_sql);
while ($row = $dept_result->fetch_assoc()) {
    $departments[] = $row['department'];
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
    <link rel="stylesheet" href="../public/css/activeemployee.css">
    <script type="text/javascript" src="../public/js/darkmode.js" defer></script>
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
        <li>
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
             <li class="active">
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
    include '../conn.php';

    $sql = "SELECT id, employee_id, username, email, full_name, role, status, created_at FROM dbl_employees_acc";
    $result = $conn->query($sql);
    
    ?>
    
    <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
    <script>
      window.addEventListener('DOMContentLoaded', function() {
        showToast('Employee inactivated successfully!');
      });
    </script>
    <?php endif; ?>  
    <?php if (isset($_GET['status']) && $_GET['status'] == 'edited'): ?>
<script>
  window.addEventListener('DOMContentLoaded', function() {
    showToast('Employee updated successfully!');
  });
</script>
<?php endif; ?>

    <br>
    <button id="openModalBtn" class="add-btn">Add Employee</button>
      <table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Employee ID</th>
      <th>Username</th>
      <th>Email</th>
      <th>Full Name</th>
      <th>Role</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($result && $result->num_rows > 0): ?>
      <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td data-label="ID"><?= htmlspecialchars($row["id"]) ?></td>
          <td data-label="Employee ID"><?= htmlspecialchars($row["employee_id"]) ?></td>
          <td data-label="Username"><?= htmlspecialchars($row["username"]) ?></td>
          <td data-label="Email"><?= htmlspecialchars($row["email"]) ?></td>
          <td data-label="Full Name"><?= htmlspecialchars($row["full_name"]) ?></td>
          <td data-label="Role"><?= htmlspecialchars($row["role"]) ?></td>
          <td data-label="Status">
            <span class="<?= strtolower($row['status']) == 'active' ? 'status-active' : 'status-inactive' ?>">
              <?= ucfirst(strtolower($row['status'])) ?>
            </span>
          </td>
          <td data-label="Action">
          <button class="btn-edit" onclick="editEmployee(<?= $row['id'] ?>)">Edit</button>
          <?php if (strtolower($row['status']) == 'active'): ?>
            <button class="btn-deactivate" onclick="openModal(<?= $row['id'] ?>)">Deactivate</button>
          <?php else: ?>
            <form method="POST" action="../includes/activate_employee.php" style="display:inline;">
              <input type="hidden" name="id" value="<?= $row['id'] ?>">
              <button type="submit" class="btn-activate">Activate</button>
            </form>
          <?php endif; ?>
        </td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="8">No employees found.</td></tr>
    <?php endif; ?>
  </tbody>
</table>
</main>

    <!-- Modal -->
    <div id="confirmModal" class="modal">
      <div class="modal-content">
        <p>Are you sure you want to inactivate this employee?</p>
        <div class="modal-buttons">
          <form id="inactivateForm" method="POST" action="../includes/deactivate_employee.php">
            <input type="hidden" name="id" id="employeeId">
            <button type="submit" class="confirm-btn">Yes</button>
            <button type="button" onclick="closeModal()" class="cancel-btn">No</button>
          </form>
        </div>
      </div>
    </div>


<!-- Add Employee Modal -->
<div id="employeeModal" class="modal">
  <div class="modal-content">
    <span class="close" id="closeModalBtn">&times;</span>
    <h2 style="margin-bottom: 18px; color: #2d3436;">Add New Employee</h2>
    <form method="POST" action="../includes/admin_add_employee.php" autocomplete="off">
      <label for="full_name">Full Name:</label>
      <input type="text" name="full_name" placeholder="Enter full name" required>

      <label for="username">Username:</label>
      <input type="text" name="username" placeholder="Enter username" required>

      <label for="email">Email:</label>
      <input type="email" name="email" placeholder="Enter email address" required>

      <label for="password">Password:</label>
      <input type="password" name="password" placeholder="Enter password" required>

      <label for="department">Department:</label>
      <select name="department" required>
        <option value="">Select department</option>
        <?php foreach ($departments as $dept): ?>
          <option value="<?= htmlspecialchars($dept) ?>"><?= htmlspecialchars($dept) ?></option>
        <?php endforeach; ?>
      </select>

      <button type="submit" class="modal-submit-btn">Add Employee</button>
    </form>
  </div>
</div>

<!-- Edit Employee Modal -->
<div id="editModal" class="modal" style="display:none;">
  <div class="modal-content">
    <span class="close" onclick="closeEditModal()">&times;</span>
    <h2>Edit Employee</h2>
    <form id="editEmployeeForm" method="POST" action="../includes/edit_employee.php">
      <input type="hidden" name="id" id="edit-id">

      <label for="edit-employee-id">Employee ID:</label>
      <input type="text" name="employee_id" id="edit-employee-id" required>

      <label for="edit-username">Username:</label>
      <input type="text" name="username" id="edit-username" required>

      <label for="edit-email">Email:</label>
      <input type="email" name="email" id="edit-email" required>

      <label for="edit-full-name">Full Name:</label>
      <input type="text" name="full_name" id="edit-full-name" required>

      <label for="edit-department">Department:</label>
      <select name="department" required>
        <option value="">Select department</option>
        <?php foreach ($departments as $dept): ?>
          <option value="<?= $dept ?>"><?= $dept ?></option>
        <?php endforeach; ?>
      </select>

      <button type="submit" class="btn-save">Save Changes</button>
    </form>
  </div>
</div>

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

    <script>
    function openModal(id) {
      document.getElementById('employeeId').value = id;
      document.getElementById('confirmModal').style.display = 'block';
    }

    function closeModal() {
      document.getElementById('confirmModal').style.display = 'none';
    }

    window.onclick = function(event) {
      var modal = document.getElementById('confirmModal');
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
    </script>
    
    <!-- Toast container -->
        <div id="toast" style="visibility:hidden; min-width:250px; margin-left:-125px; background-color:green; color:#fff; text-align:center; border-radius:2px; padding:16px; position:fixed; z-index:1; left:50%; bottom:30px; font-size:17px;">
        </div>  

        <script>
        function showToast(message) {
          var toast = document.getElementById("toast");
          toast.textContent = message;
          toast.style.visibility = "visible";
          setTimeout(function(){ toast.style.visibility = "hidden"; }, 3000);
        }
        </script>

    <?php
    $conn->close();
    ?>

  </main>
</body>
<script> 
 const openBtn = document.getElementById('openModalBtn');
  const closeBtn = document.getElementById('closeModalBtn');
  const modal = document.getElementById('employeeModal');

  openBtn.onclick = function () {
    modal.style.display = "block";
  }

  closeBtn.onclick = function () {
    modal.style.display = "none";
  }

  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
</script>
<script>
function editEmployee(id) {
  const row = document.querySelector(`button.btn-edit[onclick="editEmployee(${id})"]`).closest('tr');


  document.getElementById('edit-id').value = id;
  document.getElementById('edit-employee-id').value = row.querySelector('td[data-label="Employee ID"]').textContent.trim();
  document.getElementById('edit-username').value = row.querySelector('td[data-label="Username"]').textContent.trim();
  document.getElementById('edit-email').value = row.querySelector('td[data-label="Email"]').textContent.trim();
  document.getElementById('edit-full-name').value = row.querySelector('td[data-label="Full Name"]').textContent.trim();
document.getElementById('edit-department').value = row.querySelector('td[data-label="Department"]').textContent.trim();


 
  document.getElementById('editModal').style.display = 'block';
}

function closeEditModal() {
  document.getElementById('editModal').style.display = 'none';
}


window.addEventListener('click', function(e) {
  const modal = document.getElementById('editModal');
  if (e.target == modal) {
    modal.style.display = 'none';
  }
});
</script>
<script src="../public/js/main.js"></script>
   </body>
</html>