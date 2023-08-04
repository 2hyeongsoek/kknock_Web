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

        form {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <?php
    $connect = mysqli_connect("localhost", "hs01", "1234", "db_board") or die("connect failed");
    $query = "select * from board order by number desc";
    $result = mysqli_query($connect, $query);
    $total = mysqli_num_rows($result);

    session_start();

    ?>
    <?php
    if (isset($_SESSION['userid'])) {
        ?><b><?php echo $_SESSION['userid']; ?></b>님 반갑습니다.
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
    
    <form method="GET" action="index.php" style="text-align: left;">
    <select name="sort">
        <option value="number_desc">번호 (내림차순)</option>
        <option value="number_asc">번호 (오름차순)</option>
        <option value="date_desc">날짜 (최신순)</option>
        <option value="date_asc">날짜 (오래된순)</option>
        <option value="hit_desc">조회수 (내림차순)</option>
        <option value="hit_asc">조회수 (오름차순)</option>
    </select>
    <input type="submit" value="정렬">
    </form>
    
    <?php
    $connect = mysqli_connect("localhost", "hs01", "1234", "db_board") or die("connect failed");
    
    if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
    switch ($sort) {
        case 'number_desc':
            $order_by = 'ORDER BY number DESC';
            break;
        case 'number_asc':
            $order_by = 'ORDER BY number ASC';
            break;
        case 'date_desc':
            $order_by = 'ORDER BY date DESC';
            break;
        case 'date_asc':
            $order_by = 'ORDER BY date ASC';
            break;
        case 'hit_desc':
            $order_by = 'ORDER BY hit DESC';
            break;
        case 'hit_asc':
            $order_by = 'ORDER BY hit ASC';
            break;
        default:
            $order_by = 'ORDER BY number DESC';
            break;
    }
    } else {
    $order_by = 'ORDER BY number DESC';
    }

$query = "SELECT * FROM board $order_by";
$result = mysqli_query($connect, $query);
$total = mysqli_num_rows($result);
?>

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
                if ($total % 2==0) {
            ?>
                    <tr class="even">
                    <?php }
                else {
                    ?>
                    <tr>
                    <?php
                }   ?>
                    <td width="50" align="center"><?php echo $total ?></td>
                    <td width="500" align="center">
                        <a href="read.php?number=<?php echo $rows['number'] ?>">
                            <?php echo $rows['title'] ?>
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
    <button onclick="location.href='./write.php'" style="font-size: 15.5px;">글쓰기</button>
</body>
<html>