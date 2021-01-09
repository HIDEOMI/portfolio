<?php
class getDBAction
{
    public $pdo;

    /**
     ** データベースに接続 
     */
    function __construct()
    {
        try {
            /// データベースの接続情報 ///
            // require "/usr/etc/my_db.cnf";
            $this->pdo = new PDO(PDO_DSN, DATABASE_USER, DATABASE_PASSWORD);
        } catch (PDOException $e) {
            /// 接続エラーの場合の処理 ///
            echo 'データベースに接続できませんでした：' . $e->getMessage();
            die();
        }
        /// 静的プレースホルダを指定 ///
        $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        /// エラー発生時に例外を投げる ///
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    /**
     ** ログイン情報を取得するクラスメソッド
     */
    function getUserInfo($input_username)
    {
        /// post送信されてきたユーザー名がデータベースにあるか検索する ///
        $sql = "SELECT * FROM users WHERE name=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(1, $input_username, PDO::PARAM_STR, 10);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    /**
     ** 案件データ一覧の件数をDBから取得するクラスメソッド
     */
    function getCountData()
    {
        /// 登録済み案件データの取得 ///
        $sql = "SELECT COUNT(*) FROM job_info;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        /// 実行結果の件数を返す ///
        $count = $stmt->fetchColumn();
        return $count;
    }
    /**
     ** 案件データ一覧をDBから取得するクラスメソッド
     */
    function getDbPostData($page, $display_count)
    {
        $offset_count = ($page - 1) * $display_count;
        /// 登録済み案件データの取得 ///
        $sql = "SELECT * FROM job_info ORDER BY job_id DESC LIMIT $offset_count, $display_count";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        /// 実行結果を配列に渡す ///
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    /**
     ** 案件データをDBに保存するクラスメソッド
     */
    function saveDBJobInfo($data)
    {
        try {
            /// データの保存 ///
            // $sql = "INSERT INTO 'job_info' ('title', 'job_id', 'tips', 'created_at') VALUES(:title, :job_id, :tips, now())";
            $sql = "INSERT INTO job_info (url, title, job_id, type, tips, wage, occupation, industry, work_location, description, skill, hours, holiday, working_period, working_info, updated_at, created_at) VALUES('aaa', :title, :job_id, :type, :tips, :wage, :occupation, :industry, :work_location, :description, :skill, :hours, :holiday, :working_period, :working_info, now(), now())";
            $stmt = $this->pdo->prepare($sql);
            // $stmt->bindParam(':url', $data['title'], PDO::PARAM_STR);
            $stmt->bindParam(':title', $data['title'], PDO::PARAM_STR);
            $stmt->bindParam(':job_id', $data['job_id'], PDO::PARAM_STR);
            $stmt->bindParam(':type', $data['type'], PDO::PARAM_STR);
            $stmt->bindParam(':tips', $data['tips'], PDO::PARAM_STR);
            $stmt->bindParam(':wage', $data['wage'], PDO::PARAM_STR);
            $stmt->bindParam(':occupation', $data['occupation'], PDO::PARAM_STR);
            $stmt->bindParam(':industry', $data['industry'], PDO::PARAM_STR);
            $stmt->bindParam(':work_location', $data['work_location'], PDO::PARAM_STR);
            $stmt->bindParam(':description', $data['description'], PDO::PARAM_STR);
            $stmt->bindParam(':skill', $data['skill'], PDO::PARAM_STR);
            $stmt->bindParam(':hours', $data['hours'], PDO::PARAM_STR);
            $stmt->bindParam(':holiday', $data['holiday'], PDO::PARAM_STR);
            $stmt->bindParam(':working_period', $data['working_period'], PDO::PARAM_STR);
            $stmt->bindParam(':working_info', $data['working_info'], PDO::PARAM_STR);
            $stmt->execute();

            /// エラーの場合はエラー情報を表示する///
            print_r($stmt->errorInfo());
        } catch (Exception $e) {
            /// エラーの場合はエラー情報を表示する///
            var_dump($e);
        }
    }
    /**
     ** 案件データのCSVをDBに保存するクラスメソッド
     */
    function uploadCSV($CSVFile)
    {
        // ==================================================
        // CSVをサーバに保存して、配列データとして取得するフロー
        // ==================================================
        // var_dump($CSVFile);
        /// ファイルの存在チェック ///
        if (is_uploaded_file($CSVFile['csvfile']['tmp_name'])) {
            $tmpFileName = $CSVFile['csvfile']['tmp_name'];
            $fileName = $CSVFile['csvfile']['name'];
            /// 拡張子のチェック ///
            if (pathinfo($fileName, PATHINFO_EXTENSION) != 'csv') {
                $errMsg = '・CSVファイルのみ対応しています';
            } else {
                /// ファイルをdataディレクトリに移動する ///
                $file = "./data/uploaded/" . $fileName;
                if (move_uploaded_file($tmpFileName, $file)) {
                    /// 後で削除できるように権限を644にする ///
                    chmod($file, 0644);
                    $msg = "【" . $fileName . "】をアップロードしました！";
                    $fp = fopen($file, "r");
                    /// 配列に変換する ///
                    while (($data = fgetcsv($fp, 0, ',', '"')) !== FALSE) {
                        $aryCSV[] = $data;
                    }
                    fclose($fp);
                    /// ファイルの削除 ///
                    unlink($file);
                } else {
                    $errMsg = '・ファイルをアップロードできません！';
                }
            }
        } else {
            $errMsg = '・ファイルが選択されていません！';
        }

        // ==================================================
        // 配列データをDBに保存するフロー
        // ==================================================
        ///////  SQL文作成処理  ///////
        /// 導入文 ///
        $sql = 'INSERT INTO job_info ';
        // echo "<br>" . $sql . "<br>";

        $aryHeader = $aryCSV[0];  /// ヘッダ配列の定義
        $sizeAryCSV = count($aryCSV);  /// CSVの行数の定義

        /// カラム名の定義 ///
        $tmpAry = [];
        foreach ($aryHeader as $headerName) {
            $tmpAry[] = $headerName;
        }
        /// 定義したカラム名を導入文と結合する ///
        $sql .= '(' . implode(',', $tmpAry) . ')';
        // echo "<br>" . $sql . "<br>";

        /// バインドのためのVALUEを定義する ///
        $tmpAry1 = [];
        /// ヘッダ行以降の行ごとに繰り返す ///
        for ($rowIdx = 1; $rowIdx < $sizeAryCSV; ++$rowIdx) {
            $tmpAry2 = [];
            /// カラム名ごとに繰り返す ///
            foreach ($aryHeader as $headerName) {
                $tmpAry2[] = ':' . $headerName . $rowIdx;
            }
            $tmpAry1[] = '(' . implode(',', $tmpAry2) . ')';
        }
        /// 定義したバインドのためのVALUEを結合する ///
        $sql .= ' VALUES ' . implode(',', $tmpAry1);
        // echo "<br>" . $sql . "<br>";

        /// トランザクション開始 ///
        $this->pdo->beginTransaction();
        try {
            /// sql分の発行 ///
            $stmt = $this->pdo->prepare($sql);

            /// bind処理をする ///
            /// ヘッダ行以降の行ごとに繰り返す ///
            for ($rowIdx = 1; $rowIdx < $sizeAryCSV; ++$rowIdx) {
                /// カラム名ごとに繰り返す ///
                foreach ($aryHeader as $colIdx => $headerName) {
                    $targetValue = $aryCSV[$rowIdx][$colIdx];
                    $stmt->bindValue(':' . $headerName . $rowIdx, $targetValue, PDO::PARAM_STR);
                    // echo "<br>" . ':' . $headerName . $rowIdx . ", " . $targetValue . "<br>";

                }
            }

            $stmt->execute();

            /// コミット ///
            $this->pdo->commit();
        } catch (PDOException $e) {
            //ロールバック ///
            $this->pdo->rollback();
            /// エラーメッセージ出力 ///
            // $errMsg  = $e->getMessage();
            $errMsg  = "データベースに登録ができませんでした！";
        }
        /// エラーメッセージがある場合は結果に返す ///
        if ($errMsg) {
            $msg = $errMsg;
        }
        return $msg;
    }
}
