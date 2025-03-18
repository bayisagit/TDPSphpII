<?php
/*
session_start();
include 'db_connection.php'; // Database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $role = trim($_POST['role']); // Role: 'admin', 'teacher', 'student', 'parent'

    // Check if any field is empty
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($confirm_password) || empty($role)) {
        $_SESSION['error'] = "All fields are required!";
        header("Location: ../homepage/signup.html");
        exit();
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format!";
        header("Location: ../homepage/signup.html");
        exit();
    }

    // Check password confirmation
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match!";
        header("Location: ../homepage/signup.html");
        exit();
    }


    // Check if email already exists
    $check_email = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $result = $check_email->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Email is already registered!";
        header("Location: ../homepage/signup.html");
        exit();
    }

    // Start transaction
    $conn->begin_transaction();

    try {
        // Insert into `users` table
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, role, status) VALUES (?, ?, ?, ?, ?, 'pending')");
        $stmt->bind_param("sssss", $first_name, $last_name, $email, $password, $role);
        if (!$stmt->execute()) {
            throw new Exception("User Insert Error: " . $stmt->error);
        }
        // Get the last inserted user_id
        $user_id = $conn->insert_id;

        // Store user_id in session to show on confirmation page
        $_SESSION['user_id'] = $user_id;

        // Insert into specific role table
        switch ($role) {
            case 'admin':
                $role_stmt = $conn->prepare("INSERT INTO admins (user_id, email, password) VALUES (?, ?, ?)");
                $role_stmt->bind_param("iss", $user_id, $email, $password);
                break;
            case 'teacher':
                $role_stmt = $conn->prepare("INSERT INTO teachers (email,password,user_id) VALUES (?, ?, ?)");
                $role_stmt->bind_param("ssi", $email, $password, $user_id);
                break;
            case 'student':
                $role_stmt = $conn->prepare("INSERT INTO students (email, password,user_id ) VALUES (?, ?, ?)");
                $role_stmt->bind_param("ssi", $email, $password, $user_id);
                break;
            case 'parent':
                $role_stmt = $conn->prepare("INSERT INTO parents (email,password, child_id, user_id) VALUES (?, ?, ?, ?)");
                $role_stmt->bind_param("ssii", $email, $password, $child_id, $user_id);
                break;
            default:
                throw new Exception("Invalid role selected.");
        }

        if (!$role_stmt->execute()) {
            throw new Exception("Role Insert Error: " . $role_stmt->error);
        }

        // Commit transaction
        $conn->commit();

        // Redirect to confirmation page showing user ID
        $_SESSION['success'] = "Signup successful! Your user ID is: " . $user_id . ". The admin will approve your account.";
        header("Location: ../homepage/login.html");
        exit();
    } catch (Exception $e) {
        // Rollback transaction on failure
        $conn->rollback();
        $_SESSION['error'] = "Signup failed. Please try again.";
        header("Location: ../homepage/signup.html");
        exit();
    } finally {
        $stmt->close();
        $role_stmt->close();
        $check_email->close();
        $conn->close();
    }
}
?> */

session_start();
include 'db_connection.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
}
// Insert data into users table (status is set by default in DB)
$sql = "INSERT INTO users (first_name, last_name, email, password, role) 
        VALUES ('$first_name', '$last_name', '$email', '$password', '$role')";

if ($conn->query($sql) === TRUE) {
    $_SESSION['success'] = "Signup successful!";
    header("Location: ../homepage/login.html");
} else {
    $_SESSION['error'] = "Signup failed: " . $conn->error;
    header("Location: ../homepage/signup.html");
}

$conn->close();
?>
