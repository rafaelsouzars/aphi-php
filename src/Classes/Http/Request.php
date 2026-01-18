<?php
/*
	* Class Request
	* Description: Objeto para visualização dos dados do client.
	* Author: @rafaelsouzars
*/

namespace Aphi\Classes\Http;

class Request
{
    private $request;
    private $body;
    private $json;
    private $querys;
    private $params; 
    private $uri;
    private $path;   

    public function __construct() {
        
        $this->request = '';
        $this->body = '';
        $this->json = '';
        $this->querys = [];
        $this->params = [];        
        $this->uri = parse_url($_SERVER['REQUEST_URI']);
        $this->path = $this->uri['path'];

        if ($_SERVER['REQUEST_METHOD'] === 'GET' || $_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $this->requestQuery();
        }
        else if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'PUT' || $_SERVER['REQUEST_METHOD'] === 'PATCH') {
            if (!empty($_SERVER['CONTENT_TYPE'])) {
                switch($_SERVER['CONTENT_TYPE']) {
                    case 'text/html':
                        $this->requestBody();
                        break;
                    case 'application/json':
                        $this->requestJson();
                        break;
                    case 'application/x-www-form-urlencoded':
                        $this->requestParams();
                        break; 
                    default: $this->requestBody();
                }
            }
        }

        
    }

    /*
        Tipos Comuns de Content-Type
            text/html: Para documentos HTML.
            application/json: Para dados no formato JSON (JavaScript Object Notation).
            application/x-www-form-urlencoded: Padrão para formulários HTML, codifica dados como chave=valor&chave2=valor2.
            multipart/form-data: Usado para formulários que enviam arquivos (upload) ou dados binários, definindo limites (boundary) entre as partes.
            text/plain: Para texto simples, sem formatação.
            application/xml ou text/xml: Para dados em XML.
            image/jpeg, image/png, image/gif: Para diferentes formatos de imagem.
            application/pdf: Para documentos PDF. 
    */
    /** Métodos públicos */
    public function getBody() {
        return $this->body;
    }

    public function getJson() {
        return $this->json;
    }

    public function getQuerys() {
        return $this->querys;
    }

    public function getParams() {
        return $this->params;
    }

    public function getUri() {
        return $this->uri;
    }

    public function getPath() {        
        return $this->path;
    }

    /** Métodos privados */
    private function requestBody() {
        try {            
            $this->body = file_get_contents('php://input');            
        }
        catch (Exception $exception) {
            echo "Request->getBody() Error: " . $exception->getMessage();
        } 
    }

    private function requestJson() {
        try {            
            $this->json = file_get_contents('php://input');          
        }
        catch (Exception $exception) {
            echo "Request->getBody() Error: " . $exception->getMessage();
        } 
    }

    private function requestQuery() {
        try {            
            if(!empty($_GET)) {
                //var_dump($_GET);
                foreach ($_GET as $key => $param) 
                {
                    $newItem = [$key => $param];
                    $this->querys = array_merge($this->querys, $newItem);
                    //var_dump($this->querys);
                }
            }            
        }
        catch (Exception $exception) {
            echo "Request->getBody() Error: " . $exception->getMessage();
        }
    }

    private function requestParams() {
        try {            
            if(!empty($_POST)) {
                foreach ($_POST as $key => $param) 
                {
                    $newItem = [$key => $param];
                    $this->params = array_merge($this->params, $newItem);
                    //var_dump($request);
                }
            }            
        }
        catch (Exception $exception) {
            echo "Request->getBody() Error: " . $exception->getMessage();
        }
    }

}
?>