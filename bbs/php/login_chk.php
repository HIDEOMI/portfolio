<?php
// ==================================================
// ログイン関連のイベントについてのPHP
// ==================================================

if ($event === "loginChk") {
    // ==================================================
    // ログインの確認フロー
    // ==================================================
    if (empty($_POST["username"]) || empty($_POST["password"])) {
        /// ユーザー名またはパスワードが送信されて来なかった場合はエラーメッセージを表示して終了する ///
        $message = "ユーザー名とパスワードを入力してください";
    } else {
        /// ユーザ名とパスワードが送信されてきた場合 ///
        ///////  ユーザ情報について認証するフロー  ///////
        /// ユーザから受け取ったユーザ名とパスワード ///
        $input_username = filter_input(INPUT_POST, 'username');
        $input_password = filter_input(INPUT_POST, 'password');
        $user_data = $action->getUserInfo($input_username);

        /// パスワードをチェック ///
        if (validate_password($input_password, $user_data['password'])) {
            /// 認証が成功したとき ///
            // ==================================================
            // ログイン成功イベント
            // ==================================================
            session_regenerate_id(true);  /// セッションIDの追跡を防ぐためにセッションID再発行
            /// ユーザ名をセット ///
            $_SESSION['username'] = $input_username;
            /// 管理者情報をセット ///
            $_SESSION['adminUser'] = $user_data['admin'];
            /// ユーザIDをセット ///
            $_SESSION['userID'] = $user_data['user_id'];
            /// index.php に遷移 ///
            header('Location: ./index.php');
            exit;
        } else {
            /// 認証が失敗したとき ///
            /// 「403 Forbidden」 ///
            http_response_code(403);
        }
    }
} elseif ($event === "logout") {
    // ==================================================
    // ログアウトイベント
    // ==================================================
    // セッション用Cookieの破棄
    setcookie(session_name(), '', 1);
    session_unset();
    // セッションファイルの破棄
    session_destroy();
    /// index.php に遷移 ///
    header('Location: ./index.php');
    exit;
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
    <form action="./index.php" method="POST" role="form">
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
            <button type="submit" class="btn_job" id="btn_upload" name="event_id" value="loginChk">ログイン</button>
            <a href="./index.php" class="btn_job" id="btn_cancel">キャンセル</a>
        </div>
    </form>
    <!-- 案件投稿フォーム終了 -->

</div>