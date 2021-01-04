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
}
