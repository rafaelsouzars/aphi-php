<?php
/*
	Aphi-PHP - Mini REST API framework for study and testing.
	Version: 0.0.0
	Author: @rafaelsouzars
*/

require_once '../src/Api.php';
require_once '../src/Classes/MessagesBox.php';

use Aphi\Api;
use Aphi\Classes\MessagesBox;

$api = Api::CreateAPI(); // Instancia da classe Api()

// Endpoint da raiz do server '/'
$api->get('/', function ($request) {
	MessagesBox::alert("Home page");
	var_dump($request->getQuerys());
});

$api->get('/consultar/usuario', function ($request, $response) {
	//echo "Página de consulta de usuários. <br>";
	//$response->setJson([ 'Mensagem' => 'Consulta de usuários']);
	//$response->setJson([]);
	$response->setDocument('');
});

$api->post('/login', function ($request) {
	echo $request->getJson();
	var_dump($request->getParams());
});

$api->put('/modificar', function ($request) {
	echo "Isso é um put. <br>";
	echo "Request: " . $request->getJson();
});

$api->patch('/patch', function () {
	echo "Isso é um patch";
});

$api->delete('/excluir', function($request) {
	echo "Tchau backup.";
	var_dump($request);
});

$api->run();

?>