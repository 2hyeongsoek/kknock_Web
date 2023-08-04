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
$connect = mysqli_connect("localhost", "hs01", "1234", "db_board") or die("connect failed");

$query_get_comment = "SELECT * FROM reply WHERE idx = $comment_id";
$result_get_comment = $connect->query($query_get_comment);
$row_comment = mysqli_fetch_assoc($result_get_comment);

if ($_SESSION['userid'] !== $row_comment['name']) {
    header("Location: ./read.php?number=" . $row_comment['con_num']);    exit();
}

if (isset($_POST['content'])) {
    $content = $_POST['content'];
    $query_update_comment = "UPDATE reply SET content = '$content', date = NOW() WHERE idx = $comment_id";
    $result_update_comment = $connect->query($query_update_comment);
    header("Location: ./read.php?number=" . $row_comment['con_num']);
    exit();
}
?>
<h3>댓글 수정</h3>
<form method="POST" action="">
    <textarea name="content" placeholder="댓글 내용을 입력해주세요"><?= $row_comment['content'] ?></textarea>
    <input type="submit" value="댓글 수정">
</form>
