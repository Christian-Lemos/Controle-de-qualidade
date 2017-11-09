<?php
	class ProjetoDAO
	{
		private $con;
		public function __construct($con)
		{
			$this->con = $con;
		}
		public function AdicionarProjeto($nome, $gerente, $desenvolvedores, $assinaturaContrato)
		{
			try
			{
				$assinaturaContrato = str_replace('/', '-', $assinaturaContrato);
				$assinaturaContrato = date('Y-m-d', strtotime($assinaturaContrato));
				$assinaturaContrato = strval($assinaturaContrato);
				$gerente = intval($gerente);
				/*echo $nome."<br />";
				echo $assinaturaContrato."<br />";
				echo $gerente."<br />";*/

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
					$stmt = $this->con->prepare("insert into projeto_dev values (?, ?)");
					$stmt->bindValue(1, $resultado[0]);
					$stmt->bindValue(2, $desenvolvedores[$i]);
					$stmt->execute();
				}
				return null;
			}
			catch(PDOException $e)
			{
				//echo "deu erro";
				//$this->con->rollBack();
				return new Erro(50, "Um erro interno ocorreu, tente novamente mais tarde");
			}

		}

		public function getProjetosFiltro($coluna, $ordem, $primeiro, $ultimo)
		{
			$stmt = $this->con->prepare('select * from projeto order by '.$coluna.' '.$ordem.' limit '.$primeiro.', '.$ultimo);
			$stmt->execute();

			return $stmt;

		}
	}

?>