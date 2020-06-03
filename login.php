<?php

$link = mysqli_connect("127.0.0.1", "root", "feck", "playground");
mysqli_set_charset($link, "UTF-8");

function query($cmd) {
    global $link;
    $result = mysqli_query($link, $cmd);
    if (!$result) {
        return mysqli_error($link);
    }
    return $result;
}

$results = query("SELECT * FROM user WHERE username='" . $_POST["username"] . "' AND password='" . $_POST["password"] . "'");
$validity = mysqli_num_rows($results);
if (!$validity) {
    $reason = "用户名或密码错误";
}

?>

<?php if ($validity): ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登录结果</title>
    <style>
        html {
            background: repeating-linear-gradient(
                -45deg,
                rgb(159, 207, 255),
                rgb(159, 207, 255) 40px,
                rgb(17, 136, 255) 40px,
                rgb(17, 136, 255) 80px
            );
        }

        * {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        .center {
            min-width: 100vw;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgb(13, 97, 252);
        }

        .container {
            padding: 4em;
            background-color: #fff;
            box-shadow: 10px 10px 0 0 #000;
        }

        .field {
            margin-top: 1em;
            position: relative;
        }

        .field:before {
            content: "*";
            color: rgba(255, 255, 255, 0.0);
            position: absolute;
            left: -0.7em;
            top: 0;
            font-weight: bolder;
            font-size: 3.0em;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .field.done:before {
            color: rgba(27, 189, 6, 0.53);
            transform: rotate(30deg);
        }

        .field.mandatory:before {
            content: "*";
            color: rgba(255, 51, 0, 0.8);
            position: absolute;
            left: -0.7em;
            top: 0;
            font-weight: bolder;
            font-size: 3.0em;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .field.mandatory.done:before {
            color: rgba(27, 189, 6, 0.993);
            transform: rotate(30deg);
        }

        label {
            display: block;
            color: #333;
            font-size: 1.0em;
            font-weight: bolder;
        }

        input {
            border: 0;
            border-radius: 0;
            font-size: 1em;
            border: 1px solid #aeaeae;
            outline: 0;
            padding: 0.2em;
            min-width: 33vw;
        }

        input:hover, input:active, textarea:hover, textarea:active, select:hover, select:active {
            border: 1px solid #777;
        }

        textarea {
            border: 0;
            border-radius: 0;
            font-size: 1em;
            border: 1px solid #aeaeae;
            outline: 0;
            padding: 0.2em;
            min-width: 33vw;
        }

        .selection {
            display: flex;
            align-items: center;
            margin-right: 1em;
        }

        .selection > input {
            min-width: unset;
            margin-right: 0.3em;
        }

        .selection > label {
            display: unset;
            font-size: 0.8em;
        }

        select {
            border: 0;
            border-radius: 0;
            font-size: 1em;
            border: 1px solid #aeaeae;
            outline: 0;
            padding: 0.2em;
            min-width: 33vw;
        }

        .checkboxes {
            display: flex;
            flex-wrap: wrap;
        }
        
        button, .button {
            border: 0;
            border-radius: 0;
            font-size: 1em;
            border: 1px solid #aeaeae;
            outline: 0;
            padding: 0.2em;
            min-width: 33vw;
            background-color: #efefef;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-decoration: none;
            color: black;
        }

        .button {
            margin-top: 1em;
            display: block;
        }

        button:hover, .button:hover {
            background-color: #eaeaea;
        }

        button:active, .button:active {
            background-color: #cdcdcd;
        }

        .disabled {
            color: #aaa;
            pointer-events: none;
        }

        .disabled:hover {
            background-color: #efefef;
        }
    </style>
</head>
<body>
    <div class="center">
        <div class="container">
            <h2 style="color: #129832;">登录成功！</h2>
        </div>
    </div>
</body>
</html>

<?php else: ?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登录</title>
    <script src="js/main.js"></script>
    <style>
        html {
            background: repeating-linear-gradient(
                -45deg,
                rgb(159, 207, 255),
                rgb(159, 207, 255) 40px,
                rgb(17, 136, 255) 40px,
                rgb(17, 136, 255) 80px
            );
        }

        * {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        .center {
            min-width: 100vw;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            color: rgb(13, 97, 252);
        }

        .container {
            padding: 4em;
            padding-top: 6em;
            background-color: #fff;
            box-shadow: 10px 10px 0 0 #000;
        }

        .field {
            margin-top: 1em;
            position: relative;
        }

        .field:before {
            content: "*";
            color: rgba(255, 255, 255, 0.0);
            position: absolute;
            left: -0.7em;
            top: 0;
            font-weight: bolder;
            font-size: 3.0em;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .field.done:before {
            color: rgba(27, 189, 6, 0.53);
            transform: rotate(30deg);
        }

        .field.mandatory:before {
            content: "*";
            color: rgba(255, 51, 0, 0.8);
            position: absolute;
            left: -0.7em;
            top: 0;
            font-weight: bolder;
            font-size: 3.0em;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .field.mandatory.done:before {
            color: rgba(27, 189, 6, 0.993);
            transform: rotate(30deg);
        }

        label {
            display: block;
            color: #333;
            font-size: 1.0em;
            font-weight: bolder;
        }

        input {
            border: 0;
            border-radius: 0;
            font-size: 1em;
            border: 1px solid #aeaeae;
            outline: 0;
            padding: 0.2em;
            min-width: 33vw;
        }

        input:hover, input:active, textarea:hover, textarea:active, select:hover, select:active {
            border: 1px solid #777;
        }

        textarea {
            border: 0;
            border-radius: 0;
            font-size: 1em;
            border: 1px solid #aeaeae;
            outline: 0;
            padding: 0.2em;
            min-width: 33vw;
        }

        .selection {
            display: flex;
            align-items: center;
            margin-right: 1em;
        }

        .selection > input {
            min-width: unset;
            margin-right: 0.3em;
        }

        .selection > label {
            display: unset;
            font-size: 0.8em;
        }

        select {
            border: 0;
            border-radius: 0;
            font-size: 1em;
            border: 1px solid #aeaeae;
            outline: 0;
            padding: 0.2em;
            min-width: 33vw;
        }

        .checkboxes {
            display: flex;
            flex-wrap: wrap;
        }
        
        button, .button {
            border: 0;
            border-radius: 0;
            font-size: 1em;
            border: 1px solid #aeaeae;
            outline: 0;
            padding: 0.2em;
            min-width: 33vw;
            background-color: #efefef;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-decoration: none;
            color: black;
        }

        .button {
            margin-top: 1em;
            display: block;
            text-align: center;
        }

        button:hover, .button:hover {
            background-color: #eaeaea;
        }

        button:active, .button:active {
            background-color: #cdcdcd;
        }

        .disabled {
            color: #aaa;
            pointer-events: none;
        }

        .disabled:hover {
            background-color: #efefef;
        }

        @keyframes casually-rotate {
            0% {
                
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>
<body>
    <div class="center">
        <div class="container">
            <h2>登录账号</h2>
            <form action="/verify.php" method="POST">
                <?php if (count($_POST) > 0): ?>
                    <div class="field">
                        登录失败：<?php echo $reason ?>。请重试。
                    </div>
                <?php endif ?>
                <div class="mandatory field">
                    <label for="username">用户名</label>
                    <input id="username" type="text" name="username">
                </div>
                <div class="mandatory field">
                    <label for="password">密码</label>
                    <input id="password" type="password" name="password">
                </div>
                <div class="field">
                    <button type="submit" id="submit" class="disabled">提交</button>
                    <button type="button" onclick="window.location.href = '/login.html'" id="reset" class="button">重置</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<?php endif ?>
