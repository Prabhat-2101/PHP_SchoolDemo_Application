<?php
include 'db_connection.php';

$id = $_GET['id'];
$sql = "SELECT students.name, students.email, students.address, students.image, students.created_at, classes.name AS class_name
        FROM student as students
        JOIN classes ON students.class_id = classes.class_id
        WHERE students.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Student</title>
</head>
<body>
    <h1><?= htmlspecialchars($result['name']) ?></h1>
    <p>Email: <?= htmlspecialchars($result['email']) ?></p>
    <p>Address: <?= htmlspecialchars($result['address']) ?></p>
    <p>Class: <?= htmlspecialchars($result['class_name']) ?></p>
    <p>Created At: <?= htmlspecialchars($result['created_at']) ?></p>
    <img src="<?= htmlspecialchars($result['image']) ?>" alt="Image">
</body>
</html>
