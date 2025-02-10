<form method="POST" action="tasks.php">
    <div class="form-group">
        <label for="user_id">Assign to:</label>
        <select class="form-control" name="user_id">
            <?php
            $employees = $con->query("SELECT * FROM users")->fetchAll();
            foreach ($employees as $employee) {
                echo "<option value='{$employee['user_id']}'>{$employee['full_name']} ({$employee['username']})</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="task_description">Task:</label>
        <textarea class="form-control" name="task_description" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Assign Task</button>
</form>

<?php

     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $task_description = $_POST['task_description'];

    $stmt = $con->prepare("INSERT INTO tasks (user_id, task_description) VALUES (?, ?)");
    $stmt->execute([$user_id, $task_description]);

    echo "<script>alert('Task assigned successfully!'); window.location.href='tasks.php';</script>";
}                

function logAction($user_id, $action) {
    global $con;
    $stmt = $con->prepare("INSERT INTO logs (user_id, action) VALUES (?, ?)");
    $stmt->execute([$user_id, $action]);
}
logAction($user_id, "Assigned task: $task_description");
logAction($_SESSION['user_id'], "Updated user {$user_name}");

                                    ?> 