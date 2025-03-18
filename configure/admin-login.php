<?php
session_start();
include 'db_connection.php'; // Make sure this file connects to your database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $id = $_POST["id"];

    // Check admin credentials
    $sql = "SELECT * FROM admin WHERE email = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $email, $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $admin = $result->fetch_assoc();

        // Check if password matches (not hashed for now)
        if ($password == $admin['password']) { 
            if ($admin['status'] == 'approved') {
                $_SESSION["admin_id"] = $admin["id"];
                $_SESSION["admin_email"] = $admin["email"];
                header("Location: ../adminpage/admin_dashboard.php"); // Redirect to admin page
                exit();
            } else {
                echo "<script>alert('Your account is not approved yet. Please wait for approval.'); window.location.href='../homepage/signup.html';</script>";
            }
        } else {
            echo "<script>alert('Incorrect password!'); window.location.href='../homepage/login.html';</script>";
        }
    } else {
        echo "<script>alert('Admin not found! Please register.'); window.location.href='../homepage/signup.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
