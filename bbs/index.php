<?php
// ==================================================
// 色々読み込む
// ==================================================
/// タイムゾーン設定 ///
date_default_timezone_set('Asia/Tokyo');
/// セッションの利用 ///
@session_start();
/// 定数 ///
require_once "./config/properties.php";
/// 基本的な関数 ///
require_once "./class/function.php";
/// クラス ///
require_once "./class/getDBAction.php";

/// インスタンス作成 ///
$action = new getDBAction();
/// イベントの初期化 ///
$event = null;
/// イベント取得 ///
if (isset($_POST['event_id'])) {
    $event = $_POST['event_id'];
}
/// イベントメッセージの定義 ///
$event_msg = "";

$event_msg = $event;

// ==================================================
// イベントによって処理が分岐する
// ==================================================
$page_name = "案件一覧";
$content_page = "./view/list.php";
switch ($event) {
    case 'form':
        // ==================================================
        // 投稿フォームを表示するイベント
        // ==================================================
        require_logined_session();  /// ログイン状態のチェック
        $page_name = "案件作成";
        $content_page = "./view/form.php";
        break;
    case 'saveJobInfo':
        // ==================================================
        // 記事を保存するイベント
        // ==================================================
        require_logined_session();  /// ログイン状態のチェック
        /// DBに記事データを保存 ///
        $action->saveDBJobInfo($_POST);
        /// 投稿フォームを表示する ///
        $page_name = "案件作成";
        $content_page = "./view/form.php";
        break;
    case 'upload':
        // ==================================================
        // アップロードフォームを表示するイベント
        // ==================================================
        require_logined_session();  /// ログイン状態のチェック
        $page_name = "CSVアップロード";
        $content_page = "./view/upload.php";
        break;
    case 'csvUpload':
        // ==================================================
        // CSVをアップロードするイベント
        // ==================================================
        require_logined_session();  /// ログイン状態のチェック
        /// CSVの内容をDBにアップロード ///
        $result_msg = $action->uploadCSV($_FILES);
        /// アップロードフォームを表示する ///
        $page_name = "CSVアップロード";
        $content_page = "./view/upload.php";
        break;
    case 'login':
        // ==================================================
        // ログインフォームを表示するイベント
        // ==================================================
        // require_unlogined_session();  /// ログイン状態のチェック
        $page_name = "ログインページ";
        $content_page = "./php/login_chk.php";
        break;
    case 'loginChk':
        // ==================================================
        // ログインチェックを行うイベント
        // ==================================================
        $page_name = "ログインページ";
        $content_page = "./php/login_chk.php";
        break;
    case 'logout':
        // ==================================================
        // ログアウト処理をするイベント
        // ==================================================
        $page_name = "ログアウト";
        $content_page = "./php/login_chk.php";
        break;
    case 'signUp':
        // ==================================================
        // ユーザの登録フォームを表示するイベント
        // ==================================================
        $page_name = "新規登録";
        $content_page = "./php/sign_up.php";
        break;
    case 'addUser':
        // ==================================================
        // ユーザの新規登録の処理を行うイベント
        // ==================================================
        $page_name = "新規登録";
        $content_page = "./php/sign_up.php";
        break;
    default:
        // ==================================================
        // デフォルトイベント（案件一覧画面を表示する）
        // ==================================================
        /// 案件データ一覧取得 ///
        $page = 1;
        $display_count = 10;
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        }
        if (isset($_GET['display_count'])) {
            $display_count = $_GET['display_count'];
        }
        $job_datas = $action->getDbPostData($page, $display_count);
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
    <link rel="stylesheet" href="./css/contents.css">
    <title><?php echo $page_name . " | パーソル案件閲覧クン" ?></title>
</head>

<!-- ページ開始 -->

<body>

    <?php
    /// ヘッダーを表示する
    require './parts/header.php';
    if ($event_msg != "") {
        /// イベントメッセージを表示する
        require './parts/event_msg.php';
    }
    ?>

    <!-- ページ見出し開始 -->
    <div id="page_header_wrapper">
        <div id="page_header_container">
            <h2 id="page_header_title"><?php echo $page_name ?></h2>
            <div id="page_header_right">
                <?php if (isset($_SESSION['username'])) : ?>
                    <h2 id="page_header_msg">ようこそ，<?php echo h($_SESSION['username']) ?>さん</h2>
                <?php else : ?>
                    <h2 id="page_header_msg">サイトへようこそ！</h2>
                    <!-- <p>ログインはこちら！</p> -->
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- メインコンテンツ開始 -->
    <div id="main_wrapper">

        <?php
        echo $event . "<br>";
        // ==================================================
        // イベントに対応したコンテンツの表示
        // ==================================================
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
<!------   HTML 終了   ------>