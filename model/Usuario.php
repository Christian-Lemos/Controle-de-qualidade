<?php
	class Usuario
	{
		private $id;
		private $login;
		private $nome;
		private $email;
		private $admin;
		public function __construct($id, $login ,$nome, $email, $admin)
		{
			$this->id = $id;
			$this->login = $login;
			$this->nome = $nome;
			$this->email = $email;
			$this->admin = $admin;
		}

		public function getID()
		{
			return $this->id;
		}

		public function getLogin()
		{
			return $this->login;
		}
		public function getNome()
		{
			return $this->nome;
		}

		public function getEmail()
		{
			return $this->email;
		}

		public function getAdmin()
		{
			return $this->admin;
		}
		public function setLogin($login)
		{
			$this->login = $login;
		}

		public function setNome($nome)
		{
			$this->nome = $nome;
		}
		public function setEmail($email)
		{
			$this->email = $email;
		}
		public function setAdmin($admin)
		{
			$this->admin = $admin;
		}

	}

?>