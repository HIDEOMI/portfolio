<?php
// ==================================================
// ユーザ管理関連のイベントについてのPHP
// ==================================================
?>

<!-- コンテンツ開始 -->
<div id="users_wrapper">

    <!-- ユーザ一覧テーブル開始 -->
    <div id="user_table_container">
        <table id="user_table">
            <tbody>
                <tr id="user_table_header">
                    <th class="user_table_row_head">ユーザ名</td>
                    <th class="user_table_row_head">メールアドレス</td>
                    <th class="user_table_row_head">認証</td>
                    <th class="user_table_row_head">管理者</td>
                    <th class="user_table_row_head">認証許可</td>
                    <th class="user_table_row_head">管理者権限</td>
                    <th class="user_table_row_head">削除</td>
                </tr>
                <?php if (!empty($user_datas)) : ?>
                    <?php
                    // ==================================================
                    // 取得したユーザ情報ごとに繰り返す
                    // ==================================================
                    foreach ($user_datas as $user_row) : ?>
                        <tr class="user_table_row">
                            <td class="user_table_row_data"><?php echo $user_row['name']; ?></td>
                            <td class="user_table_row_data"><?php echo $user_row['mail']; ?></td>
                            <td class="user_table_row_data"><?php $bool = "No";
                                                            if ($user_row['authorization'] == 1) {
                                                                $bool = "TRUE";
                                                            };
                                                            echo $bool; ?></td>
                            <td class="user_table_row_data"><?php $bool = "No";
                                                            if ($user_row['admin'] == 1) {
                                                                $bool = "TRUE";
                                                            };
                                                            echo $bool; ?></td>
                            <form action="./index.php" method="POST" role="form">
                                <input type="text" name="user_id" value="<?php echo $user_row['user_id'] ?>" hidden>
                                <input type="text" name="name" value="<?php echo $user_row['name'] ?>" hidden>
                                <td class="user_table_row_data">
                                    <button type="submit" class="admin_btn" name="event_id" value="userAuth">切替</button>
                                </td>
                                <td class="user_table_row_data">
                                    <button type="submit" class="admin_btn" name="event_id" value="adminAdd">切替</button>
                                </td>
                                <td class="user_table_row_data">
                                    <button type="submit" class="admin_btn" name="event_id" value="userDelete">削除</button>
                                </td>
                            </form>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <!-- ユーザ一覧テーブル終了 -->

</div>
<!-- 案件コンテンツ終了 -->