<?php
$connect = mysqli_connect("127.0.0.1", "root", "as2580as", "db_board") or die("connect failed");

$number = $_POST['number'];
$title = $_POST['title'];
$content = $_POST['content'];
$date = date('Y-m-d H:i:s');

if ($_FILES['fileToUpload']['error'] === 0) {
    $tmpfile = $_FILES['fileToUpload']['tmp_name'];
    $o_name = $_FILES['fileToUpload']['name'];
    $filename = iconv("UTF-8", "EUC-KR", $_FILES['fileToUpload']['name']);
    $folder = "../../upload/".$filename;

    $query = "SELECT file FROM board WHERE number = $number";
    $result = $connect->query($query);
    $row = mysqli_fetch_assoc($result);
    $old_file = $row['file'];

    move_uploaded_file($tmpfile, $folder);

    if (file_exists("../../upload/".$old_file)) {
        unlink("../../upload/".$old_file);
    }
    $query = "UPDATE board SET title='$title', content='$content', date='$date', file='$filename' WHERE number=$number";
} else {
    $query = "UPDATE board SET title='$title', content='$content', date='$date' WHERE number=$number";
}

$result = $connect->query($query);
if ($result) {
    ?>
    <script>
        alert("수정되었습니다.");
        location.replace("./read.php?number=<?= $number ?>");
    </script>
    <?php
} else {
    echo "다시 시도해주세요.";
}
?>
