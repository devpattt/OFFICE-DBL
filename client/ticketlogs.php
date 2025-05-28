<?php
include '../includes/cticketlogs.php';

if (isset($_GET['from'], $_GET['to'], $_GET['action'])) {
    $from = $_GET['from'];
    $to = $_GET['to'];
    $action = $_GET['action'];

    // Query for the date range
    $sql = "SELECT id, subject, description, submitted_by, remarks, attachment, submitted_at, status
            FROM dbl_client_tickets
            WHERE DATE(submitted_at) BETWEEN ? AND ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $from, $to);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($action === 'csv') {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename="tickets_report.csv"');
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Subject', 'Description', 'Submitted By', 'Remarks', 'Attachment', 'Submitted At', 'Status']);
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, [
                $row['id'],
                $row['subject'],
                $row['description'],
                $row['submitted_by'],
                $row['remarks'],
                $row['attachment'],
                $row['submitted_at'],
                $row['status']
            ]);
        }
        fclose($output);
        exit;
    }

    if ($action === 'excel') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="tickets_report.xls"');
        echo "ID\tSubject\tDescription\tSubmitted By\tRemarks\tAttachment\tSubmitted At\tStatus\n";
        while ($row = $result->fetch_assoc()) {
            echo "{$row['id']}\t{$row['subject']}\t{$row['description']}\t{$row['submitted_by']}\t{$row['remarks']}\t{$row['attachment']}\t{$row['submitted_at']}\t{$row['status']}\n";
        }
        exit;
    }

    if ($action === 'pdf') {
        // Use a library like FPDF or TCPDF for PDF export
        require('../vendor/fpdf.php');
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(0,10,'Tickets Report',0,1,'C');
        $pdf->SetFont('Arial','',10);
        while ($row = $result->fetch_assoc()) {
            $line = "{$row['id']} | {$row['subject']} | {$row['description']} | {$row['submitted_by']} | {$row['remarks']} | {$row['attachment']} | {$row['submitted_at']} | {$row['status']}";
            $pdf->Cell(0,8,$line,0,1);
        }
        $pdf->Output('D', 'tickets_report.pdf');
        exit;
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
    <link rel="stylesheet" href="../public/css/task.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script type="text/javascript" src="../public/js/darkmode.js" defer></script>
    <title>DBL ISTS</title>
  </head>
  <style> 
#reportForm {
  display: flex;
  align-items: center;
  gap: 10px;
  flex-wrap: wrap;
}

#reportForm label {
  font-weight: 500;
  margin-right: 4px;
}

#reportForm input[type="date"] {
  padding: 6px 10px;
  border-radius: 6px;
  border: 1px solid #ccc;
  font-size: 14px;
}

#reportForm .icon-btn {
  background-color: #f9f9f9;
  border: 1px solid #bbb;
  border-radius: 6px;
  padding: 8px 12px;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  transition: background 0.2s ease, border-color 0.2s ease, transform 0.1s ease;
}

#reportForm .icon-btn:hover {
  background-color: #e6f0ff;
  border-color: #2d7be5;
  transform: scale(1.05);
}

#reportForm .icon-btn i {
  color: #2d7be5;
  font-size: 18px;
}

#reportForm .icon-btn img {
  width: 20px;
  height: 20px;
}

