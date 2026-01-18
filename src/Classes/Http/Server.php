<?php
/*
	* Class Server
	* Description: Objeto para processamento e visualização do server.
	* Author: @rafaelsouzars
*/

namespace Aphi\Classes\Http;

class Server {

	private static $instance = null;  
	
	private function __construct() {

    }

	public static function CreateAPI() {
		if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
	}
	
}
?>