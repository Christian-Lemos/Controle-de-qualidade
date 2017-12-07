<?php
    include_once dirname(__FILE__).'/../model/persona.php';
    include_once dirname(__FILE__)."/../model/InteradorDB.php";
    
    class PersonaDAO extends InteradorDB
    {
        public function AdicionarPersona(string $nome, string $descricao, string $imagem)
        {
            $nome = parent::LimparString($nome);
            $descricao = parent::LimparString($descricao);
            parent::criarConexao();
            $stmt = parent::getCon()->prepare("insert into persona (nome, descricao, imagem) values (?, ?, ?)");
            $stmt->bindValue(1, $nome);
            $stmt->bindValue(2, $descricao);
            $stmt->bindValue(3, $imagem);
            $stmt->execute();
            parent::fecharConexao();
        }

        public function getPersonas()
        {
            parent::criarConexao();
            $stmt = parent::getCon()->prepare("select * from persona order by id");
            $stmt->execute();
            $personas = array();
            while($linha = $stmt->fetch(PDO::FETCH_OBJ))
            {
                array_push($personas, new Persona($linha->id, $linha->nome, $linha->descricao, $linha->imagem));
            }
            parent::fecharConexao();
            return $personas;
        }

        public function getPersona(int $idpersona)
        {        
            $idpersona = parent::LimparString($idpersona);
            parent::criarConexao();
            $stmt = parent::getCon()->prepare("select * from persona where id = ?");
            $stmt->bindValue(1, $idpersona);
            $stmt->execute();

            $linha = $stmt->fetch(PDO::FETCH_OBJ);
            parent::fecharConexao();
            return new Persona($linha->id, $linha->nome, $linha->descricao, $linha->imagem);
        }

        public function atualizarPersona(int $idpersona, string $nome, string $descricao, $imagem)
        {
            $idpersona = parent::LimparString($idpersona);
            $nome = parent::LimparString($nome);
            $descricao = parent::LimparString($descricao);
            parent::criarConexao();
            if($imagem == NULL)
            {
                $stmt = parent::getCon()->prepare("update persona set nome = ?, descricao = ? where id = ?");
                $stmt->bindValue(1, $nome);
                $stmt->bindValue(2, $descricao);
                $stmt->bindValue(3, $idpersona);
                $stmt->execute();
            }
            else
            {
                $stmt = parent::getCon()->prepare("select imagem from persona where id = ?");
                $stmt->bindValue(1, $idpersona);
                $stmt->execute();
                $imagemantiga = $stmt->fetch(PDO::FETCH_OBJ);
                unlink("../../".$imagemantiga->imagem);

                $stmt = parent::getCon()->prepare("update persona set nome = ?, descricao = ?, imagem = ? where id = ?");
                $stmt->bindValue(1, $nome);
                $stmt->bindValue(2, $descricao);
                $stmt->bindValue(3, $imagem);
                $stmt->bindValue(4, $idpersona);
                $stmt->execute();
            }
            parent::fecharConexao();
        }

        public function removerPersona(int $idpersona)
        {
            parent::criarConexao();
            $idpersona = parent::LimparString($idpersona);
            $stmt = parent::getCon()->prepare("select imagem from persona where id = ?");
            $stmt->bindValue(1, $idpersona);
            $stmt->execute();

            unlink("../../".$stmt->fetch(PDO::FETCH_OBJ)->imagem);
            $stmt = parent::getCon()->prepare("delete from persona where id = ?");
            $stmt->bindValue(1, $idpersona);
            $stmt->execute();
            parent::fecharConexao();

        }
    }
?>