@media (max-width: 600px) {
  #reportForm {
    flex-direction: column;
    align-items: flex-start;
  }
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
        <li>
          <a href="home.php">
           <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M520-640v-160q0-17 11.5-28.5T560-840h240q17 0 28.5 11.5T840-800v160q0 17-11.5 28.5T800-600H560q-17 0-28.5-11.5T520-640ZM120-480v-320q0-17 11.5-28.5T160-840h240q17 0 28.5 11.5T440-800v320q0 17-11.5 28.5T400-440H160q-17 0-28.5-11.5T120-480Zm400 320v-320q0-17 11.5-28.5T560-520h240q17 0 28.5 11.5T840-480v320q0 17-11.5 28.5T800-120H560q-17 0-28.5-11.5T520-160Zm-400 0v-160q0-17 11.5-28.5T160-360h240q17 0 28.5 11.5T440-320v160q0 17-11.5 28.5T400-120H160q-17 0-28.5-11.5T120-160Zm80-360h160v-240H200v240Zm400 320h160v-240H600v240Zm0-480h160v-80H600v80ZM200-200h160v-80H200v80Zm160-320Zm240-160Zm0 240ZM360-280Z"/></svg>
          <span>Dashboard</span>
        </a>
      </li>
       <li>
        <a href="ticketing.php">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="M280-320q17 0 28.5-11.5T320-360q0-17-11.5-28.5T280-400q-17 0-28.5 11.5T240-360q0 17 11.5 28.5T280-320Zm-40-120h80v-200h-80v200Zm160 80h320v-80H400v80Zm0-160h320v-80H400v80ZM160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h640q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H160Zm0-80h640v-480H160v480Zm0 0v-480 480Z"/></svg>
          <span>Submit Ticket</span>
        </a>
      </li>
        <li class="active">
        <a href="ticketlogs.php">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="M300-160q-58 0-99-41t-41-99q0-58 41-99t99-41h440q58 0 99 41t41 99q0 58-41 99t-99 41H300Zm0-80h440q25 0 42.5-17.5T800-300q0-25-17.5-42.5T740-360H300q-25 0-42.5 17.5T240-300q0 25 17.5 42.5T300-240Zm-80-280q-58 0-99-41t-41-99q0-58 41-99t99-41h440q58 0 99 41t41 99q0 58-41 99t-99 41H220Zm0-80h440q25 0 42.5-17.5T720-660q0-25-17.5-42.5T660-720H220q-25 0-42.5 17.5T160-660q0 25 17.5 42.5T220-600Zm300 300Zm-80-360Z"/></svg>
          <span>TIckets Logs</span>
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
        <form method="GET" id="filterForm">
            <label for="date">Select Date:</label>
            <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($selected_date); ?>" onchange="document.getElementById('filterForm').submit();">
            </select>
        </form>
                <?php
                  if ($result->num_rows > 0) {
                      echo "<table>";
                      echo "<tr>
                          <th>ID</th>
                          <th>Subject</th>
                          <th>Description</th>
                          <th>Submitted By</th>
                          <th>Remarks</th>
                          <th>Attachment</th>
                          <th>Status</th>
                          <th>Submitted At</th>
                      </tr>";
                      while($row = $result->fetch_assoc()) {
                          $status_class = strtolower(str_replace(' ', '-', $row["status"]));
                          echo "<tr class='" . htmlspecialchars($status_class) . "'>";
                          echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                          echo "<td>" . htmlspecialchars($row["subject"]) . "</td>";
                          echo "<td>" . nl2br(htmlspecialchars($row["description"])) . "</td>";
                          echo "<td>" . htmlspecialchars($row["submitted_by"]) . "</td>";
                          echo "<td>" . htmlspecialchars($row["remarks"]) . "</td>";
                          echo "<td>";
                          if ($row["attachment"]) {
                              echo "<a href='../uploads/" . urlencode($row["attachment"]) . "' target='_blank'>View</a>";
                          } else {
                              echo "-";
                          }
                          echo "</td>";
                          echo "<td><span class='" . htmlspecialchars($status_class) . "'>" . htmlspecialchars($row["status"]) . "</span></td>";
                          echo "<td>" . htmlspecialchars($row["submitted_at"]) . "</td>";
                          echo "</tr>";
                      }
                      echo "</table>";
                  } else {
                      echo "<p>No tickets found for this filter.</p>";
                  }
                  ?>
             <br>
        <h3>Generate Report</h3>
            <form method="GET" id="reportForm" style="margin-bottom:20px; display:flex; align-items:center; gap:10px;">
              <label for="from">From:</label>
              <input type="date" id="from" name="from" required>
              <label for="to">To:</label>
              <input type="date" id="to" name="to" required>
             <button type="submit" name="action" value="view" class="icon-btn" title="View">
            <i class="fas fa-eye"></i>
            </button>
            <button type="submit" name="action" value="csv" class="icon-btn" title="Export CSV">
              <i class="fas fa-file-csv"></i>
            </button>
            <button type="submit" name="action" value="excel" class="icon-btn" title="Export Excel">
              <i class="fas fa-file-excel"></i>
            </button>
            <button type="submit" name="action" value="pdf" class="icon-btn" title="Export PDF">
              <i class="fas fa-file-pdf"></i>
            </button>
            </form>
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
<script src="../public/js/main.js"></script>
</body>
</html>