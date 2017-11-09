<?php
	class ProjetoDAO extends InteradorDB
	{
		public function __construct($con)
		{
			$this->con = $con;
		}
		public function AdicionarProjeto($nome, $gerente, $desenvolvedores, $assinaturaContrato)
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
					$stmt = $this->con->prepare("insert into projeto_dev values (?, ?)");
					$stmt->bindValue(1, $resultado[0]);
					$stmt->bindValue(2, $desenvolvedores[$i]);
					$stmt->execute();
				}
				return null;
			}
			catch(PDOException $e)
			{
				return new Erro(50, "Um erro interno ocorreu, tente novamente mais tarde");
			}

		}

		public function getProjetosFiltro($coluna, $ordem, $primeiro, $ultimo)
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
	}

?>