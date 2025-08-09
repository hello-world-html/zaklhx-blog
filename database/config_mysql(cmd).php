<?php

require_once("login_connect_mysql.php");

// 检查是否以 CLI 模式运行
if (php_sapi_name() !== 'cli') {
    die("此脚本只能通过命令行运行\n");
}

echo "开始设置数据库...\n";

try {
    // 创建数据库（如果不存在）
    $createDbSql = "CREATE DATABASE IF NOT EXISTS zakolhx_blog CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    if ($conn->query($createDbSql) === TRUE) {
        echo "数据库 zakolhx_blog 已创建或已存在\n";
    } else {
        throw new Exception("创建数据库时出错: " . $conn->error);
    }

    // 使用数据库
    $conn->select_db("zakolhx_blog");

    // 创建用户表
    $createTableSql = "CREATE TABLE IF NOT EXISTS user (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(64) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

    if ($conn->query($createTableSql) === TRUE) {
        echo "用户表已创建或已存在\n";
    } else {
        throw new Exception("创建用户表时出错: " . $conn->error);
    }

    // 插入示例用户数据（可选）
    $sampleUsers = [
        ['admin', hash('sha256', hash('sha256', 'admin123'))], // 双重哈希密码
        ['testuser', hash('sha256', hash('sha256', 'test123'))]
    ];

    foreach ($sampleUsers as $user) {
        $username = $conn->real_escape_string($user[0]);
        $password = $conn->real_escape_string($user[1]);
        
        // 检查用户是否已存在
        $checkUserSql = "SELECT id FROM user WHERE username = '$username'";
        $result = $conn->query($checkUserSql);
        
        if ($result->num_rows == 0) {
            $insertUserSql = "INSERT INTO user (username, password) VALUES ('$username', '$password')";
            if ($conn->query($insertUserSql) === TRUE) {
                echo "已添加示例用户: $username\n";
            } else {
                echo "添加示例用户 $username 时出错: " . $conn->error . "\n";
            }
        } else {
            echo "用户 $username 已存在，跳过添加\n";
        }
    }

    echo "数据库设置完成！\n";

} catch (Exception $e) {
    echo "错误: " . $e->getMessage() . "\n";
} finally {
    $conn->close();
}