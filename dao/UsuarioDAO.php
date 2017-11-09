<?php
	class UsuarioDAO
	{

		private  $con;

		public function __construct($con)
		{
			$this->con = $con;
		}

		public function getUsuarios()
		{
			$stmt = $this->con->prepare("select id, nome, login, email from usuario order by nome");
			$stmt->execute();

			return $stmt;
		}	

		public function Autenticar($login, $senha)
		{
			$maximas_tentativas = 5;
			$minutos_para_mt = 30;
			$sql = "select ip, tentativas, data_hora from usuario_tentativas where ip = ?";
			$stmt = $this->con->prepare($sql);
			$stmt->bindValue(1, $_SERVER['REMOTE_ADDR']);
			$stmt->execute();
			

			if($stmt->rowCount() > 0)
			{
				$tent_data = $stmt->fetch(PDO::FETCH_NUM);
				$stmt = $this->con->prepare("select TIMESTAMPDIFF(MINUTE, ?, current_timestamp) as tempo");
				$stmt->bindValue(1, $tent_data[2]);
				$stmt->execute();
				$diferenca = $stmt->fetch(PDO::FETCH_OBJ)->tempo;				
				if($diferenca <= $minutos_para_mt && $tent_data[1] >= $maximas_tentativas)
				{
					$valor = $diferenca - $minutos_para_mt;
					$valor = $valor * -1;
					return new Erro(10, "Muitas tentativas em pouco tempo. Por favor, aguarde ".$valor." minuto(s).");
				}
				else if($diferenca > $minutos_para_mt && $tent_data[1] >= $maximas_tentatiavas)
				{
					$stmt = $this->con->prepare("update usuario_tentativas set tentativas = 0 where ip = ?");
					$stmt->bindValue(1, $_SERVER['REMOTE_ADDR']);
					$stmt->execute();
				}

			}

			$login = strtolower($login);
			$senha = hash('sha512', $senha);	
			$sql = "select id, login, nome, email, admin from usuario where login = ? and senha = ?";
			$stmt = $this->con->prepare($sql);
			$stmt->bindValue(1, $login);
			$stmt->bindValue(2, $senha);
			$stmt->execute();

			if($stmt->rowCount() > 0)
			{
				$linha = $stmt->fetch(PDO::FETCH_NUM);
				$stmt = $this->con->prepare("delete from usuario_tentativas where ip = ?");
				$stmt->bindValue(1, $_SERVER['REMOTE_ADDR']);
				$stmt->execute();
				return new Usuario($linha[0], $linha[1], $linha[2], $linha[3], $linha[4]);

			}
			else
			{
				$stmt = $this->con->prepare("select ip, tentativas, data_hora from usuario_tentativas where ip = ?");
				$stmt->bindValue(1,  $_SERVER['REMOTE_ADDR']);
				$stmt->execute();
				
				if($stmt->rowCount() > 0)
				{
					$linha = $stmt->fetch(PDO::FETCH_NUM);
					$stmt = $this->con->prepare("update usuario_tentativas set tentativas = tentativas + 1, data_hora = current_timestamp where ip = ?");
					$stmt->bindValue(1, $linha[0]);
					$stmt->execute();
				}
				else
				{
					$stmt = $this->con->prepare("insert into usuario_tentativas (ip, tentativas, data_hora) values (?, 1, current_timestamp)");
					$stmt->bindValue(1, $_SERVER['REMOTE_ADDR']);
					$stmt->execute();
					
				}
				
				return new Erro(11, "Usuário ou senha incorretos");

			}

		}

		public function AdicionarUsuario($login, $nome, $senha, $email, $admin)
		{

			$valido = $this->ChecarUnicos($login, $email);
			if($valido != null)
			{
				return $valido;
			}

			try
			
			{
				$login = strtolower($login);
				$email = strtolower($email);
				$senha = hash('sha512', $senha);
				$stmt = $this->con->prepare("insert into usuario (login, nome, senha, email, admin) values (?, ?, ?, ?, ?)");
				$stmt->bindValue(1, $login);
				$stmt->bindValue(2, $nome);
				$stmt->bindValue(3, $senha);
				$stmt->bindValue(4, $email);
				$stmt->bindValue(5, $admin);
				$stmt->execute();
				return null;
			}
			catch(PDOException $e)
			{
				$e->getMessage();
			}
		}
		
		public function removerUsuario($id)
		{
			if($id == $_SESSION['usuario']->getID())
			{
				return new Erro(30, 'Não pode excluir o usuário atual logado');
			}
			
			$stmt = $this->con->prepare("delete from usuario where id = ?");
			$stmt->bindValue(1, $id);
			$stmt->execute();
			return null;
		}

		public function AtualizarLogin($id ,$login)
		{
			$stmt = $this->con->prepare("select login from usuario where id != ? and login = ? limit 1");
			$stmt->bindValue(1, $id);
			$stmt->bindValue(2, $login);
			$stmt->execute();
			if($stmt->rowCount() > 0)
			{
				return new Erro(20, "Login já cadastrado");
			}

			$stmt = $this->con->prepare("update usuario set login = ? where id = ?");
			$stmt->bindValue(1, $login);
			$stmt->bindValue(2, $id);
			$stmt->execute();

			if($login == $_SESSION['usuario']->getLogin())
			{
				$_SESSION['usuario']->setLogin($login);
			}
			return null;
		}

		public function AtualizarEmail($id ,$email)
		{
			$email = strtolower($email);
			$stmt = $this->con->prepare("select email from usuario where id != ? and email = ? limit 1");
			$stmt->bindValue(1, $id);
			$stmt->bindValue(2, $email);
			$stmt->execute();
			if($stmt->rowCount() > 0)
			{
				return new Erro(21, "Email já cadastrado");
			}

			$stmt = $this->con->prepare("update usuario set email = ? where id = ?");
			$stmt->bindValue(1, $email);
			$stmt->bindValue(2, $id);
			$stmt->execute();

			if($email == $_SESSION['usuario']->getEmail())
			{
				$_SESSION['usuario']->setEmail($email);
			}
			return null;
		}
		public function AtualizarSenha($id ,$senha)
		{
			$senha = hash('SHA512', $senha);
			$stmt = $this->con->prepare("update usuario set senha = ? where id = ?");
			$stmt->bindValue(1, $senha);
			$stmt->bindValue(2, $id);
			$stmt->execute();
			return null;
		}



		public function AtualizarNome($id, $nome)
		{
			$stmt = $this->con->prepare("update usuario set nome = ? where id = ?");
			$stmt->bindValue(1, $nome);
			$stmt->bindValue(2, $id);
			$stmt->execute();

			if($nome == $_SESSION['usuario']->getNome())
			{
				$_SESSION['usuario']->setNome($nome);
			}
			return null;
		}

		public function AtualizarAdmin($id, $admin)
		{
			if($admin == false && $_SESSION['usuario']->getID() == $id && $_SESSION['usuario']->getAdmin() == 1)
			{
				return new Erro(31, "Não se pode tirar o privilégio administrador na conta administradora em uso");
			}

			$stmt = $this->con->prepare("update usuario set admin = ? where id = ?");
			$stmt->bindValue(1, $admin);
			$stmt->bindValue(2, $id);
			$stmt->execute();
			
			return null;
		}
		

		public function getUsuariosFiltro($coluna, $ordem, $primeiro, $ultimo)
		{
			$stmt = $this->con->prepare('select id, login, nome, email, admin from usuario order by '.$coluna.' '.$ordem.' limit '.$primeiro.', '.$ultimo);
			$stmt->execute();

			return $stmt;

		}

		public function encontrarUsuario($id)
		{
			$stmt = $this->con->prepare("select id, login, nome, email, admin from usuario where id = ?");
			$stmt->bindValue(1, $id);
			$stmt->execute();
			$linha = $stmt->fetch(PDO::FETCH_NUM);

			return new Usuario($linha[0], $linha[1], $linha[2], $linha[3], $linha[4]);
		}

		public function getTotalUsuarios()
		{
			$stmt = $this->con->prepare("select count(*) as numero from usuario");
			$stmt->execute();
			$total = $stmt->fetch(PDO::FETCH_OBJ)->numero;
			return $total;
		}	

		private function ChecarUnicos($login, $email)
		{
			$email = strtolower($email);
			$stmt = $this->con->prepare("select login from usuario where login = ? limit 1");
			$stmt->bindValue(1, $login);
			$stmt->execute();

			if($stmt->rowCount() > 0)
			{
				return new Erro(20, "Login já cadastrado");
			}

			$stmt = $this->con->prepare("select email from usuario where email = ? limit 1");
			$stmt->bindValue(1, $email);
			$stmt->execute();
			if($stmt->rowCount() > 0)
			{
				return new Erro(21, "Email já cadastrado");
			}

			return null;
		}

	}
?>