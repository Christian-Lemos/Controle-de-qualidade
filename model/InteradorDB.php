<?php
    include_once dirname(__FILE__).'/../util/ConexaoBD.php';
    abstract class InteradorDB
    {
        private $con = null;
        
        protected final function criarConexao()
        {
            $this->con = ConexaoBD::CriarConexao();
        }
        
        protected final function fecharConexao()
        {
            unset($this->con);
        }
        
        protected final function LimparString($str)
        {
            $str = trim($str);
            $str = strip_tags($str);
            return preg_replace('/^[\pZ\p{Cc}\x{feff}]+|[\pZ\p{Cc}\x{feff}]+$/ux', '', $str);
        }
        
        public final function getCon()
        {
            return $this->con;
        }
    }
?>