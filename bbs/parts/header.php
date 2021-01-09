<!-- ヘッダー開始 -->
<header>
    <div id="header_container">
        <div id="header_logo">
            <p id="logo_top">※非公式※</p>
            <h1>
                <a href="./index.php">パーソル案件閲覧クン</a>
            </h1>
            <div id="logo_bottom">
                <p>パーソルの案件を個人で管理しやすくするためのWEBアプリです</p>
                <p>※記事内容は参考であり実際の内容と異なる場合があります</p>
            </div>
        </div>
        <div id="header_link">
            <ul id="header_list">
                <form action="./index.php" method="POST" id="header_form">
                    <ul id="header_list">
                        <?php if ($_SESSION['adminUser'] == true) : ?>
                            <li>
                                <button type="sunmit" class="header_btn" name="event_id" value="form">記事投稿</button>
                            </li>
                            <li>
                                <button type="sunmit" class="header_btn" name="event_id" value="upload">アップロード</button>
                            </li>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['username'])) : ?>
                            <li>
                                <button type="sunmit" class="header_btn" name="event_id" value="">お気に入り</button>
                            </li>
                            <li>
                                <button type="sunmit" class="header_btn" name="event_id" value="logout">ログアウト</button>
                            </li>
                        <?php else : ?>
                            <li>
                                <button type="sunmit" class="header_btn" name="event_id" value="signUp">新規登録</button>
                            </li>
                            <li>
                                <button type="sunmit" class="header_btn" name="event_id" value="login">ログイン</button>
                            </li>
                        <?php endif; ?>
                    </ul>
                </form>
        </div>
    </div>
</header>
<!-- ヘッダー終了 -->