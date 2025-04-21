<?php
// Database connection details
$host = "localhost";
$db = "airline_booking";
$user = "root";
$pass = ""; // use your own password

// Connect to MySQL
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Collect form data
$full_name = $_POST['name'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$from_city = $_POST['from'];
$to_city = $_POST['to'];
$travel_date = $_POST['travel_date'];
$travel_time = $_POST['time'];
$flight_name = $_POST['flight_id'];
$travel_class = $_POST['travel_class'];


// Prevent booking same city
if (strtolower($from_city) === strtolower($to_city)) {
    die("❌ 'From' and 'To' cities cannot be the same.");
}

// Prepare and execute SQL insert
$stmt = $conn->prepare("INSERT INTO bookings 
(full_name, email, mobile, from_city, to_city, travel_date, travel_time, flight_name, travel_class) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("sssssssss", 
    $full_name, $email, $mobile, $from_city, $to_city, 
    $travel_date, $travel_time, $flight_name, $travel_class
);

if ($stmt->execute()) {
    echo "✅ Booking successful!";
} else {
    echo "❌ Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
