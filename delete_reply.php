<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: ./login.php");
    exit();
}

if (!isset($_GET['comment_id'])) {
    header("Location: ./read.php?number=" . $row_comment['con_num']);
    exit();
}

$comment_id = $_GET['comment_id'];
$connect = mysqli_connect("127.0.0.1", "root", "as2580as", "db_board") or die("connect failed");
$query_get_comment = "SELECT * FROM reply WHERE idx = $comment_id";
$result_get_comment = $connect->query($query_get_comment);
$row_comment = mysqli_fetch_assoc($result_get_comment);

if ($_SESSION['userid'] !== $row_comment['name']) {
    header("Location: ./read.php?number=" . $row_comment['con_num']);
    exit();
}
$query_delete_comment = "DELETE FROM reply WHERE idx = $comment_id";
$result_delete_comment = $connect->query($query_delete_comment);

header("Location: ./read.php?number=" . $row_comment['con_num']);
exit();
?>
