<?php
ini_set('display_errors', 'On');  // エラーを表示させる
error_reporting(E_ALL);           // 全てのレベルのエラーを表示させる

session_start();
require_once('../funcs.php');
loginCheck();

$color = $_POST['color'];
$category1  = $_POST['category1'];
$category2  = $_POST['category2'];
$img = '';

if ($_SESSION['post']['image_data'] !== ""){
    $img = date('YmdHis'). '_'. $_SESSION['post']['file_name'];
    file_put_contents("../images/$img", $_SESSION['post']['image_data']);
}

// 簡単なバリデーション処理追加。
if (trim($color) === '' || trim($category1) === ''){
    redirect('post.php?error'); //post.phpにgetでerrorという文字を送れる
}

//2. DB接続します
$pdo = db_conn();

//３．データ登録SQL作成
$stmt = $pdo->prepare('INSERT INTO my_item_table(
                            color, category1, category2, img, date
                        )VALUES(
                            :color, :category1, :category2, :img, sysdate()
                        )');
$stmt->bindValue(':color', $color, PDO::PARAM_STR);
$stmt->bindValue(':category1', $category1, PDO::PARAM_STR);
$stmt->bindValue(':category2', $category2, PDO::PARAM_STR);
$stmt->bindValue(':img', $img, PDO::PARAM_STR);
$status = $stmt->execute(); //実行

//４．データ登録処理後
if (!$status) {
    sql_error($stmt);
} else {
    $_SESSION['post'] = [] ;
    redirect('index.php');
}
