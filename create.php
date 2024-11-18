<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];
    $image = $_FILES['image'];

    if (!empty($name) && in_array($image['type'], ['image/jpeg', 'image/png'])) {
        $imagePath = 'uploads\\' . uniqid() . '-' . basename($image['name']);
        move_uploaded_file($image['tmp_name'], $imagePath);

        $sql = "INSERT INTO student (name, email, address, class_id, image) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssds', $name, $email, $address, $class_id, $imagePath);
        $stmt->execute();
        header('Location: index.php');
        exit();
    } else {
        echo "Invalid input.";
    }
}

$classes = $conn->query("SELECT class_id, name FROM classes");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Student</title>
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
    <form method="POST" enctype="multipart/form-data" >
        <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
        </div>
        <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
        </div>
        <div class="form-group" >
        <label for="email">Address:</label>
        <textarea name="address" style="width: 100%;"></textarea><br>
        </div>
        <div class="form-group">
        <label>Class:</label>
        <select name="class_id">
            <?php while ($class = $classes->fetch_assoc()): ?>
            <option value="<?= $class['class_id'] ?>"><?= $class['name'] ?></option>
            <?php endwhile; ?>
        </select>
        </div>
        <div class="form-group">
            <label for="image">Profile image</label>
            <input type="file" class="form-control-file" id="exampleFormControlFile1" name="image">
        </div>
        <button type="submit"  class="btn btn-primary">Add Student</button>
    </form>
</body>
</html>