<?php

      include '../conn.php';

$totalWorkingHours = 0;
$remainingMinutes = 0;
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';

if ($username !== 'Guest' && isset($conn)) {
    try {
        $query = "SELECT time_in, time_out FROM dbl_attendance_logs 
                WHERE username = ? AND time_in IS NOT NULL AND time_out IS NOT NULL";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $totalWorkingMinutes = 0;
        
        while ($row = $result->fetch_assoc()) {
            $timeIn = DateTime::createFromFormat('l - m/d/Y - h:i A', $row['time_in']);
            if (!$timeIn) {
              
            }
            
            $timeOut = DateTime::createFromFormat('l - m/d/Y - h:i A', $row['time_out']);
            if (!$timeOut) {
                
            }
            
            if ($timeIn && $timeOut) {
                $interval = $timeIn->diff($timeOut);
                $minutesDiff = ($interval->h * 60) + $interval->i;
                
                $totalWorkingMinutes += $minutesDiff;
            }
        }
    
        $totalWorkingHours = floor($totalWorkingMinutes / 60);
        $remainingMinutes = $totalWorkingMinutes % 60;
    } catch (Exception $e) {
        $totalWorkingHours = 0;
        $remainingMinutes = 0;
    }
}
      ?>