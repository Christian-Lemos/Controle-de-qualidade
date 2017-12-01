<?php
	class ProjetoDAO extends InteradorDB
	{
		public function __construct(PDO $con)
		{
			$this->con = $con;
		}
		public function AdicionarProjeto(string $nome, int $gerente, $desenvolvedores, string $assinaturaContrato)
		{
                    
			try
			{
				$nome = parent::LimparString($nome);
				$gerente = parent::LimparString($gerente);
				$assinaturaContrato = parent::LimparString($assinaturaContrato);

				$assinaturaContrato = str_replace('/', '-', $assinaturaContrato);
				$assinaturaContrato = date('Y-m-d', strtotime($assinaturaContrato));
				$assinaturaContrato = strval($assinaturaContrato);
				$gerente = intval($gerente);

				$stmt = $this->con->prepare("insert into projeto(gerente, nome, datainicio) values (?, ?, ?)");
				$stmt->bindValue(1, $gerente);
				$stmt->bindValue(2, $nome);
				$stmt->bindValue(3, $assinaturaContrato);
				$stmt->execute();
				$stmt = $this->con->prepare("select id as teste from projeto where id = LAST_INSERT_ID()");
				$stmt->execute();

				$resultado = $stmt->fetch(PDO::FETCH_NUM);
				for($i = 0; $i < count($desenvolvedores); $i++)
				{
					$desenvolvedores[$i] = parent::LimparString($desenvolvedores[$i]);
				
					$stmt = $this->con->prepare("insert into projeto_dev(idprojeto, idusuario) values (?, ?)");
					$stmt->bindValue(1, $resultado[0]);
					$stmt->bindValue(2, $desenvolvedores[$i]);
					$stmt->execute();
				}
			}
			catch(Exception $e)
			{
				throw new Exception("Um erro interno ocorreu. Tente novamente mais tarde");
			}

		}

		public function encontrarProjeto(int $id)
		{
			$stmt = $this->con->prepare("select * from projeto where id = ? limit 1");
			$stmt->bindValue(1, $id);
			$stmt->execute();
			$projeto = $stmt->fetch(PDO::FETCH_OBJ);
			
			$stmt = $this->con->prepare("select * from projeto_dev where idprojeto = ?");
			$stmt->bindValue(1, $id);
			$stmt->execute();
			$devs = array();
			while($linha = $stmt->fetch(PDO::FETCH_OBJ))
			{
				$devs[] = array(
				'idusuario' => $linha->idusuario,
				'nomeusuario' =>$linha->nomeusuario
				);
			}
			$devs = json_encode($devs);

			return new Projeto($projeto->id, $projeto->nome, $projeto->gerente, $projeto->nomegerente, $projeto->datainicio, $projeto->datatermino, $devs);
			
		}
		
		
		public function removerProjeto(int $id)
		{
			$id = parent::LimparString($id);
			$stmt = $this->con->prepare("delete from projeto where id = ?");
			$stmt->bindValue(1, $id);
			$stmt->execute();
			return null;
		}

		public function getProjetosFiltro(string $coluna, string $ordem, int $primeiro, int $ultimo)
		{
			$stmt = $this->con->prepare('select * from projeto order by '.$coluna.' '.$ordem.' limit '.$primeiro.', '.$ultimo);
			$stmt->execute();

			return $stmt;

		}
		
		public function getTotalProjetos()
		{
			$stmt = $this->con->prepare("select count(*) as numero from projeto");
			$stmt->execute();
			$total = $stmt->fetch(PDO::FETCH_OBJ)->numero;
			return $total;
		}

		public function AtualizarNome(int $id, string $novonome)
		{
			$id = parent::LimparString($id);
			$novonome = parent::LimparString($novonome);
			
			$stmt = $this->con->prepare("update projeto set nome = ? where id = ?");
			$stmt->bindValue(1, $novonome);
			$stmt->bindValue(2, $id);
			$stmt->execute();
		}
		
		public function AtualizarGerente(int $id, int $novogerente)
		{
			$id = parent::LimparString($id);
			$novogerente = parent::LimparString($novogerente);
			
			$stmt = $this->con->prepare("update projeto set gerente = ? where id = ?");
			$stmt->bindValue(1, $novogerente);
			$stmt->bindValue(2, $id);
			$stmt->execute();
		}
		
		public function AtualizarDesenvolvedores(int $id, $desenvolvedores)
		{
			$id = parent::LimparString($id);
			
			$stmt = $this->con->prepare("select idusuario from projeto_dev where idprojeto = ?");
			$stmt->bindValue(1, $id);
			$stmt->execute();
			$resultado = $stmt->fetchAll(PDO::FETCH_OBJ);
	
			for($i = 0; $i < count($resultado); $i++)
			{
				$esta = false;
				
				for($j = 0; $j < count($desenvolvedores); $j++)
				{
					if($resultado[$i]->idusuario == $desenvolvedores[$j])
					{
						$esta = true;
						break;
					}
				}
				
				if($esta == false)
				{
					$stmt = $this->con->prepare("delete from projeto_dev where idprojeto = ? and idusuario = ?");
					$stmt->bindValue(1, $id);
					$stmt->bindValue(2, $resultado[$i]->idusuario);
					$stmt->execute();
				}
			}
			
			
			for($i = 0; $i < count($desenvolvedores); $i++)
			{
				$esta = false;
				for($j = 0; $j < count($resultado); $j++)
				{
					if($resultado[$j]->idusuario == $desenvolvedores[$i])
					{
						$esta = true;
						break;
					}
				}
				
				if($esta == false)
				{
					$stmt = $this->con->prepare("insert into projeto_dev(idprojeto, idusuario) values (?, ?)");
					$stmt->bindValue(1, $id);
					$stmt->bindValue(2, $desenvolvedores[$i]);
					$stmt->execute();
				}
			}
		}
		
		
		public function AtualizarDataInicio(int $id, string $novo)
		{
			$id = parent::LimparString($id);
			$novo = parent::LimparString($novo); 
			$novo = str_replace('/', '-', $novo);
			$novo = date('Y-m-d', strtotime($novo));
			$stmt = $this->con->prepare("select datatermino from projeto where id = ?");
			$stmt->bindValue(1, $id);
			$stmt->execute();
			$datatermino = $stmt->fetch(PDO::FETCH_NUM)[0];
			
			$stmt = $this->con->prepare("select datediff(?, ?) as diferenca");
			$stmt->bindValue(1, $datatermino);
			$stmt->bindValue(2, $novo);
			$stmt->execute();
			$diferenca = $stmt->fetch(PDO::FETCH_OBJ)->diferenca;
			
			if($diferenca < 0)
			{
				throw new Exception ("A data de inicio não pode ser maior que a data de término");
			}	
			$stmt = $this->con->prepare("update projeto set datainicio = ? where id = ?");
			$stmt->bindValue(1, $novo);
			$stmt->bindValue(2, $id);
			$stmt->execute();
		}
		public function AtualizarDataTermino(int $id, string $novo)
		{
			$id = parent::LimparString($id);
			$novo = parent::LimparString($novo); 
			$novo = str_replace('/', '-', $novo);
			$novo = date('Y-m-d', strtotime($novo));
			$stmt = $this->con->prepare("select datainicio from projeto where id = ?");
			$stmt->bindValue(1, $id);
			$stmt->execute();
			$datainicio = $stmt->fetch(PDO::FETCH_NUM)[0];
			
			$stmt = $this->con->prepare("select datediff(?, ?) as diferenca");
			$stmt->bindValue(1, $novo);
			$stmt->bindValue(2, $datainicio);
			$stmt->execute();
			$diferenca = $stmt->fetch(PDO::FETCH_OBJ)->diferenca;
			
			if($diferenca < 0)
			{
				throw new Exception ("A data de termino não pode ser menor que a data de término");
			}	
			$stmt = $this->con->prepare("update projeto set datatermino = ? where id = ?");
			$stmt->bindValue(1, $novo);
			$stmt->bindValue(2, $id);
			$stmt->execute();
		}
	}

?>