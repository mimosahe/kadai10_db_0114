<?php
session_start();
require_once('../funcs.php');
require_once('../common/header.php');
require_once('../common/head_parts.php');
loginCheck();

$id = $_GET['id'];
$pdo = db_conn();

//２．データ登録SQL作成
$stmt = $pdo->prepare('SELECT * FROM my_item_table WHERE id=:id');
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

//３．データ表示
if ($status == false) {
    sql_error($stmt);
} else {
    $row = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <?= head_parts('内容更新') ?>
</head>
<body>
    <?= $header ?>
    <?php if (isset($_GET['error'])): ?>
        <p class="text-danger">登録内容を確認してください</p>
    <?php endif;?>
    <form method="POST" action="update.php" enctype="multipart/form-data" class="mb-5">
        <?php if ($image_data) :?>
            <div class="mb-5">
                <img src="image.php">
            </div>
        <?php endif; ?>

        <div class="mb-5">
            <label for="color" class="form-label">カラー</label>
            <input type="text" class="form-control" name="color" id="color" aria-describedby="color" value="<?= $row["color"] ?>">
        </div>

        <div class="mb-5">
            <label for="category1" class="form-label">カテゴリ1</label>
            <input type="text" class="form-control" name="category1" id="category1" aria-describedby="category1" value="<?= $row["category1"] ?>">
        </div>
        
        <div class="mb-5">
            <label for="category2" class="form-label">カテゴリ2</label>
            <input type="text" class="form-control" name="category2" id="category2" aria-describedby="category2" value="<?= $row["category2"] ?>">
        </div>

        <input type="hidden" name="id" id="id" aria-describedby="id" value="<?= $row["id"] ?>">
        <button type="submit" class="btn btn-primary">修正</button>
    </form>
    <form method="POST" action="delete.php?id=<?= $row['id'] ?>" class="mb-3">
        <button type="submit" class="btn btn-danger">削除</button>
    </form>
</body>

</html>
