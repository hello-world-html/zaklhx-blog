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
    die("<script>alert('用户名和密码不能为空!');location.href='../plate/login/login_register.php';</script>");
}

// 清理输入数据
$username = trim($username);
$password = trim($password);

// 检查用户名是否已存在
$checkSql = "SELECT id FROM user WHERE username = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("s", $username);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    // 用户名已存在
    die("<script>alert('用户名已存在，请选择其他用户名!');location.href='../plate/login/login_register.php';</script>");
}

// 双重哈希输入的密码（与登录验证保持一致）
$hashed_password = hash('sha256', $password);
$double_hashed_password = hash('sha256', $hashed_password);

// 插入新用户
$insertSql = "INSERT INTO user (username, password) VALUES (?, ?)";
$insertStmt = $conn->prepare($insertSql);
$insertStmt->bind_param("ss", $username, $double_hashed_password);

if ($insertStmt->execute()) {
    // 注册成功
    echo "<script>alert('注册成功，请登录!');location.href='../plate/login/login_register.php';</script>";
} else {
    // 注册失败
    echo "<script>alert('注册失败，请稍后重试!');location.href='../plate/login/login_register.php';</script>";
}

// 关闭数据库连接
$checkStmt->close();
$insertStmt->close();
$conn->close();

