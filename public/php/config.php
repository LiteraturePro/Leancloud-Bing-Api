<?php

// 又拍云信息
$config['bucketName']    = getenv("bucketName");  //你的又拍云存储库
$config['operatorName']  = getenv("operatorName");  //你的存储库操作员
$config['operatorPwd']   = getenv("operatorPwd");  //你的存储库操作员密码
$config['domainName']    = getenv("domainName");  

//数据库信息
$config['mysqlHost']     = getenv("mysqlHost");  //MySQL数据库主机名
$config['mysqlUsername'] = getenv("mysqlUsername");  //MySQL数据库用户名
$config['mysqlPassword'] = getenv("mysqlPassword");  //MySQL数据库密码
$config['mysqlDbname']   = getenv("mysqlDbname");  //MySQL数据库名
$config['mysqlPort']     = getenv("mysqlPort");
//延时
$config['delay'] = 90; //默认延时90s，不建议修改

return $config;