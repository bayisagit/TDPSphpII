<?php
session_start();
include 'db_connection.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $family_id = trim($_POST['family_id']);
    $child_id = trim($_POST['child_id']);

    // Fetch user data
    $stmt = $conn->prepare("SELECT user_id, password FROM users WHERE email = ? AND role = 'parent'");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['email'] = $email;
            $_SESSION['role'] = "parent";
            $_SESSION['success'] = "Login successful!";

            // Redirect to student information page
            header("Location: ..familypage.family_dashboard.php");
            exit();
        } else {
            $_SESSION['error'] = "Incorrect password!";
        }
    } else {
        $_SESSION['error'] = "Family ID or Email not found!";
    }

    $stmt->close();
    $conn->close();
    header("Location: login.html");
    exit();
}
?>
