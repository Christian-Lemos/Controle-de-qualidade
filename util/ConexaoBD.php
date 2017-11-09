<?php

class ConexaoBD
{
	public static function CriarConexao()
	{
		try
		{
			$con = new PDO("mysql: host=216.172.172.102;dbname=compa806_qualidade", "compa806", "gnF72av15CeqpTI@knl-17");
			return $con;
		}
		catch(PDOExCeption $e)
		{
			echo $e->getMessage();
		}
		
	}
}

?>