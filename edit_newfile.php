<?php
$connect = mysqli_connect("127.0.0.1", "root", "as2580as", "db_board") or die("데이터베이스 연결에 실패했습니다.");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reply_id = $_POST['reply_id'];
    $name = $_POST['name'];
    $pw = $_POST['pw'];
    $content = $_POST['content'];
    $update_query = "UPDATE reply SET name='$name', pw='$pw', content='$content' WHERE idx='$reply_id'";
    $result = $connect->query($update_query);

    if ($result) {
        header("Location: post_page.php?number=" . $con_num);
    } else {
        echo "댓글 수정에 실패했습니다.";
    }
}
?>
