<?php

/**
 ** <BR> タグを改行コードに変換する関数
 ** @param string $str
 ** @return string
 */
function echo_sanitize_br($str)
{
	echo nl2br(htmlspecialchars($str, ENT_QUOTES, 'UTF-8'));
}
/**
 ** HTML特殊文字をエスケープする関数
 **  （htmlspecialcharsのラッパー関数）
 ** @param string $str
 ** @return string
 */
function h($str)
{
	return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
/**
 ** ログイン状態によってリダイレクトを行うsession_startのラッパー関数
 ** 初回時または失敗時にはヘッダを送信してexitする
 */
function require_unlogined_session()
{
	/// セッション開始 ///
	@session_start();
	/// ログインしていれば ./index.php に遷移 ///
	if (isset($_SESSION['username'])) {
		header('Location: ./index.php');
		exit;
	}
}
/**
 ** ログイン状態によってリダイレクトを行うsession_startのラッパー関数
 ** 初回時または失敗時にはヘッダを送信してexitする
 */
function require_logined_session()
{
	// セッション開始
	@session_start();
	// ログインしていなければ ./login.php に遷移
	if (!isset($_SESSION['username'])) {
		header('Location: ./index.php');
		exit;
	}
}
/**
 ** パスワードをチェックする関数
 */
function validate_password($input_pass, $result_pass)
{
	/// ユーザ名が存在しないときだけ極端に速くなるのを防ぐ ///
	return password_verify($input_pass, isset($result_pass) ? $result_pass : '$2y$10$abcdefghijklmnopqrstuv');
}
/**
 ** URLパラメータを編集する関数
 ** @追加または上書き
 ** @$url_param = url_param_change(Array("パラメータ名"=>"追加または上書きする内容"));
 ** @削除
 ** @$url_param = url_param_change(Array("削除するパラメータ名"=>null));
 ** @第2引数を指定
 ** @$url_param = url_param_change(Array("パラメータ名"=>"内容"),1);
 */
function url_param_change($par = array(), $op = 0)
{
	$url = parse_url($_SERVER["REQUEST_URI"]);
	if (isset($url["query"])) parse_str($url["query"], $query);
	else $query = array();
	foreach ($par as $key => $value) {
		if ($key && is_null($value)) unset($query[$key]);
		else $query[$key] = $value;
	}
	$query = str_replace("=&", "&", http_build_query($query));
	$query = preg_replace("/=$/", "", $query);
	return URL . $query ? (!$op ? "?" : "") . htmlspecialchars($query, ENT_QUOTES) : "";
}
/**
 ** パラメータを編集したURLをechoする関数
 ** @追加または上書き
 ** @$url_param = url_param_change(Array("パラメータ名"=>"追加または上書きする内容"));
 ** @削除
 ** @$url_param = url_param_change(Array("削除するパラメータ名"=>null));
 ** @第2引数を指定
 ** @$url_param = url_param_change(Array("パラメータ名"=>"内容"),1);
 */
function get_requets_of($par = array(), $op = 0)
{
	$get_url = URL . url_param_change($par, $op);
	echo $get_url;
}
