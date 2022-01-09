<?php

use \LeanCloud\Engine\Cloud;

/*
 *  cloud functions and hooks on LeanCloud
 *  使用 云函数 来实现定时访问，未实现，勿用
 */
 
Cloud::define("Bing", function($params, $user) {
    //return getenv("LEANCLOUD_APP_ID");
    // 导入配置文件
    $config = include 'config.php';

    // 初始化又拍云信息
    $bucketName = $config['bucketName'];
    $operatorName = $config['operatorName'];
    $operatorPwd = $config['operatorPwd'];
    $cdnDom = $config['domainName'];
     
    // 初始化数据库信息
    $mysqlHost = $config['mysqlHost'];
    $mysqlUsername = $config['mysqlUsername'];
    $mysqlPassword = $config['mysqlPassword'];
    $mysqlDbname = $config['mysqlDbname'];
    //建立数据库连接
    //$conn1 = new mysqli($mysqlHost, $mysqlUsername, $mysqlPassword);
    $conn2 = mysqli_connect($mysqlHost, $mysqlUsername, $mysqlPassword, $mysqlDbname, $mysqlPort);
    if ($conn2->connect_error) {
        die("数据库连接失败: " . $conn2->connect_error);
        return "faile";
    } else {
        echo "数据库连接成功<br>";
        return "success";
    }
    // try {
    //   $mysqlHost = getenv('MYSQL_HOST_MYRDB');
    //   $mysqlPort = getenv('MYSQL_PORT_MYRDB');
    //   $pdo = new PDO("mysql:host=$mysqlHost:$mysqlPort;dbname=test", getenv('MYSQL_ADMIN_USER_MYRDB'), getenv('MYSQL_ADMIN_PASSWORD_MYRDB'));
    
    //   foreach($pdo->query('SELECT 1 + 1 AS solution') as $row) {
    //     print "The solution is {$row['solution']}";
    //   }
    // } catch (PDOException $e) {
    //   print $e->getMessage();
    // }
    
   
    
});

