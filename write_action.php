<?php
$connect = mysqli_connect("127.0.0.1", "root", "as2580as", "db_board") or die("connect failed");

$id = $_POST['name'];
$title = $_POST['title'];
$content = $_POST['content'];
$date = date('Y-m-d H:i:s');

$tmpfile = $_FILES['fileToUpload']['tmp_name'];
$o_name = $_FILES['fileToUpload']['name'];
$filename = $_FILES['fileToUpload']['name'];
$folder = "./upload/".$filename;
move_uploaded_file($tmpfile, $folder);

$URL = './index.php';

$query = "INSERT INTO board (number, title, content, date, hit, id, file)
    values(null, '$title', '$content', '$date', 0, '$id', '$filename')";
$result = $connect->query($query);
if($result) {
?> <script>
    alert("<?php echo "게시글이 등록되었습니다." ?>");
    location.replace("<?php echo $URL ?>");
    </script>
<?php
} else {
    echo "게시글 등록에 실패하였습니다.";
}
mysqli_close($connect);
?>
