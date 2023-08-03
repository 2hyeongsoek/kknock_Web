<?php
session_start();
$connect = mysqli_connect("127.0.0.1", "root", "as2580as", "db_board") or die("connect failed");

$id = $_POST['id'];
$pw = $_POST['pw'];

$date = date('Y-m-d H:i:s');

// id 중복 확인
$query1 = "SELECT * FROM member WHERE id = '$id'";
$result1 = $connect->query($query1);
$count = mysqli_num_rows($result1);

if ($count) {
    ?>
    <script>
        alert('이미 존재하는 ID입니다.');
        history.back();
    </script>
    <?php
} else {
    $query = "INSERT INTO member (id, password, date, permit) VALUES ('$id', '$pw', '$date', 0)";
    $result = $connect->query($query);
    if ($result) {
        ?>
        <script>
            alert('회원가입에 성공하였습니다.');
            location.replace("./login.php");
        </script>
        <?php
    } else {
        ?>
        <script>
            alert("회원가입에 실패하였습니다.");
        </script>
        <?php
    }
}
mysqli_close($connect);
?>
