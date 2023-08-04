<?php
session_start();
if (isset($_SESSION['userid']) && isset($_POST['con_num']) && isset($_POST['name']) && isset($_POST['pw']) && isset($_POST['content'])) {
    $con_num = $_POST['con_num'];
    $name = $_POST['name'];
    $pw = $_POST['pw'];
    $content = $_POST['content'];

    $connect = mysqli_connect("127.0.0.1", "root", "as2580as", "db_board") or die("connect failed");
    $query_insert_reply = "INSERT INTO reply (con_num, name, pw, content, date) VALUES ('$con_num', '$name', '$pw', '$content', NOW())";
    $result_insert_reply = $connect->query($query_insert_reply);

    header("Location: ./read.php?number=$con_num");
    exit();
}
?>
