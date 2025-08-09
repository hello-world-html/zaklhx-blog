<?php

header('Content-Type: text/html; charset=utf-8');

// 包含数据库连接文件
require_once("login_connect_mysql.php");

// 检查是否是POST请求
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("<script>alert('无效的请求!');location.href='../plate/login/login_register.php';</script>");
}

// 使用 filter_input 函数进行输入验证
$username = filter_input(INPUT_POST, "username", FILTER_UNSAFE_RAW);
$password = filter_input(INPUT_POST, "password", FILTER_UNSAFE_RAW);

// 检查输入是否为空
if (empty($username) || empty($password)) {
    die("<script>alert('用户名和密码不能为空!');location.href='../index.php';</script>");
}

// 清理输入数据
$username = trim($username);
$password = trim($password);

// 双重哈希输入的密码
$hashed_password = hash('sha256', $password);
$double_hashed_password = hash('sha256', $hashed_password);

// 使用预处理语句防止SQL注入
$sql = "SELECT * FROM user WHERE username = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $double_hashed_password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    // 登录成功
    session_start();
    $user = $result->fetch_assoc();
    // 获取用户名，记录到
    $_SESSION['logged_in'] = $user['username'].",".$user['password'];
    // $_SESSION["logged_in"] = $user[''];
    // 我自己写的时候都没绷住 D:
    setcookie("login", "HACKER IS SB", [
        'expires' => time() + 3600,
        'path' => '/',
        'secure' => isset($_SERVER['HTTPS']),
        'httponly' => true,
        'samesite' => 'Strict'
    ]);
    // echo $user['username']."|";
    header("Location:../index.php");
    exit();
} else {
    // 登录失败
    echo "<script>alert('登录失败!');location.href='../index.php';</script>";
}

// 关闭数据库连接
$stmt->close();
$conn->close();