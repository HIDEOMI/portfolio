<?php

/**
 ** <BR> タグを改行コードに変換する関数
 ** @param string $str
 ** @return string
 */
function echoSanitizeBr($str)
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
