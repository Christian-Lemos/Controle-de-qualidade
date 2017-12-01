<?php

	class PersonaDAO extends InteradorDB
	{
		public function __construct(PDO $con)
		{
			$this->con = $con;
		}

		public function AdicionarPersona(string $nome, string $descricao, string $imagem)
		{
			$nome = parent::LimparString($nome);
			$descricao = parent::LimparString($descricao);
			$stmt = $this->con->prepare("insert into persona (nome, descricao, imagem) values (?, ?, ?)");
			$stmt->bindValue(1, $nome);
			$stmt->bindValue(2, $descricao);
			$stmt->bindValue(3, $imagem);
			$stmt->execute();
		}

		public function getPersonas()
		{
			$stmt = $this->con->prepare("select * from persona order by id");
			$stmt->execute();
			$personas = array();
			while($linha = $stmt->fetch(PDO::FETCH_OBJ))
			{
				array_push($personas, new Persona($linha->id, $linha->nome, $linha->descricao, $linha->imagem));
			}
                     
			return $personas;
		}
               
                public function getPersona(int $idpersona)
                {        
                    $idpersona = parent::LimparString($idpersona);
                    $stmt = $this->con->prepare("select * from persona where id = ?");
                    $stmt->bindValue(1, $idpersona);
                    $stmt->execute();
                    
                    $linha = $stmt->fetch(PDO::FETCH_OBJ);
                    return new Persona($linha->id, $linha->nome, $linha->descricao, $linha->imagem);
                }
                
                public function atualizarPersona(int $idpersona, string $nome, string $descricao, $imagem)
                {
                    $idpersona = parent::LimparString($idpersona);
                    $nome = parent::LimparString($nome);
                    $descricao = parent::LimparString($descricao);
                    
                    if($imagem == NULL)
                    {
                        $stmt = $this->con->prepare("update persona set nome = ?, descricao = ? where id = ?");
                        $stmt->bindValue(1, $nome);
                        $stmt->bindValue(2, $descricao);
                        $stmt->bindValue(3, $idpersona);
                        $stmt->execute();
                    }
                    else
                    {
                        $stmt = $this->con->prepare("select imagem from persona where id = ?");
                        $stmt->bindValue(1, $idpersona);
                        $stmt->execute();
                        $imagemantiga = $stmt->fetch(PDO::FETCH_OBJ);
                        unlink("../".$imagemantiga->imagem);
                        
                        $stmt = $this->con->prepare("update persona set nome = ?, descricao = ?, imagem = ? where id = ?");
                        $stmt->bindValue(1, $nome);
                        $stmt->bindValue(2, $descricao);
                        $stmt->bindValue(3, $imagem);
                        $stmt->bindValue(4, $idpersona);
                        $stmt->execute();
                    }
                }
                
                public function removerPersona(int $idpersona)
                {
                    $idpersona = parent::LimparString($idpersona);
                    $stmt = $this->con->prepare("select imagem from persona where id = ?");
                    $stmt->bindValue(1, $idpersona);
                    $stmt->execute();
                    
                    unlink("../".$stmt->fetch(PDO::FETCH_OBJ)->imagem);
                    $stmt = $this->con->prepare("delete from persona where id = ?");
                    $stmt->bindValue(1, $idpersona);
                    $stmt->execute();
                    
                    
                }
	}

?>