<?php
///////  ログインについて認証する処理  ///////
require_unlogined_session();

/// 事前の諸々確認 ///
/// イベント【loginChk】かつPOSTメソッドのときのみ実行する ///
if (($event === "loginChk")  && ($_SERVER['REQUEST_METHOD'] === 'POST')) {
    $message = "";
    /// ユーザー名またはパスワードが送信されて来なかった場合はエラーメッセージを表示して終了する ///
    if (empty($_POST["username"]) || empty($_POST["password"])) {
        $message = "ユーザー名とパスワードを入力してください";
    } else {
        /// ユーザ名とパスワードが送信されてきた場合 ///

        ///////  ユーザ情報について認証するフロー  ///////
        /// ユーザから受け取ったユーザ名とパスワードと保存されたトークン（セッションID） ///
        $input_username = filter_input(INPUT_POST, 'username');
        $input_password = filter_input(INPUT_POST, 'password');
        $token = filter_input(INPUT_POST, 'token');
        $result_password = $action->chkPass($input_username);

        /// トークンとユーザパスワードをそれぞれチェック ///
        if ((validate_token($token)) && validate_password($input_password, $result_password)) {
            /// 認証が成功したとき ///
            session_regenerate_id(true);  /// セッションIDの追跡を防ぐためにセッションID再発行
            /// ユーザ名をセット ///
            $_SESSION['username'] = $input_username;
            /// ログイン完了後にトップページに遷移 ///
            header('Location: ./index.php');
            exit;
        } else {
            /// 認証が失敗したとき ///
            /// 「403 Forbidden」 ///
            http_response_code(403);
        }
    }
}

$message = h($message);
?>

<div id="main_container">
    <div id="form_lead">
        <h3>ログインしてください</h3>
        <?php if ($message) : ?>
            <p style="color: red;"><?php echo $message ?></p>
        <?php endif; ?>
        <?php if (http_response_code() === 403) : ?>
            <p style="color: red;">・ユーザ名またはパスワードが違います</p>
        <?php endif; ?>
    </div>

    <!-- ログインフォーム開始 -->
    <form action="./index.php" method="post" role="form">
        <table id="login_table">
            <tbody>
                <tr id="row_job_title" class="form_job_row">
                    <th>
                        <label>ユーザー名</label>
                    </th>
                    <td>
                        <input type="text" name="username" class="form_job_input" value="" placeholder="ユーザー名" />
                    </td>
                </tr>
                <tr id="row_job_number" class="form_job_row">
                    <th>
                        <label>パスワード</label>
                    </th>
                    <td>
                        <input type="password" name="password" class="form_job_input" value="" placeholder="パスワード" />
                    </td>
                </tr>
            </tbody>
        </table>
        <div id="btn_job_container">
            <input type="hidden" name="token" value="<?= h(generate_token()) ?>">
            <button type="submit" class="btn_job" id="btn_upload" name="event_id" value="loginChk">ログイン</button>
            <a href="./index.php" class="btn_job" id="btn_cancel">キャンセル</a>
        </div>
    </form>
    <!-- 案件投稿フォーム終了 -->

</div>