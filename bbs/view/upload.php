<?php
/// ログイン状態のチェック ///
require_logined_session();
?>

<div id="main_container">

    <h4>
        <?php
        echo $result_msg;
        // echo $asins;
        // var_dump($asins);
        // echo "<br>";
        ?>
    </h4>
    <p>・案件データを保存したCSVファイルをアップロードします</p>
    <p>・1行目にはヘッダ情報を含むようにしてください</p>

    <!-- アップロードフォーム開始 -->
    <form action="./index.php" method="post" role="form" enctype="multipart/form-data">
        <div id="btn_job_container">
            <input type="file" class="" id="btn_file_upload" name="csvfile" accept=".csv">
        </div>
        <div id="btn_job_container">
            <button type="submit" class="btn_job" id="btn_upload" name="event_id" value="csvUpload">アップロード</button>
            <a href="./index.php" class="btn_job" id="btn_cancel">キャンセル</a>
        </div>
    </form>
    <!-- アップロードフォーム終了 -->

</div>