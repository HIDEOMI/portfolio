<?php
// ==================================================
// ユーザ登録関連のイベントについてのPHP
// ==================================================

if ($event === "addUser") {
    // ==================================================
    // ユーザ情報の確認フロー
    // ==================================================
    if (empty($_POST["username"]) || empty($_POST["password"])) {
        /// ユーザー名またはパスワードが送信されて来なかった場合、エラーメッセージを表示して終了する ///
        $message = "ユーザー名とパスワードを入力してください";
    } else {
        /// ユーザ名とパスワードが送信されてきた場合 ///
        ///////  ユーザ情報について認証するフロー  ///////
        /// ユーザから受け取ったユーザ名とパスワード ///
        $input_username = filter_input(INPUT_POST, 'username');
        $input_password = filter_input(INPUT_POST, 'password');
        $input_password_re = filter_input(INPUT_POST, 'password_re');
        $user_data = $action->getUserInfo($input_username);

        if ($user_data) {
            /// ユーザ名が既に存在した場合 ///
            /// 「403 Forbidden」 ///
            http_response_code(403);
        } else if ($input_password != $input_password_re) {
            /// パスワードの確認が失敗した場合 ///
            $message = "再入力したパスワードが間違っています";
        } else {
            /// 登録作業 ///
            $hash_password = password_hash($input_password, PASSWORD_DEFAULT);
            $action->addUser($input_username, $hash_password);
            /// 登録完了メッセージ ///
            $message = "ユーザ登録が完了しました";
        }
    }
}

$message = h($message);
?>


<div id="main_container">
    <div id="form_lead">
        <h3>ユーザの新規登録を行います</h3>
        <h3>ユーザ名とパスワードを入力してください</h3>
        <?php if ($message) : ?>
            <p style="color: red;"><?php echo $message ?></p>
        <?php endif; ?>
        <?php if (http_response_code() === 403) : ?>
            <p style="color: red;">ユーザ名を変更してください！</p>
        <?php endif; ?>
    </div>

    <!-- ログインフォーム開始 -->
    <form action="./index.php" method="POST" role="form">
        <table id="login_table">
            <tbody>
                <tr id="row_job_title" class="form_job_row">
                    <th>
                        <label>ユーザ名</label>
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
                <tr id="row_job_number" class="form_job_row">
                    <th>
                        <label>パスワード（再入力）</label>
                    </th>
                    <td>
                        <input type="password" name="password_re" class="form_job_input" value="" placeholder="パスワード（再入力）" />
                    </td>
                </tr>
            </tbody>
        </table>
        <div id="btn_job_container">
            <button type="submit" class="btn_job" id="btn_submit" name="event_id" value="addUser">新規登録</button>
            <a href="./index.php" class="btn_job" id="btn_cancel">キャンセル</a>
        </div>
    </form>
    <!-- 案件投稿フォーム終了 -->

</div>