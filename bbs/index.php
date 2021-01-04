<?php
///////  タイムゾーン設定  ///////
date_default_timezone_set('Asia/Tokyo');
/// セッションの利用 ///
@session_start();

///////  定数の読み込み  ///////
require_once "./config/properties.php";
///////  基本的な関数の読み込み  //////
require_once "./class/function.php";
///////  クラスの読み込み  ///////
require_once "./class/getDBAction.php";
/// インスタンス作成 ///
$action = new getDBAction();

/// イベントの初期化 ///
$event = null;

/// イベント取得 ///
if (isset($_POST['event_id'])) {
    $event = $_POST['event_id'];
}

///////  イベントによって処理が分岐する  ///////
$page_name = "案件一覧";
$content_page = "./view/list.php";

switch ($event) {
    case 'test':
        break;
    case 'form':
        ///////  投稿フォームを表示するイベント  ///////
        break;
    case 'login':
        ///////  ログインフォームを表示するイベント  ///////
        /// ログイン状態のチェック ///
        $page_name = "ログインページ";
        $content_page = "./view/login.php";
        break;
    case 'loginChk':
        ///////  ログインチェックを行うイベント  ///////
        $page_name = "ログインページ";
        $content_page = "./view/login.php";
        break;
    case 'logout':
        ///////  ログアウト処理をするイベント  ///////
        $page_name = "ログアウト";
        $content_page = "./view/logout.php";
        break;
    case 'addUser':
        ///////  ユーザの新規登録を行うイベント  ///////
    case 'signUp':
        ///////  ユーザの新規登録ページを表示するイベント  ///////
        // セキュリティの問題で今はやってない
    default:
        ///////  デフォルトイベント（初回アクセス含む）  ///////
        /// 案件一覧画面を表示する ///
        /// 案件データ一覧取得 ///
        $job_datas = $action->getDbPostData();
        /// 案件カウント取得///
        $job_counts = $action->getCountData();
        break;
}
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
            <br>
            <div id="page_header_right">
                <?php if (isset($_SESSION['username'])) : ?>
                    <h2 id="page_header_msg">ようこそ，<?php echo h($_SESSION['username']) ?>さん</h2>
                <?php else : ?>
                    <h2 id="page_header_msg">ようこそ</h2>
                    <!-- <p>ログインはこちら！</p> -->
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- メインコンテンツ開始 -->
    <div id="main_wrapper">

        <?php
        echo $event . "<br>";
        ///////  イベントに対応したコンテンツの表示  ///////
        require $content_page;
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