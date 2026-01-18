<?php
/*
	* Class App
	* Description: Objeto responsável em registrar, processar e executar os endpoints da API.
	* Author: @rafaelsouzars
*/

namespace Aphi;

require __DIR__ . '/Classes/Http/Request.php';
use Aphi\Classes\Http\Request;

class Api
{
	/* Atributos públicos */
	//public Request $req;
	/* Atributos privados */
	private static $instance = null;
	private array $endPoints = []; // Inicia a matriz para armazenar os endpoints registrados

	/* Static Method Singleton Instance */

	public static function CreateAPI() {
		if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
	}

	// Construtor
	private function __construct()
	{
		// Implementar o padrão Singleton;				
	}
	
	/* Métodos públicos */
	
	// Registra endpoints acessados pelo metodo get
	public function get(string $endPoint, callable $callback)
	{
		try
		{			
			// Verifica se o parametro com endpoint não é nulo
			if ($endPoint !== null)
			{
				// Nota: Falta implementar o registro do método HTTP
				$this->endPoints[] = ['method' => 'GET', 'endpoint' => $endPoint, 'callback' => $callback]; // Registra o endpoint junto com seu callback
				//var_dump($this->endPoints);				
			}
			else
			{
				throw new Exception("O método não pode processar um valor nulo para o endpoint, insira um valor.");
			}
		}
		catch (Exception $e)
		{
			echo "Método App->get(): " . $e->getMessage();
		}		
	}

	public function post(string $endPoint, callable $callback)
	{
		try
		{
			// Verifica se o parametro com endpoint não é nulo
			if ($endPoint !== null)
			{
				// Nota: Falta implementar o registro do método HTTP
				$this->endPoints[] = ['method' => 'POST', 'endpoint' => $endPoint, 'callback' => $callback]; // Registra o endpoint junto com seu callback
				//var_dump($this->endPoints);
				
			}
			else
			{
				throw new Exception("O método não pode processar um valor nulo para o endpoint, insira um valor.");
			}
		}
		catch (Exception $e)
		{
			echo "Método App->get(): " . $e->getMessage();
		}
	}

	public function put(string $endPoint, callable $callback)
	{
		try
		{
			// Verifica se o parametro com endpoint não é nulo
			if ($endPoint !== null)
			{
				// Nota: Falta implementar o registro do método HTTP
				$this->endPoints[] = ['method' => 'PUT', 'endpoint' => $endPoint, 'callback' => $callback]; // Registra o endpoint junto com seu callback
				//var_dump($this->endPoints);
				
			}
			else
			{
				throw new Exception("O método não pode processar um valor nulo para o endpoint, insira um valor.");
			}
		}
		catch (Exception $e)
		{
			echo "Método App->get(): " . $e->getMessage();
		}
	}

	public function delete(string $endPoint, callable $callback)
	{
		try
		{
			// Verifica se o parametro com endpoint não é nulo
			if ($endPoint !== null)
			{
				// Nota: Falta implementar o registro do método HTTP
				$this->endPoints[] = ['method' => 'DELETE', 'endpoint' => $endPoint, 'callback' => $callback]; // Registra o endpoint junto com seu callback
				//var_dump($this->endPoints);
				
			}
			else
			{
				throw new Exception("O método não pode processar um valor nulo para o endpoint, insira um valor.");
			}
		}
		catch (Exception $e)
		{
			echo "Método App->get(): " . $e->getMessage();
		}
	}

	public function patch(string $endPoint, callable $callback)
	{
		try
		{
			// Verifica se o parametro com endpoint não é nulo
			if ($endPoint !== null)
			{
				// Nota: Falta implementar o registro do método HTTP
				$this->endPoints[] = ['method' => 'PATCH', 'endpoint' => $endPoint, 'callback' => $callback]; // Registra o endpoint junto com seu callback
				//var_dump($this->endPoints);
				
			}
			else
			{
				throw new Exception("O método não pode processar um valor nulo para o endpoint, insira um valor.");
			}
		}
		catch (Exception $e)
		{
			echo "Método App->get(): " . $e->getMessage();
		}
	}
	
	// Método inicializador do server request
	public function run()
	{
		try 
		{	
			//$req = new Request();		
			$uri = parse_url($_SERVER['REQUEST_URI']); // Requisita a URI completa 
			$path = $uri['path']; // Extrai o path
			
			// Verifica se o path corresponde a um endpoint registrado
			if ($this->isEndPointExists($_SERVER['REQUEST_METHOD'], $path))
			{				
				//$this->executeEndPointCallback($path);
				if($_SERVER['REQUEST_METHOD'] === 'GET' || $_SERVER['REQUEST_METHOD'] === 'DELETE')
				{
					
					/*$request = [];
					if(!empty($_GET)) // empty($array) Verifica se o array esta vazio
					{						
						foreach ($_GET as $key => $query) 
						{
							$newItem = [$key => $query];
							$request = array_merge($request, $newItem);
							//var_dump($request);
						}						
					}*/
					$this->executeEndPointCallback($path)(new Request());
				}
				else if($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'PUT' || $_SERVER['REQUEST_METHOD'] === 'PATCH')
				{
					$Request = file_get_contents('php://input');
					$this->executeEndPointCallback($path)(new Request());					
				}
			}
			else
			{
				http_response_code(404);					
				echo "Erro 404 - Página não encontrada.";
				exit;
			}

		} 
		catch (Exception $e)
		{
			echo "Erro: " . $e->getMessage();
		}
	}
	
	
	/* Métodos privados */
	
	private function isEndPointExists(string $httpMethod , string $uriPath)
	{
		$result = false;
		
		if (count($this->endPoints) > 0)
		{
			foreach ($this->endPoints as $endPoint) 
			{
				
				if (in_array($httpMethod, $endPoint) && in_array($uriPath, $endPoint))
				{
					$result = true;
				}
				
							
			}
		}		
		
		return $result;
	}
	
	private function executeEndPointCallback(string $uriPath)
	{
		$callback = null;
		
		if (count($this->endPoints) > 0)
		{
			foreach ($this->endPoints as $endPoint) 
			{
				foreach ($endPoint as $value)
				{
					if ($uriPath === $value)
					{
						$callback = $endPoint['callback'];
					}
				}
							
			}
		}		
		
		return $callback;
	}

	private function showEndPoints()
	{
		foreach($this->endPoints as $endPoint)
		{
			foreach($endPoint as $key => $value)
			{
				if ($key != 'callback')
				{
					echo "Key: $key, Value: $value. <br>";
				}
			}
		}
	}
	
}

?>