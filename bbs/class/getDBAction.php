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
    // ==================================================
    // ユーザ情報に関するメソッド
    // ==================================================
    /**
     ** ユーザ情報を取得するクラスメソッド
     */
    function getUserInfo($input_username)
    {
        /// post送信されてきたユーザー名がデータベースにあるか検索する ///
        $sql = "SELECT * FROM users WHERE name=:name";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':name', $input_username, PDO::PARAM_STR, 10);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    /**
     ** ユーザ情報を登録するクラスメソッド
     */
    function addUser($user_name, $password)
    {
        /// SQL文 ///
        $sql = "INSERT INTO users(name, password) VALUES (:name, :password)";
        /// トランザクション開始 ///
        $this->pdo->beginTransaction();
        try {
            /// SQL文の発行 ///
            $stmt = $this->pdo->prepare($sql);
            /// bind処理をする ///
            $stmt->bindParam(':name', $user_name, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->execute();

            /// コミット ///
            $this->pdo->commit();
        } catch (PDOException $e) {
            //ロールバック ///
            $this->pdo->rollback();
            /// エラーメッセージ出力 ///
            // print_r($stmt->errorInfo());
            $errMsg  = $e->getMessage();
            // $errMsg  = "データベースに登録ができませんでした！";
        }
        /// エラーメッセージがある場合は結果に返す ///
        if ($errMsg) {
            $msg = $errMsg;
        }
        return $msg;
    }
    /**
     ** ユーザ情報一覧を取得するクラスメソッド
     */
    function getDbUserData()
    {
        /// 登録済みのユーザ情報の取得 ///
        $sql = "SELECT * FROM users ORDER BY user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        /// 実行結果を配列に渡す ///
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    /**
     ** 該当ユーザの認証状態を切り替えるクラスメソッド
     */
    function changeAuthState($user_id, $user_name)
    {
        /// 最初にユーザ情報を問合わせる ///
        $userInfo = $this->getUserInfo($user_name);
        $bool = 0;
        if ($userInfo['authorization'] == 0) {
            /// 認証が拒否状態なら、許可にする ///
            $bool = 1;
        };
        // return $bool;
        /// SQL文 ///
        $sql = "UPDATE `users` SET `authorization`=:bool WHERE `user_id`=:user_id AND `name`=:name";
        /// トランザクション開始 ///
        $this->pdo->beginTransaction();
        try {
            /// SQL文の発行 ///
            $stmt = $this->pdo->prepare($sql);
            /// bind処理をする ///
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
            $stmt->bindParam(':name', $user_name, PDO::PARAM_STR);
            $stmt->bindParam(':bool', $bool, PDO::PARAM_BOOL);
            $stmt->execute();

            /// コミット ///
            $this->pdo->commit();
        } catch (PDOException $e) {
            //ロールバック ///
            $this->pdo->rollback();
            /// エラーメッセージ出力 ///
            // print_r($stmt->errorInfo());
            $errMsg  = $e->getMessage();
        }
        /// エラーメッセージがある場合は結果に返す ///
        return $errMsg;
    }
    /**
     ** 該当ユーザの管理者権限の状態を切り替えるクラスメソッド
     */
    function changeAdminState($user_id, $user_name)
    {
        /// 最初にユーザ情報を問合わせる ///
        $userInfo = $this->getUserInfo($user_name);
        $bool = 0;
        if ($userInfo['admin'] == 0) {
            /// 認証が拒否状態なら、許可にする ///
            $bool = 1;
        };
        // return $bool;
        /// SQL文 ///
        $sql = "UPDATE `users` SET `admin`=:bool WHERE `user_id`=:user_id AND `name`=:name";
        /// トランザクション開始 ///
        $this->pdo->beginTransaction();
        try {
            /// SQL文の発行 ///
            $stmt = $this->pdo->prepare($sql);
            /// bind処理をする ///
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
            $stmt->bindParam(':name', $user_name, PDO::PARAM_STR);
            $stmt->bindParam(':bool', $bool, PDO::PARAM_BOOL);
            $stmt->execute();

            /// コミット ///
            $this->pdo->commit();
        } catch (PDOException $e) {
            //ロールバック ///
            $this->pdo->rollback();
            /// エラーメッセージ出力 ///
            // print_r($stmt->errorInfo());
            $errMsg  = $e->getMessage();
        }
        /// エラーメッセージがある場合は結果に返す ///
        return $errMsg;
    }
    /**
     ** 該当のユーザ情報を削除するクラスメソッド
     */
    function deleteUser($user_id, $user_name)
    {
        /// SQL文 ///
        $sql = "DELETE FROM users WHERE user_id=:user_id AND name=:name LIMIT 1";
        /// トランザクション開始 ///
        $this->pdo->beginTransaction();
        try {
            /// SQL文の発行 ///
            $stmt = $this->pdo->prepare($sql);
            /// bind処理をする ///
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
            $stmt->bindParam(':name', $user_name, PDO::PARAM_STR);
            $stmt->execute();

            /// コミット ///
            $this->pdo->commit();
        } catch (PDOException $e) {
            //ロールバック ///
            $this->pdo->rollback();
            /// エラーメッセージ出力 ///
            // print_r($stmt->errorInfo());
            $errMsg  = $e->getMessage();
        }
        /// エラーメッセージがある場合は結果に返す ///
        return $errMsg;
    }
    // ==================================================
    // 案件データに関するメソッド
    // ==================================================
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
        /// データの保存 ///
        $sql = "INSERT INTO job_info (url, title, job_id, type, tips, wage, occupation, industry, work_location, description, skill, hours, holiday, working_period, working_info, updated_at, created_at) VALUES('aaa', :title, :job_id, :type, :tips, :wage, :occupation, :industry, :work_location, :description, :skill, :hours, :holiday, :working_period, :working_info, now(), now())";
        /// トランザクション開始 ///
        $this->pdo->beginTransaction();
        try {
            /// SQL文の発行 ///
            $stmt = $this->pdo->prepare($sql);
            /// bind処理をする ///
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

            /// コミット ///
            $this->pdo->commit();
        } catch (PDOException $e) {
            //ロールバック ///
            $this->pdo->rollback();
            /// エラーメッセージ出力 ///
            // print_r($stmt->errorInfo());
            $errMsg  = $e->getMessage();
            // $errMsg  = "データベースに登録ができませんでした！";
        }
        /// エラーメッセージがある場合は結果に返す ///
        if ($errMsg) {
            $msg = $errMsg;
        }
        return $msg;
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
        // return $errMsg;

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
        $headerNameAry = [];
        foreach ($aryHeader as $headerName) {
            $headerNameAry[] = $headerName;
        }
        /// 定義したカラム名を導入文と結合する ///
        $sql .= '(' . implode(',', $headerNameAry) . ')';
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
        /// UPDATE文を作成する ///
        $sql .= ' ON DUPLICATE KEY UPDATE ';
        $tmpAry3 = [];
        foreach ($aryHeader as $headerName) {
            /// 【job_id】以外を更新する ///
            if ($headerName != 'job_id') {
                $tmpAry3[] = $headerName . ' = ' . 'VALUES(' . $headerName . ')';
            }
        }
        $sql .= implode(',', $tmpAry3);

        /// トランザクション開始 ///
        $this->pdo->beginTransaction();
        try {
            /// SQL文の発行 ///
            $stmt = $this->pdo->prepare($sql);

            /// bind処理をする ///
            /// ヘッダ行以降の行ごとに繰り返す ///
            for ($rowIdx = 1; $rowIdx < $sizeAryCSV; ++$rowIdx) {
                /// カラム名ごとに繰り返す ///
                foreach ($aryHeader as $colIdx => $headerName) {
                    $targetValue = $aryCSV[$rowIdx][$colIdx];
                    $stmt->bindValue(':' . $headerName . $rowIdx, $targetValue, PDO::PARAM_STR);
                }
            }

            $stmt->execute();

            /// コミット ///
            $this->pdo->commit();
        } catch (PDOException $e) {
            //ロールバック ///
            $this->pdo->rollback();
            /// エラーメッセージ出力 ///
            $errMsg  = $e->getMessage();
            // $errMsg  = "データベースに登録ができませんでした！";
        }
        /// エラーメッセージがある場合は結果に返す ///
        if ($errMsg) {
            $msg = $errMsg;
        }
        return $msg;
    }
}
