<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_class'])) {
    $class_name = $_POST['class_name'];
    if (!empty($class_name)) {
        $sql = "INSERT INTO classes (name) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $class_name);
        $stmt->execute();
        header('Location: classes.php');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_class'])) {
    $class_id = $_POST['class_id'];
    $class_name = $_POST['class_name'];
    if (!empty($class_name)) {
        $sql = "UPDATE classes SET name = ? WHERE class_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $class_name, $class_id);
        $stmt->execute();
        header('Location: classes.php');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete'])) {
    $class_id = $_GET['delete'];
    $sql = "DELETE FROM classes WHERE class_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $class_id);
    $stmt->execute();
    header('Location: classes.php');
    exit();
}

$classes = $conn->query("SELECT * FROM classes");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Classes</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <h1>Class List</h1>
    <table>
        <tr>
            <th>Class Name</th>
            <th>Actions</th>
        </tr>
        <?php while ($class = $classes->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($class['name']) ?></td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="class_id" value="<?= $class['class_id'] ?>">
                    <input type="text" name="class_name" value="<?= htmlspecialchars($class['name']) ?>" required>
                    <button type="submit" name="edit_class" class="btn btn-secondary">Edit</button>
                </form>
                <a href="classes.php?delete=<?= $class['class_id'] ?>" onclick="return confirm('Are you sure?')"  class="btn btn-danger">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <h2>Add New Class</h2>
    <form method="POST">
        <label>Class Name:</label>
        <input type="text" name="class_name" required>
        <button type="submit" name="add_class"  class="btn btn-success">Add</button>
    </form>
</body>
</html>
