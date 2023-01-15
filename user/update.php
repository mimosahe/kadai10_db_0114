<?php
session_start();
require_once('../funcs.php');
loginCheck();

$id = $_POST['id'];
$color = $_POST['color'];
$category1 = $_POST['category1'];
$category2 = $_POST['category2'];
$img = '';


// imgがある場合
if (isset($_FILES['img']['name'])) {
    $fileName = $_FILES['img']['name'];
    $img = date('YmdHis') . '_' . $_FILES['img']['name'];
}


// 簡単なバリデーション処理。
if (trim($_POST['color']) === '') {
    $err[] = '内容を確認してください。';
}
if (trim($_POST['category1']) === '') {
    $err[] = '内容を確認してください';
}
if (trim($_POST['category2']) === '') {
    $err[] = '内容を確認してください';
}
if (!empty($fileName)) {
    $check =  substr($fileName, -3);
    if ($check != 'jpg' && $check != 'gif' && $check != 'png') {
        $err[] = '写真の内容を確認してください。';
    }
}

// もしerr配列に何か入っている場合はエラーなので、redirect関数でindexに戻す。その際、GETでerrを渡す。
if (isset($err) && count($err) > 0) {
    redirect('post.php?error=1');
}

/**
 * (1)$_FILES['img']['tmp_name']... 一時的にアップロードされたファイル
 * (2)'../picture/' . $image...写真を保存したい場所。先にフォルダを作成しておく。
 * (3)move_uploaded_fileで、（１）の写真を（２）に移動させる。
 */
if (isset($_FILES['img']['name'])) {
    move_uploaded_file($_FILES['img']['tmp_name'], '../images/' . $img);
}


//2. DB接続します
$pdo = db_conn();

//３．データ登録SQL作成
if (isset($_FILES['img']['name'])) {
    $stmt = $pdo->prepare('UPDATE my_item_table
                        SET
                            color = :color,
                            category1 = :category1,
                            category2 = :category2,
                            img = :img,
                            update_time = sysdate()
                        WHERE id = :id;');
    $stmt->bindValue(':color', $color, PDO::PARAM_STR);
    $stmt->bindValue(':category1', $category1, PDO::PARAM_STR);
    $stmt->bindValue(':category2', $category2, PDO::PARAM_STR);
    $stmt->bindValue(':img', $img, PDO::PARAM_STR);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
} else {
    //  画像がない場合imgは省略する。
    $stmt = $pdo->prepare('UPDATE my_item_table
                        SET
                            color = :color,
                            category1 = :category1,
                            category2 = :category2,
                            update_time = sysdate()
                        WHERE id = :id;');
    $stmt->bindValue(':color', $color, PDO::PARAM_STR);
    $stmt->bindValue(':category1', $category1, PDO::PARAM_STR);
    $stmt->bindValue(':category2', $category2, PDO::PARAM_STR);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
}

$status = $stmt->execute(); //実行

//４．データ登録処理後
if (!$status) {
    sql_error($stmt);
} else {
    redirect('index.php');
}
