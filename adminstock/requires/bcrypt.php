<?php

// Bcrypt hashing class

class Bcrypt {
	protected static $_saltPrefix = '2a';

//	Custo padrao de 8
	protected static $_defaultCost = 8;

//	Tamanho limite do Salt gerado
	protected static $_saltLength = 22;
	
	public static function hash($string, $cost = null) {
		if (empty($cost)) {
			$cost = self::$_defaultCost;
		}
		// Gera Salt
		$salt = self::generateRandomSalt();
		// Hash string
		$hashString = self::__generateHashString((int)$cost, $salt);
		return crypt($string, $hashString);
	}
	
// 	Checa uma string criptografada
//	@return boolean
	public static function check($string, $hash) {
		return (crypt($string, $hash) === $hash);
	}

//	Gera um base64 encoded salt aleatorio
//	@return string
	public static function generateRandomSalt() {
		// Salt seed
		$seed = uniqid(mt_rand(), true);
		// Generate salt
		$salt = base64_encode($seed);
		$salt = str_replace('+', '.', $salt);
		return substr($salt, 0, self::$_saltLength);
	}

//	Build a hash string for crypt()
// 	@return string
	private static function __generateHashString($cost, $salt) {
		return sprintf('$%s$%02d$%s$', self::$_saltPrefix, $cost, $salt);
	}
	
	public static function generateRandomHash() {
		$salt = self:: generateRandomSalt();
		$hash = self::hash($salt);
		return $hash;
	}
}