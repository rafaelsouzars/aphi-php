<?php
/*
	* Class Messages
	* Description: Objeto responsável em fornecer caixas de mensagens customizados.
	* Author: @rafaelsouzars
*/

namespace Aphi\Classes;

class MessagesBox {
	
	/* Métodos estáticos públicos */
	
	public static function alert(string $message)
	{
		try
		{
			if ($message)
			{
				/*echo <<<MSG
						Isso é um alert
						Mensagem: $message
						MSG;*/
				self::boxMsg($message);
			}
			else
			{
				throw new Exception("Insira um valor string no parametro da função.");
			}
		}
		catch (Exception $e)
		{
			echo "Método MessagesBox::alert(): " . $e->getMessage();
		}
		
	}
	
	/* Métodos estáticos privados */
	
	private static function boxMsg(string $innerText)
	{
		echo <<<MSG
				<div style='border:1px;background-color: yellow;'>
				Alert(!): $innerText
				</div>
				MSG;
	}
}
?>