<!-- 案件コンテンツ開始 -->
<div id="job_card_wrapper">

    <!-- 案件ヘッダー開始 -->
    <div id="main_top_container">

        <?php
        /// ページソートを表示する
        require './parts/page_sort.php';
        /// ページネイションを表示する
        require './parts/pagination.php';
        ?>

    </div>
    <!-- 案件ヘッダー終了 -->
    <!-- 案件一覧開始 -->
    <ul id="job_card_container">

        <?php if (!empty($job_datas)) : ?>
            <?php
            // ==================================================
            // 取得した案件ごとに繰り返す
            // ==================================================
            foreach ($job_datas as $job_row) : ?>
                <!-- 案件カードについて -->
                <div class="job_card">
                    <li>
                        <div class="job_top">
                            <h3 class="job_title">
                                <a href="<?php echo $job_row['url']; ?>"><?php echo $job_row['title']; ?></a>
                            </h3>
                            <div class="job_status">
                                <!-- <p class="job_status_item">新規</p> -->
                                <!-- <p class="job_status_item">お気に入り</p> -->
                                <p class="job_num"><?php echo "お仕事No: " . $job_row['job_id']; ?></p>
                            </div>
                            <div class="job_lead"><?php echo $job_row['description']; ?></div>
                        </div>
                        <div class="job_middle">
                            <table class="job_table">
                                <tbody>
                                    <tr class="job_table_row">
                                        <th class="job_table_row_head">案件種別</th>
                                        <td class="job_table_row_data"><?php echo $job_row['type']; ?></td>
                                    </tr>
                                    <tr class="job_table_row">
                                        <th class="job_table_row_head">職種</th>
                                        <td class="job_table_row_data"><?php echo $job_row['occupation']; ?></td>
                                    </tr>
                                    <tr class="job_table_row">
                                        <th class="job_table_row_head">給与</th>
                                        <td class="job_table_row_data"><?php echo $job_row['wage']; ?></td>
                                    </tr>
                                    <tr class="job_table_row">
                                        <th class="job_table_row_head">勤務地</th>
                                        <td class="job_table_row_data"><?php echo_sanitize_br($job_row['work_location']); ?></td>
                                    </tr>
                                    <tr class="job_table_row">
                                        <th class="job_table_row_head">勤務時間</th>
                                        <td class="job_table_row_data"><?php echo_sanitize_br($job_row['hours']); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="job_middle_right">
                                <p class="job_tips_title">おすすめポイント</p>
                                <p class="job_tips"><?php echo_sanitize_br($job_row['tips']); ?></p>
                            </div>
                        </div>
                        <div class="job_bottom">
                            <div class="job_btn_container">
                                <?php
                                // ==================================================
                                // ログイン状況によって表示を変える
                                // ==================================================
                                if (isset($_SESSION['username'])) : ?>
                                    <button class="job_btn">
                                        <a class="job_btn_link_favorite" href="">お気に入りに追加</a>
                                    </button>
                                <?php endif; ?>
                                <button class="job_btn">
                                    <a class="job_btn_link_detail" href="<?php echo $job_row['url']; ?>">求人の詳細を見る</a>
                                </button>
                                <?php if (isset($_SESSION['username'])) : ?>
                                    <button class="job_btn">
                                        <a class="job_btn_link_hide" href="">非表示にする</a>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </li>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </ul>
    <!-- 案件一覧終了 -->
    <!-- 案件フッターー開始 -->
    <div id="main_footting_container">

        <?php
        /// ページネイションを表示する
        require './parts/pagination.php';
        /// ページソートを表示する
        require './parts/page_sort.php';
        ?>

    </div>
    <!-- 案件フッターー終了 -->
</div>
<!-- 案件コンテンツ終了 -->