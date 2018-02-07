<?php
require_once 'MysqlSessionHandler.php';
$handler = new MysqlSessionHandler();
// クラスを設定
session_set_save_handler(
    array($handler, 'open'),
    array($handler, 'close'),
    array($handler, 'read'),
    array($handler, 'write'),
    array($handler, 'destroy'),
    array($handler, 'gc')
);
//register_shutdown_function('session_write_close');
session_start();
if(!isset($_SESSION['Auth']['User']['login_id']) || $_SESSION['Auth']['User']['login_id'] == ''){
  header('Location: http://cake.dev.jp');
  exit;
}
