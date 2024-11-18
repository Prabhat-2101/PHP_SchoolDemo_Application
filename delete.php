<?php
include 'db_connection.php';

$id = $_GET['id'];

$sql = "SELECT image FROM student WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    unlink($student['image']); 
    $sql = "DELETE FROM student WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();

    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Student</title>
</head>
<body>
    <h1>Are you sure you want to delete this student?</h1>
    <form method="POST">
        <button type="submit">Yes, Delete</button>
        <a href="index.php">Cancel</a>
    </form>
</body>
</html>
