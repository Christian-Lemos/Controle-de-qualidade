 <form id = "form_cadastro_usuario" onsubmit="return false">
	<label for="login">Login:</label>
	<input type = "text" name = "login" id = "cadastro_usuario_login" placeholder="Digite aqui o login do usuario" />
	<label for="senha">Senha:</label>
	<input type = "password" name = "senha" id = "cadastro_usuario_senha" placeholder="Digite aqui a senha do usuario" />
	<label for="confsenha">Confirmar senha:</label>
	<input type = "password" name = "confsenha" id = "cadastro_usuario_senha2" placeholder="Confirme aqui a senha do usuario" />

	<label for="nome">Nome:</label>
	<input type = "text" name = "nome" id = "cadastro_usuario_nome" placeholder="Digite aqui o nome do usuario" />
	<label for="email">Email:</label>
	<input type = "email" name = "email" id = "cadastro_usuario_email" placeholder="Digite aqui o email do usuario" />
	<label for="admin">Admin:</label>
	<input type = "checkbox" name = "admin" id = "cadastro_usuario_admin" />
	<span id = "aviso"></span>
	<button type = "submit" id = "cadastro_usuario_btn">Cadastrar</button>
</form>