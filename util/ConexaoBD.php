<?php

class ConexaoBD
{
	public static function CriarConexao()
	{
		try
		{
			$con = new PDO("mysql: host=216.172.172.102;dbname=base", "usuario", "senha");
			return $con;
		}
		catch(PDOExCeption $e)
		{
			echo $e->getMessage();
		}
		
	}
}

?>