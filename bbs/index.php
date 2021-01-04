<?php
///////  タイムゾーン設定  ///////
date_default_timezone_set('Asia/Tokyo');
$page_name = "案件一覧";

?>

<!------   HTML 開始   ------>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <!-- 基本のCSS -->
    <link rel="stylesheet" href="./css/common.css">
    <title>
        <?php echo "パーソル案件閲覧クン | " . $page_name ?>
    </title>
</head>

<!-- ページ開始 -->

<body>

    <?php
    /// ヘッダーを表示する
    require './parts/header.php';
    ?>

    <!-- ページ見出し開始 -->
    <div id="page_header_wrapper">
        <div id="page_header_container">
            <h2 id="page_header_title"><?php echo $page_name ?></h2>
        </div>
    </div>

    <!-- メインコンテンツ開始 -->
    <div id="main_wrapper">

        <?php
        require "./view/list.php";
        ?>

    </div>
    <!-- メインコンテンツ終了 -->

    <?php
    /// フッターを表示する
    require './parts/footer.php';
    ?>

</body>

</html>
<!------   HTML 開始   ------>