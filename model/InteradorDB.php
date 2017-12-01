<?php
	abstract class InteradorDB
	{
            protected  $con;

            protected final function LimparString($str)
	    {
                $str = trim($str);
	    	$str = strip_tags($str);
	        return preg_replace('/^[\pZ\p{Cc}\x{feff}]+|[\pZ\p{Cc}\x{feff}]+$/ux', '', $str);
	    }
	}
?>