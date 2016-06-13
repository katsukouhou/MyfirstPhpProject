<?php
/**
 * Created by PhpStorm.
 * User: gehongpeng
 * Date: 2016/06/13
 * Time: 2:41
 */

/**
 * sql_execute
 *
 * SQL処理を実施
 *
 * @param dbh $dbh
 * @param string $sql_target
 * @return $stt
 */
function sql_execute($dbh, $sql_target) {
    //プリペアドステートメントを生成
    $stt = $dbh->prepare($sql_target);
    //プリペアドステートメントを実行
    $stt->execute();
    //
    return $stt;
}

/**
 * connect
 *
 * DBを接続
 *
 * @return $dsn
 */
function db_connect() {
    /*↓↓↓ [start]本番環境用に見直す ↓↓↓*/
    //DBアクセスのパラメタを設定
    //$dsn = 'mysql:host=127.0.0.1;dbname=nex';
    $dsn = 'mysql:host=insideai-nex-db.cmgi4vqkorx6.ap-northeast-1.rds.amazonaws.com;port:3306;dbname=nex';
    $username = 'nex_master_pro';
    $password = 'fjalkjdflajfkaj';
    $options = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        //PDO::MYSQL_ATTR_SSL_CA => '/Users/gehongpeng/Downloads/accuracy_test.pem'
    );
    /*↑↑↑ [start]本番環境用に見直す ↑↑↑*/
    try {
        //DBを接続
        $dbh = new PDO($dsn, $username, $password, $options);
    } catch (PDOException $e) {
        print('DB_connecting_error:'.$e->getMessage());
        die();
    }
    return $dbh;
}


//DBを接続
$dbh = db_connect();
//処理対象クエリ文字列を作成
$sql_target = "SELECT * FROM file_parts";
// SQL処理を実行
$stt_target_list = sql_execute($dbh, $sql_target);
$query_num = $stt_target_list->rowCount();
print 'row count: ' . $query_num . "\n";


/*
$dbhost = $_SERVER['RDS_HOSTNAME'];
$dbport = $_SERVER['RDS_PORT'];
$dbname = $_SERVER['RDS_DB_NAME'];

$dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname}";
$username = $_SERVER['RDS_USERNAME'];
$password = $_SERVER['RDS_PASSWORD'];

$options = array(
  PDO::MYSQL_ATTR_SSL_CA => '/Users/gehongpeng/Downloads/accuracy_test.pem' // CA証明書の指定
);

$client = new PDO($dsn,$username,$password,$options);
*/