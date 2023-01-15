<?php
// confirm.phpの中身は、ほとんどpost.phpに似ています。
session_start();
require_once('../funcs.php');
require_once('../common/header.php');
require_once('../common/head_parts.php');
loginCheck();

// post受け取る
$color = $_POST['color'];
$category1 = $_POST['category1'];
$category2 = $_POST['category2'];
$_SESSION['post']['color'] = $_POST['color'];
$_SESSION['post']['category1'] = $_POST['category1'];
$_SESSION['post']['category2'] = $_POST['category2'];

if ($_FILES['img']['name'] !== "") {
    $file_name = $_SESSION['post']['file_name'] = $_FILES['img']['name'];
    $image_data = $_SESSION['post']['image_data'] = file_get_contents($_FILES['img']['tmp_name']);
    $image_type = $_SESSION['post']['image_type'] = exif_imagetype($_FILES['img']['tmp_name']);
} else {
    $file_name = $_SESSION['post']['file_name'] = '';
    $image_data = $_SESSION['post']['image_data'] = '';
    $image_type = $_SESSION['post']['image_type'] = '';
}

// 簡単なバリデーション処理。
if (trim($color) === '' || trim($category1) === '') {
    redirect('post.php?error');
}

// imgある場合

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <?= head_parts('アイテム登録確認') ?>
</head>

<body>
    <?= $header ?>
    <!-- errorを受け取ったら、エラー文出力。 -->

    <form method="POST" action="register.php" enctype="multipart/form-data" class="mb-5">
        <?php if ($image_data) :?>
            <div class="mb-5">
                <img src="image.php">
            </div>
        <?php endif; ?>
    
        <div class="mb-5">
            <label for="color" class="form-label">カラー</label>
            <input type="hidden"name="color" value="<?= $color ?>">
            <p><?= $color ?></p>
        </div>

        <div class="mb-5">
            <label for="category1" class="form-label">カテゴリ1</label>
            <input type="hidden"name="category1" value="<?= $category1 ?>">
            <p><?= $category1 ?></p>
        </div>

        <div class="mb-5">
            <label for="category2" class="form-label">カテゴリ2</label>
            <input type="hidden"name="category2" value="<?= $category2 ?>">
            <p><?= $category2 ?></p>
        </div>

        <button type="submit" class="btn btn-primary">登録</button>
    </form>

    <a href="post.php?re-register=true">前の画面に戻る</a>
</body>
</html>