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
    function chkPass($input_username)
    {
        /// post送信されてきたユーザー名がデータベースにあるか検索する ///
        $sql = "SELECT * FROM users WHERE name=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(1, $input_username, PDO::PARAM_STR, 10);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['password'];
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
    function getDbPostData()
    {
        /// 登録済み案件データの取得 ///
        $sql = "SELECT * FROM job_info ORDER BY job_id DESC;";
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
}
