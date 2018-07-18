<?php
session_start();
class Token {
	public static function create(){
		return $_SESSION['token'] = base64_encode(uniqid(rand(1,9999)));
		// return $_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(26).uniqid(rand(1,9999)));
	}
	public static function check($token){
		if(isset($_SESSION['token']) && $_SESSION['token'] == $token){
			unset($_SESSION['token']);
			return true;
		}
		return false;
	}
}
?>