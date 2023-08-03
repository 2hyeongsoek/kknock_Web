<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
</head>

<body>
    <div align='center'>
        <span>
            <p sytle="font-size: 25px;"><b>로그인</b></p>
        </span>

        <form method='post' action='login_action.php'>
            <p><b>I &nbsp;D &nbsp;</b><input name="id" type="text"></p>
            <p><b>PW &nbsp;</b><input name="pw" type="password"></p>
            <br />&nbsp;
            <input type="submit" value="로그인">&nbsp;&nbsp;
            <button id="register" onclick="location.href='./register.php'">회원가입</button>
        </form><br />
        <button id="back" onclick="location.href='./index.php'">돌아가기</button>

    </div>
</body>
</html>