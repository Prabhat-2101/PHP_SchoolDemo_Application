<?php
include 'db_connection.php';

$id = $_GET['id'];

$sql = "SELECT * FROM student WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();

$classes = $conn->query("SELECT class_id, name FROM classes");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];
    $image = $_FILES['image'];

    if (!empty($name)) {
        if ($image['name']) { 
            if (in_array($image['type'], ['image/jpeg', 'image/png'])) {
                $imagePath = 'uploads/' . uniqid() . '-' . basename($image['name']);
                move_uploaded_file($image['tmp_name'], $imagePath);
                unlink($student['image']); 
            }
        } else {
            $imagePath = $student['image'];
        }

        $sql = "UPDATE student SET name = ?, email = ?, address = ?, class_id = ?, image = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssdsi', $name, $email, $address, $class_id, $imagePath, $id);
        $stmt->execute();

        header('Location: index.php');
        exit();
    } else {
        echo "Name cannot be empty.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        body{
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            width: 100vw;
        }
        form{
            width: 30%;
            height: 50%;
        }
    </style>
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
        <label>Name:</label>
        <input type="text"  class="form-control" name="name" value="<?= htmlspecialchars($student['name']) ?>" required> </div>
        <div class="form-group">
        <label>Email:</label>
        <input type="email"  class="form-control" name="email" value="<?= htmlspecialchars($student['email']) ?>" required></div>
        <div class="form-group">
        <label>Address:</label>
        <textarea name="address"  class="form-control"><?= htmlspecialchars($student['address']) ?></textarea></div>
        <div class="form-group">
        <label>Class:</label>
        <select name="class_id"  class="form-control">
            <?php while ($class = $classes->fetch_assoc()): ?>
            <option value="<?= $class['class_id'] ?>" <?= $class['class_id'] == $student['class_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($class['name']) ?>
            </option>
            <?php endwhile; ?>
        </select></div>
        <div class="form-group">
        <label>Image:</label>
        <input type="file"  class="form-control" name="image"><br>
        <img src="<?= htmlspecialchars($student['image']) ?>" alt="Current Image" width="50"></div>
        <button type="submit">Update Student</button>
    </form>
</body>
</html>
