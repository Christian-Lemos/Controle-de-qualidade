<?php

class ConexaoBD
{
    public static function CriarConexao()
    {
        try
        {
            $con = new PDO("mysql: host=localhost;dbname=compa806_qualidade", "root", "");
            
            return $con;
        }
        catch(PDOExCeption $e)
        {
            echo "aqui";
            echo $e->getMessage();
        }

    }
}

?>