<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/cloud.php';

header('Content-Type: text/html;charset=utf-8');
header('Access-Control-Allow-Origin:*'); // *代表允许任何网址请求
header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); // 允许请求的类型
header('Access-Control-Allow-Credentials: true'); // 设置是否允许发送 cookies
header('Access-Control-Allow-Headers: Content-Type,Content-Length,Accept-Encoding,X-Requested-with, Origin'); // 设置允许自定义请求头的字段

use \LeanCloud\Client;
use \LeanCloud\Storage\CookieStorage;
use \LeanCloud\Query;
use \LeanCloud\LeanObject;

Client::initialize(
    getenv("LEANCLOUD_APP_ID"),
    getenv("LEANCLOUD_APP_KEY"),
    getenv("LEANCLOUD_APP_MASTER_KEY")
);

// Store sessionToken in cookies to support multiple instances sharing one session.
Client::setStorage(new CookieStorage());
Client::useProduction((getenv("LEANCLOUD_APP_ENV") === "production") ? true : false);

//获取参数
$blur = $_REQUEST['blur'];
$gray = $_REQUEST['gray'];
$day = $_REQUEST['day'];
$type = $_REQUEST['type'];
$random = $_REQUEST['random'];
$thumbnail = $_REQUEST['thumbnail'];

//引入配置文件
$config = include 'php/config.php';

//初始化配置
$cdnDom = $config['domainName'];
$delay = $config['delay'];

//初始化数据库信息
$mysqlHost = $config['mysqlHost'];
$mysqlUsername = $config['mysqlUsername'];
$mysqlPassword = $config['mysqlPassword'];
$mysqlDbname = $config['mysqlDbname'];
$mysqlPort = $config['mysqlPort'];

//建立数据库连接
$conn = mysqli_connect($mysqlHost, $mysqlUsername, $mysqlPassword, $mysqlDbname, $mysqlPort);

if ($type == "json") {

    if (!$day) {
        $dateToday = gmdate('d-M-Y', time() + 3600 * 8 - $delay);
        $dateEnd1 = $dateToday;

        // 读取数据库数据
        $sql1 = "SELECT * FROM bing_tbl WHERE submission_date='$dateEnd1'";
        $result_byDid = mysqli_query($conn, $sql1);
        $result_arr_byDid = mysqli_fetch_assoc($result_byDid);
        $return = $result_arr_byDid;
        $return = json_encode($return);
    } else {
        $dateEnd1 = gmdate('d-M-Y', time() + 3600 * 8 - $delay - ($day * 3600 * 24));

        // 读取数据库数据
        $sql1 = "SELECT * FROM bing_tbl WHERE submission_date='$dateEnd1'";
        $result_byDid = mysqli_query($conn, $sql1);
        $result_arr_byDid = mysqli_fetch_assoc($result_byDid);
        $return = $result_arr_byDid;
        $return = json_encode($return);
    }

    echo $return;
} else {

    if (!$day) {
        $dateToday = gmdate('d-M-Y', time() + 3600 * 8 - $delay);
        $dateEnd = $dateToday;
    } else {
        $dateEnd = gmdate('d-M-Y', time() + 3600 * 8 - $delay - ($day * 3600 * 24));
    }

    if ($blur) {
        if ($blur == "5") {
            $image_name = 'bing/' . $dateEnd . '/' . $dateEnd . '-gaussblur-5' . '.jpg';
        }
        if ($blur == "15") {
            $image_name = 'bing/' . $dateEnd . '/' . $dateEnd . '-gaussblur-15' . '.jpg';
        }
        if ($blur == "25") {
            $image_name = 'bing/' . $dateEnd . '/' . $dateEnd . '-gaussblur-25' . '.jpg';
        }
    } else if($thumbnail){
        if ($thumbnail == "25") {
            $image_name = 'bing/' . $dateEnd . '/' . $dateEnd . '-compress_25' . '.jpg';
        }
        if ($thumbnail == "1") {
            $image_name = 'bing/' . $dateEnd . '/' . $dateEnd . '-compress_1' . '.jpg';
        }
    } else if ($gray == "true") {
        $image_name = 'bing/' . $dateEnd . '/' . $dateEnd . '-gray' . '.jpg';
    } else {
        $image_name = 'bing/' . $dateEnd . '/' . $dateEnd . '.jpg';
    }

    $imgurl = $cdnDom . $image_name;
    header("Location: $imgurl");
}


