<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <style>
        table {
            border-top: 1px solid #444444;
            border-collapse: collapse;
        }
        tr {
            border-bottom: 1px solid #444444;
            padding: 10px;
        }
        td {
            border-bottom: 1px solid #efefef;
            padding: 10px;
        }
        table .even {
            background: #efefef;
        }
        .text {
            text-align: center;
            padding-top: 20px;
            color: #000000
        }

        .text:hover {
            text-decoration: underline;
        }
        a:link {
            color: #57A0EE;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php
    $connect = mysqli_connect("localhost", "hs01", "1234", "db_board") or die("connect failed");   

    if (isset($_GET['keyword']) && isset($_GET['search_type'])) {
        $keyword = $_GET['keyword'];
        $search_type = $_GET['search_type'];
    
        if ($search_type === 'title') {
            $query = "SELECT * FROM board WHERE title LIKE '%$keyword%' ORDER BY number DESC";
        } elseif ($search_type === 'id') {
            $query = "SELECT * FROM board WHERE id LIKE '%$keyword%' ORDER BY number DESC";
        } else {
            $query = "SELECT * FROM board WHERE title LIKE '%$keyword%' ORDER BY number DESC";
        }
    
            $result = mysqli_query($connect, $query);
            $total = mysqli_num_rows($result);
        mysqli_close($connect);
    }
    ?>

    <div>
        <?php
        if (isset($_SESSION['userid'])) {
            ?>
            <b><?php echo $_SESSION['userid']; ?></b>님 반갑습니다.
            <button onclick="location.href='./logout_action.php'" style="float:right; font-size:15.5px;">로그아웃</button>
            <br />
            <?php
        } else {
            ?>
            <div style="padding-right:30px">
                <button onclick="location.href='./login.php'" style="float:right; font-size:15.5px;">로그인</button>
                <button onclick="location.href='./register.php'" style="float:right; font-size:15.5px;">회원가입</button>
            </div>
            <br />
            <?php
        }
        ?>
    </div>
    <p style="font-size:25px; text-align:center"><b>게시판</b></p>

    <form method="GET" action="search.php" style="text-align: right;">
        <input type="text" name="keyword" placeholder="검색어를 입력하세요">
        <select name="search_type">
            <option value="title">제목</option>
            <option value="id">작성자</option>
        </select>
        <input type="submit" value="검색">
    </form>

    <table align=center>
        <thead align="center">
            <tr>
                <td width="50" align="center">번호</td>
                <td width="500" align="center">제목</td>
                <td width="100" align="center">작성자</td>
                <td width="200" align="center">날짜</td>
                <td width="50" align="center">조회수</td>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($rows = mysqli_fetch_assoc($result)) {
                if ($total % 2 == 0) {
                    echo '<tr class="even">';
                } else {
                    echo '<tr>';
                }
                ?>
                <td width="50" align="center"><?php echo $total ?></td>
                <td width="500" align="center">
                    <a href="read.php?number=<?php echo $rows['number'] ?>">
                        <?php echo $rows['title'] ?>
                    </a>
                </td>
                <td width="100" align="center"><?php echo $rows['id'] ?></td>
                <td width="200" align="center"><?php echo $rows['date'] ?></td>
                <td width="50" align="center"><?php echo $rows['hit'] ?></td>
                </tr>
                <?php
                $total--;
            }
            ?>
        </tbody>
    </table>
    <button class="read_btn1" onclick="location.href='./index.php'">목록</button>&nbsp;&nbsp;
</body>
</html>