<?php
/*
	* Class Response
	* Description: Objeto responsavel em processar a resposta para o client.
	* Author: @rafaelsouzars
*/

namespace Aphi\Classes\Http;

class Response {

    public function __construct() {
        // Init values
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

    public function setJson($object) {
        try {
           if (!empty($object)) {
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode($object);
           } 
           else {
            throw new \Exception("O método não pode processar um objeto associativo nulo ou vazio.");
           }
        }
        catch(\Exception $exception) {
            $errorMessage = $exception->getMessage();
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode([ 'error' => "$errorMessage" ]);
        }
    }

    public function setDocument($document) {
        try {
           if (!empty($document)) {
            header('Content-Type: text/html; charset=UTF-8');
            echo $document;
           } 
           else {
            throw new \Exception("O método não pode processar um documento nulo ou vazio.");
           }
        }
        catch(\Exception $exception) {
            $errorMessage = $exception->getMessage();
            header('Content-Type: text/html; charset=UTF-8');
            echo "<script>alert('$errorMessage')</script>";
        }
    }
}
?>