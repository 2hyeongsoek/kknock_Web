<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>

    <style>
        .read_table {
            border: 1px solid #444444;
            margin-top: 30px;
        }

        .read_title {
            height: 45px;
            font-size: 23.5pxs;
            text-align: center;
            background-color: #3C3C3C;
            color: white;
            width: 1000px;
        }

        .read_id {
            text-align: center;
            background-color: #EEEEEE;
            width: 30px;
            height: 33px;
        }

        .read_id2 {
            background-color: white;
            width: 60px;
            height: 33px;
            padding-left: 10px;
        }

        .read_hit {
            background-color: #EEEEEE;
            width: 30px;
            text-align: center;
            height: 33px;
        }

        .read_hit2 {
            background-color: white;
            width: 60px;
            height: 33px;
            padding-left: 10px;
        }

        .read_content {
            padding: 20px;
            border-top: 1px solid #444444;
            height: 500px;
        }

        .read_btn {
            width: 700px;
            height: 200px;
            text-align: center;
            margin: auto;
            margin-top: 50px;
        }

        .read_btn1 {
            height: 45px;
            width: 90px;
            font-size: 20px;
            text-align: center;
            background-color: solid black;
            border: 2px white;
            border-radius: 10px;
        }

        .read_comment_input {
            width: 700px;
            height: 500px;
            text-align: center;
            margin: auto;
        }

        .read_text3 {
            font-weight: bold;
            float: left;
            margin-left: 20px;
        }

        .read_com_id {
            width: 100px;
        }

        .read_comment {
            width: 500px;
        }
    </style>
</head>

<body>
    <?php
    $connect = mysqli_connect("127.0.0.1", "root", "as2580as", "db_board") or die("connect failed");
    $number = $_GET['number'];
    session_start();
    $query = "select title, content, date, hit, id, file from board where number = $number";
    $result = $connect->query($query);
    $rows = mysqli_fetch_assoc($result);

    $hit = "update board set hit = hit + 1 where number = $number";
    $connect->query($hit);

    if(isset($_SESSION['userid'])) {
    ?><b><?php echo $_SESSION['userid']; ?></b>님 반갑습니다.
        <button onclick="location.href='./logout_action.php'" style="float:right; font-size:15.5px;">로그아웃</button>
        <br />
    <?php
    }
    else {
    ?>
        <button onclick="location.href='./login.php'" style="float:right; font-size:15.5px;">로그인</button>
        <br />
    <?php
    }
    ?>

    <table class="read_table" align=center>
        <tr>
            <td colspan="4" class="read_title"><?php echo $rows['title'] ?></td>
        </tr>
        <tr>
            <td class="read_id">작성자</td>
            <td class="read_id2"><?php echo $rows['id']?></td>
            <td class="read_hit">조회수</td>
            <td class="read_hit2"><?php echo $rows['hit'] + 1 ?></td>
        </tr>
            <td><a href="../../upload/<?php echo $rows['file'];?>" download><?php echo $rows['file']; ?></a></td>
        <tr>

        </tr>

        <tr>
            <td colspan="4" class="read_content" valign="top">
                <?php echo $rows['content'] ?>
            </td>
        </tr>
    </table>

    <div class="read_btn">
        <button class="read_btn1" onclick="location.href='./index.php'">목록</button>&nbsp;&nbsp;
        <?php
        if (isset($_SESSION['userid']) and $_SESSION['userid'] == $rows['id']) { ?>
            <button class="read_btn1" onclick="location.href='./modify.php?number=<?= $number ?>'">수정</button>&nbsp;&nbsp;
            <button class="read_btn1" a onclick="ask();">삭제</button>
            <script>
                function ask() {
                    if (confirm("게시글을 삭제하시겠습니까?")) {
                        window.location = "./delete.php?number=<?= $number ?>"
                    }
                }         
            </script>
        <?php } ?>
    </div>

    <h3>댓글 작성</h3>
    <?php
    if (isset($_SESSION['userid'])) {
    $username = $_SESSION['userid'];
    ?>
    <form method="POST" action="./add_reply.php">
        <input type="hidden" name="con_num" value="<?= $number ?>">
        <input type="hidden" name="name" value="<?= $username ?>">
        <input type="hidden" name="pw" value="hidden_password_field">
        <textarea name="content" placeholder="댓글 내용을 입력해주세요"></textarea>
        <input type="submit" value="댓글 작성">
    </form>
    <?php
}
?>
    <h3>댓글</h3>
    <?php
        $query_reply = "SELECT * FROM reply WHERE con_num = $number";
        $result_reply = $connect->query($query_reply);  
        while ($row_reply = mysqli_fetch_assoc($result_reply)) {
            $comment_date = $row_reply['date'];
            $comment_id = $row_reply['idx'];
            echo '<p><b>' . $row_reply['name'] . ':</b> ' . $row_reply['content'] . ' (' . $comment_date . ')';
        if (isset($_SESSION['userid']) && $_SESSION['userid'] === $row_reply['name']) {
            echo ' <a href="./edit_reply.php?comment_id=' . $comment_id . '">[수정]</a>';
            echo ' <a href="./delete_reply.php?comment_id=' . $comment_id . '">[삭제]</a>';
        }
    echo '</p>';
}
?>
</body>
</html>
