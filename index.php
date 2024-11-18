<?php
include 'db_connection.php';
$sql = "SELECT students.id, students.name, students.email, students.created_at, classes.name AS class_name, students.image
        FROM student students
        JOIN classes ON students.class_id = classes.class_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Index Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <h1>Students List</h1>
    <table class="table">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Class Name</th>
            <th scope="col">Created At</th>
            <th scope="col">Profile Image</th>
            <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <th scope='row'><?= $row['id'] ?></th>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['class_name']) ?></td>
                <td><?= htmlspecialchars($row['created_at']) ?></td>
                <td><img src="<?= htmlspecialchars($row['image']) ?>" alt="Thumbnail" width="50"></td>
                <td>
                    <a href="view.php?id=<?= $row['id'] ?>">View</a> | 
                    <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> | 
                    <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure ?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <a href="create.php">Add Student</a>
</body>
</html>
