<?php
namespace Phalcon_wifi\Common\Ext;
class Filter {
	public static $EMAIL = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
	public static $PHONE = "/13[123569]{1}\d{8}|15[1235689]\d{8}|188\d{8}/";
	public static $USERNAME = "/^[a-zA-Z0-9_]{1,16}$/i";
	
	public function checkEmail($email) {
		return preg_match(self::$EMAIL, $email);
	}
	
	public function checkPhone($phone) {
		return preg_match(self::$PHONE, $phone);
	}
	
	public function checkUsername($username) {
		return preg_match(self::$USERNAME, $username);
	}
}