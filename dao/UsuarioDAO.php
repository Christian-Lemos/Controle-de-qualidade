<?php
    include_once dirname(__FILE__)."/../model/InteradorDB.php";
    include_once dirname(__FILE__)."/../model/Usuario.php";
    
    class UsuarioDAO extends InteradorDB
    {
        public function getUsuarios()
        {
            parent::criarConexao();
            $stmt = parent::getCon()->prepare("select id, nome, login, email, admin from usuario order by nome");
            $stmt->execute();
            $usuarios = array();
            while($linha = $stmt->fetch(PDO::FETCH_OBJ))
            {
                $usuario = new Usuario($linha->id, $linha->login,  $linha->nome, $linha->email, $linha->admin);
                $usuarios[] = $usuario;
            }
            parent::fecharConexao();

            //$usuarios = json_encode($usuarios);
            return $usuarios;
        }	

        public function Autenticar(string $login, string $senha)
        {
            $login = parent::LimparString($login);
            $maximas_tentativas = 5;
            $minutos_para_mt = 30;
            $sql = "select ip, tentativas, data_hora from usuario_tentativas where ip = ?";
            parent::criarConexao();
            $stmt = parent::getCon()->prepare($sql);
            $stmt->bindValue(1, $_SERVER['REMOTE_ADDR']);
            $stmt->execute();
            if($stmt->rowCount() > 0)
            {
                $tent_data = $stmt->fetch(PDO::FETCH_NUM);
                $stmt = parent::getCon()->prepare("select TIMESTAMPDIFF(MINUTE, ?, current_timestamp) as tempo");
                $stmt->bindValue(1, $tent_data[2]);
                $stmt->execute();
                $diferenca = $stmt->fetch(PDO::FETCH_OBJ)->tempo;				
                if($diferenca <= $minutos_para_mt && $tent_data[1] >= $maximas_tentativas)
                {
                    $valor = $diferenca - $minutos_para_mt;
                    $valor = $valor * -1;
                    throw new Exception("Muitas tentativas em pouco tempo. Por favor, aguarde ".$valor." minuto(s).");
                }
                else if($diferenca > $minutos_para_mt && $tent_data[1] >= $maximas_tentatiavas)
                {
                    $stmt = parent::getCon()->prepare("update usuario_tentativas set tentativas = 0 where ip = ?");
                    $stmt->bindValue(1, $_SERVER['REMOTE_ADDR']);
                    $stmt->execute();
                }
            }
            $login = strtolower($login);
            $sql = "select id, login, nome, email, admin, senha from usuario where login = ? limit 1";
            $stmt = parent::getCon()->prepare($sql);
            $stmt->bindValue(1, $login);
            $stmt->execute();
            $linha = $stmt->fetch(PDO::FETCH_NUM);
            if($stmt->rowCount() > 0 && password_verify($senha, $linha[5]) == true)
            {
                $stmt = parent::getCon()->prepare("delete from usuario_tentativas where ip = ?");
                $stmt->bindValue(1, $_SERVER['REMOTE_ADDR']);
                $stmt->execute();
                return new Usuario($linha[0], $linha[1], $linha[2], $linha[3], $linha[4]);
                parent::fecharConexao();
            }
            else
            {
                $stmt = parent::getCon()->prepare("select ip, tentativas, data_hora from usuario_tentativas where ip = ?");
                $stmt->bindValue(1,  $_SERVER['REMOTE_ADDR']);
                $stmt->execute();

                if($stmt->rowCount() > 0)
                {
                    $linha = $stmt->fetch(PDO::FETCH_NUM);
                    $stmt = parent::getCon()->prepare("update usuario_tentativas set tentativas = tentativas + 1, data_hora = current_timestamp where ip = ?");
                    $stmt->bindValue(1, $linha[0]);
                    $stmt->execute();
                }
                else
                {
                    $stmt = parent::getCon()->prepare("insert into usuario_tentativas (ip, tentativas, data_hora) values (?, 1, current_timestamp)");
                    $stmt->bindValue(1, $_SERVER['REMOTE_ADDR']);
                    $stmt->execute();
                }
                throw new Exception("Usuário ou senha incorretos");
                parent::fecharConexao();
            }
        }

        public function AdicionarUsuario(string $login, string $nome, string $senha, string $email, bool $admin)
        {
            $login = parent::LimparString($login);
            $nome = parent::LimparString($nome);
            $email = parent::LimparString($email);

            $valido = $this->ChecarUnicos($login, $email);
            if($valido != null)
            {
                throw new Exception ($valido);
            }
            try
            {
                $login = strtolower($login);
                $email = strtolower($email);
                $senha = password_hash($senha, PASSWORD_DEFAULT);
                parent::criarConexao();
                $stmt = parent::getCon()->prepare("insert into usuario (login, nome, senha, email, admin) values (?, ?, ?, ?, ?)");
                $stmt->bindValue(1, $login);
                $stmt->bindValue(2, $nome);
                $stmt->bindValue(3, $senha);
                $stmt->bindValue(4, $email);
                $stmt->bindValue(5, $admin);
                $stmt->execute();
                parent::fecharConexao();
            }
            catch(PDOException $e)
            {
                $e->getMessage();
                parent::fecharConexao();
            }
        }

        public function removerUsuario(int $id)
        {

            $id = parent::LimparString($id);
            if($id == $_SESSION['usuario']->getID())
            {
               throw new Exception ("Não pode excluir o usuário atual logado");
            }
            parent::criarConexao();
            $stmt = parent::getCon()->prepare("delete from usuario where id = ?");
            $stmt->bindValue(1, $id);
            $stmt->execute();
            parent::fecharConexao();
        }

        public function AtualizarLogin(int $id , string $login)
        {
            $id = parent::LimparString($id);
            $login = parent::LimparString($login);
            parent::criarConexao();
            $stmt = parent::getCon()->prepare("select login from usuario where id != ? and login = ? limit 1");
            $stmt->bindValue(1, $id);
            $stmt->bindValue(2, $login);
            $stmt->execute();
            if($stmt->rowCount() > 0)
            {
                parent::fecharConexao();
                throw new Exception("Login já cadastrado");
            }

            $stmt = parent::getCon()->prepare("update usuario set login = ? where id = ?");
            $stmt->bindValue(1, $login);
            $stmt->bindValue(2, $id);
            $stmt->execute();

            if($login == $_SESSION['usuario']->getLogin())
            {
                $_SESSION['usuario']->setLogin($login);
            }
            parent::fecharConexao();
        }

        public function AtualizarEmail(int $id , string $email)
        {
            $id = parent::LimparString($id);
            $email = parent::LimparString($email);
            $email = strtolower($email);
            parent::criarConexao();
            $stmt = parent::getCon()->prepare("select email from usuario where id != ? and email = ? limit 1");
            $stmt->bindValue(1, $id);
            $stmt->bindValue(2, $email);
            $stmt->execute();
            if($stmt->rowCount() > 0)
            {
                parent::fecharConexao();
                throw new Exception("Email já cadastrado");
            }

            $stmt = parent::getCon()->prepare("update usuario set email = ? where id = ?");
            $stmt->bindValue(1, $email);
            $stmt->bindValue(2, $id);
            $stmt->execute();

            if($email == $_SESSION['usuario']->getEmail())
            {
                $_SESSION['usuario']->setEmail($email);
            }
            parent::fecharConexao();
        }
        public function AtualizarSenha(int $id, string $senha)
        {
            $id = parent::LimparString($id);
            $senha = password_hash($senha, PASSWORD_DEFAULT);
            parent::criarConexao();
            $stmt = parent::getCon()->prepare("update usuario set senha = ? where id = ?");
            $stmt->bindValue(1, $senha);
            $stmt->bindValue(2, $id);
            $stmt->execute();
            parent::fecharConexao();
        }



        public function AtualizarNome(int $id, string $nome)
        {
            $id = parent::LimparString($id);
            $nome = parent::LimparString($nome);
            parent::criarConexao();
            $stmt = parent::getCon()->prepare("update usuario set nome = ? where id = ?");
            $stmt->bindValue(1, $nome);
            $stmt->bindValue(2, $id);
            $stmt->execute();

            if($nome == $_SESSION['usuario']->getNome())
            {
                $_SESSION['usuario']->setNome($nome);
            }
            parent::fecharConexao();
        }

        public function AtualizarAdmin(int $id, string $admin)
        {
            $id = parent::LimparString($id);
            if($admin == false && $_SESSION['usuario']->getID() == $id && $_SESSION['usuario']->getAdmin() == 1)
            {
                throw new Exception("Não se pode tirar o privilégio administrador na conta administradora em uso");
            }
            parent::criarConexao();
            $stmt = parent::getCon()->prepare("update usuario set admin = ? where id = ?");
            $stmt->bindValue(1, $admin);
            $stmt->bindValue(2, $id);
            $stmt->execute();
             parent::fecharConexao();
        }


        public function getUsuariosFiltro(string $coluna, string $ordem, int $primeiro, int $ultimo)
        {
            $coluna = parent::LimparString($coluna);
            $ordem = parent::LimparString($ordem);
            $primeiro = parent::LimparString($primeiro);
            $ultimo = parent::LimparString($ultimo);
            parent::criarConexao();
            $stmt = parent::getCon()->prepare('select id, login, nome, email, admin from usuario order by '.$coluna.' '.$ordem.' limit '.$primeiro.', '.$ultimo);
            $stmt->execute();
            $usuarios = array();
            while($linha = $stmt->fetch(PDO::FETCH_OBJ))
            {
                $usuarios[] = new Usuario($linha->id, $linha->login,  $linha->nome, $linha->email, $linha->admin);
            }
            parent::fecharConexao();
            return $usuarios;
        }

        public function encontrarUsuario(int $id)
        {
            $id = parent::LimparString($id);
            parent::criarConexao();
            $stmt = parent::getCon()->prepare("select id, login, nome, email, admin from usuario where id = ? limit 1");
            $stmt->bindValue(1, $id);
            $stmt->execute();
            $linha = $stmt->fetch(PDO::FETCH_NUM);

            return new Usuario($linha[0], $linha[1], $linha[2], $linha[3], $linha[4]);
        }

        public function getTotalUsuarios()
        {
            parent::criarConexao();
            $stmt = parent::getCon()->prepare("select count(*) as numero from usuario");
            $stmt->execute();
            $total = $stmt->fetch(PDO::FETCH_OBJ)->numero;
            return $total;
             parent::fecharConexao();
        }	

        private function ChecarUnicos(string $login, string $email)
        {
            $login = parent::LimparString($login);
            $email = parent::LimparString($email);
            $email = strtolower($email);
            parent::criarConexao();
            $stmt = parent::getCon()->prepare("select login from usuario where login = ? limit 1");
            $stmt->bindValue(1, $login);
            $stmt->execute();

            if($stmt->rowCount() > 0)
            {
                 parent::fecharConexao();
                return "Login já cadastrado";
            }

            $stmt = parent::getCon()->prepare("select email from usuario where email = ? limit 1");
            $stmt->bindValue(1, $email);
            $stmt->execute();
            if($stmt->rowCount() > 0)
            {
                 parent::fecharConexao();
                return "Email já cadastrado";
            }
            parent::fecharConexao();
            return null;
        }
    }
?>