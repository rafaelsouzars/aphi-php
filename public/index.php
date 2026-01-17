<?php
/*
	Aphi-PHP - Mini REST API framework for study and testing.
	Version: 0.0.0
	Author: @rafaelsouzars
*/

require_once '../src/App.php';
require_once '../src/Interfaces/MessagesBox.php';

use src\App;
use src\Interfaces\MessagesBox;

$app = new App(); // Instancia da classe App()

// Endpoint da raiz do server '/'
$app->get('/', function () {
	MessagesBox::alert("Home page");
});

$app->get('/consultar/usuario', function () {
	echo "Página de consulta de usuários";
});

$app->run();

?>