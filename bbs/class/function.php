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