<?php

// start the session with a persistent cookie of 1 year
$lifetime = 60 * 60 * 24 * 365;             // 1 year in seconds
session_set_cookie_params($lifetime, '/');
session_start();
if (!isset($_SESSION['tasklistnames'])) {
    $_SESSION['tasklistnames'] = array();
}
if (!isset($_SESSION['tasklist'])) {
    $_SESSION['tasklist'] = array();
}

$action = filter_input(INPUT_POST, 'action');
$errors = array();

switch($action) {
    case 'Clear All':
        break;
    case 'Add Task':
        $new_task = filter_input(INPUT_POST, 'newtask');
        if (empty($new_task)) {
            $errors[] = 'The new task cannot be empty.';
        } else {
            $_SESSION['tasklist'][] = $new_task;
        }
        break;
    case 'Delete Task':
        $task_index = filter_input(INPUT_POST, 'taskid', FILTER_VALIDATE_INT);
        if ($task_index === NULL || $task_index === FALSE) {
            $errors[] = 'The task cannot be deleted.';
        } else {
            unset($_SESSION['tasklist'][$task_index]);
            $_SESSION['tasklist'] = array_values($_SESSION['tasklist']);
        }
        break;
    case 'Add List':
        break;
    case 'Select List':
        break;
}

// setup variables for view
$task_list_names = array();
$task_list = array();
if (isset($_SESSION['tasklistnames'])) {
    $task_list_names = $_SESSION['tasklistnames'];
}
if (isset($_SESSION['tasklist'])) {
    $task_list = $_SESSION['tasklist'];
} 
include('task_list.php');
?>