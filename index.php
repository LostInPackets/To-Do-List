<?php
// File to store tasks
$file = "tasks.txt";

// Add a task
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task'])) {
    $task = trim($_POST['task']);
    if (!empty($task)) {
        file_put_contents($file, $task . PHP_EOL, FILE_APPEND);
    }
}

// Delete a task
if (isset($_GET['delete'])) {
    $tasks = file($file, FILE_IGNORE_NEW_LINES);
    unset($tasks[$_GET['delete']]);
    file_put_contents($file, implode(PHP_EOL, $tasks) . PHP_EOL);
}

// Load tasks
$tasks = file_exists($file) ? file($file, FILE_IGNORE_NEW_LINES) : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>To-Do List</h1>
    <form method="POST">
        <input type="text" name="task" placeholder="Enter a new task" required>
        <button type="submit">Add Task</button>
    </form>

    <ul>
        <?php foreach ($tasks as $index => $task): ?>
            <li>
                <?= htmlspecialchars($task) ?>
                <a href="?delete=<?= $index ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
