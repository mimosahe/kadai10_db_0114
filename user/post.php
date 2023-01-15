<?php
session_start();
require_once('../funcs.php');
require_once('../common/head_parts.php');
require_once('../common/header.php');
loginCheck();

$color = '';
$category1 = '';
$category2 = '';

if (isset($_SESSION['post']['color'])){
    $color = $_SESSION['post']['color'];
}

if (isset($_SESSION['post']['category1'])){
    $category1 = $_SESSION['post']['category1'];
}

if (isset($_SESSION['post']['category2'])){
    $category2 = $_SESSION['post']['category2'];
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <?= head_parts('アイテム登録')?>
</head>

<body>
    <?= $header ?>
    <div class="album py-5 bg-light">
        <figure class="text-center">
            <h1>アイテム登録</h1>
        </figure>
    </div>
    <!-- // もしURLパラメータがある場合 -->
    <?php if (isset($_GET['error'])) : ?>
        <p class='text-danger'>記入内容を確認してください</p>
    <?php endif ?>

    <form method="POST" action="confirm.php" enctype="multipart/form-data">
        <div class="mb-5">
            <label for="img" class="form-label">画像</label>
            <input type="file" name="img">
            <div id="emailHelp" class="form-text">※登録必須</div>
        </div>
        <div class="mb-5">
            <label for="color" class="form-label">カラー</label>
            <input type="text" class="form-control" name="color" id="color" aria-describedby="color" value=<?= $color ?>>
            <div id="emailHelp" class="form-text">※入力必須</div>
        </div>
        <!-- <div class="dropdown mb-5">
            <label for="category1" class="form-label">カテゴリ1</label>
            <button class="btn btn-secondary dropdown-toggle" type="button" id="category1" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                お選びください
            </button>
            <ul class="dropdown-menu">
                <li><button class="dropdown-item" href="#">トップス</button></li>
                <li><button class="dropdown-item" href="#">ボトムス</button></li>
                <li><button class="dropdown-item" href="#">アウター</button></li>
                <li><button class="dropdown-item" href="#">靴</button></li>
                <li><button class="dropdown-item" href="#">その他小物</button></li>
            </ul>
            <div id="emailHelp" class="form-text">※入力必須</div>
        </div> -->
        <div class="mb-5">
            <label for="category1" class="form-label">カテゴリ1</label>
            <input type="text" class="form-control" name="category1" id="category1" aria-describedby="category1" value=<?= $category1 ?>>
        </div>
        <div class="mb-5">
            <label for="ccategory2" class="form-label">カテゴリ2</label>
            <input type="text" class="form-control" name="category2" id="category2" aria-describedby="category2" value=<?= $category2 ?>>
        </div>
        

        <button type="submit" class="btn btn-primary">登録</button>

        <!-- <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
        <script>
            $(function(){
                $('.dropdown-menu .dropdown-item').click(function(){
                    var visibleItem = $('.dropdown-toggle', $(this).closest('.dropdown'));
                    visibleItem.text($(this).attr('value'));
                });
            });
        </script> -->

    </form>
    



</body>
</html>
