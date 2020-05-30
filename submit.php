<?php

function verify_validity($post, &$reason) {
    $username = $post["username"];
    $password = $post["password"];
    $verified = $password == $post["password_verification"];
    $gender = $post["gender"];
    $age = $post["age"];
    $education_level = $post["education_level"];
    $email = $post["mail"];
    $hobbies = $post["hobbies"];
    $introduction = $post["introduction"];
    
    mb_internal_encoding("UTF-8");
    mb_regex_encoding("UTF-8");
    
    $valid = true;
    $valid &= strlen($username) >= 6 && strlen($username) <= 18;
    $valid &= preg_match("/[^A-Za-z\\d_一-鿿]/", $username, $matches) != 1;
    if (!$valid) { $reason = "用户名必须在 6 位到 18 位之间，并且只能为英文、下划线以及中文字符"; return false; }

    $valid &= $verified;
    if (!$valid) { $reason = "两次密码不匹配"; return false; }

    $valid &= preg_match("/[A-Z]/", $password) == 1;
    $valid &= preg_match("/[a-z]/", $password) == 1;
    $valid &= preg_match("/\d/", $password) == 1;
    $valid &= preg_match("/[~!@#$%^&*()_+-=\[\]{}|;:'\",<.>\/\\\\\\\?]/", $password) == 1;
    $words = explode(" ", $username);
    for ($i = 0; $i < count($words); $i++) {
        if (strpos($password, $words[$i]) !== false) {
            $valid = false;
            break;
        }
    }
    if (!$valid) { $reason = "密码必须包含大小写字母，数字和特殊符号，大于 8 个字符并且不能包含全部或部分用户名"; return false; }

    if ($age != null) {
        $valid &= +$age >= 0 && +$age <= 150;
        if (!$valid) { $reason = "年龄必须介乎于 0 岁和 150 岁之间"; return false; }
    }

    $valid &= $education_level != "-- 选择 --";
    if (!$valid) { $reason = "未选择学历"; return false; }

    if ($email != null) {
        $valid &= preg_match("/[a-zA-z\d_]+@(.+)(?=cn|com|com.cn|net)/", $email);
        if (!$valid) { $reason = "邮箱不合法：用户名只能包含英文，数字和下划线，域名只能为 .cn, .com, .com.cn 以及 .net"; return false; }
    }

    $valid &= strlen($introduction) >= 10;
    if (!$valid) { $reason = "个人介绍至少需要 10 个字符"; return false; }
    return $valid;
}

$reason = "";
$validity = verify_validity($_POST, $reason);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>注册结果</title>
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
            width: 100vw;
            height: 100vh;
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
            <?php if ($validity): ?>
                <h2 style="color: #129832;">注册成功！</h2>
            <?php else: ?>
                <h2 style="color: #ff3764; margin-bottom: 1em;">注册失败</h2>
                <p style="color: black; font-weight: bolder; width: 40%;"><?php echo $reason ?></p>
                <a class="button" href="form.html">返回</a>
            <?php endif ?>
        </div>
    </div>
</body>
</html>
