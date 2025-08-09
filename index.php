<?php

/**
 * Test if the current browser runs on a mobile device (smart phone, tablet, etc.)
 *
 * @staticvar bool $is_mobile
 *
 * @return bool
 */
function wp_is_mobile()
{
    static $is_mobile = null;

    if (isset($is_mobile)) {
        return $is_mobile;
    }

    if (empty($_SERVER['HTTP_USER_AGENT'])) {
        $is_mobile = false;
    } elseif (
        strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false // many mobile devices (all iPhone, iPad, etc.)
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false
    ) {
        $is_mobile = true;
    } else {
        $is_mobile = false;
    }

    return $is_mobile;
}

if (wp_is_mobile()) {
    header('Location:');
} else {
    header('Location:');
}

?>
<!DOCTYPE html>
<html lang="cn">

<head>
    <meta charset="UTF-8">
    <meta keyword="zakolhx zakolhx'swebsite zakolhx'blog" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zakolhx's blog</title>
    <link rel="stylesheet" href="./lib/css/home.index.css">
</head>

<body>
    <div class="header">
        <div class="nav">
            <a class="nav-login" href="./plate/login/login_register.php">登录</a>
            <a href="./">主页</a>
            <a href="./plate/Messages">留言</a>
            <a href="./About">关于</a>
            <a class="nav-register" href="./database/login_check.php">注册</a>
        </div>
        <div class="title">
            <h1>Zakolhx's blog</h1>
            <p>
                <?php
                $poems = [
                    "危红欲坠最高枝",
                    "未觉惊时意已迟",
                    "怯逐流波污玉魄",
                    "欲留明月照冰姿",
                    "由它怨结三生石",
                    "谢尽芳痕万点脂",
                    "唯托清风传素意",
                    "循香踏影独裁诗"
                ];
                echo $poems[array_rand($poems)];
                ?>
            </p>
        </div>
    </div>
    <div class="content">
        <div class="notice">
            <div class="dark">
                <p>
                    公告
                </p>
                <span>
                    <?php
                        $poems = [
                            "我喜欢荒原",
                            "我喜欢向光而生的脉络",
                            "我喜欢秋叶铺满赭红色石阶之上的静",
                        ];
                        echo $poems[array_rand($poems)];
                    ?>
                </span>
            </div>
            <div class="light">
                这里是lhx的小站，欢迎来玩
            </div>
        </div>
    </div>
</body>

</html>