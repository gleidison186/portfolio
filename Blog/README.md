# Documentação do Trabalho #

*DS120 - Desenvolvimento Web 1*

Prof. Alexander Robert Kutzke
<br><br>


Nome: Guilherme Vinicius Valério<br>
GRR: 20184636

Nome: Gleidison dos Santos Novais<br>
GRR: 20186250

Nome: Eduardo Gabriel<br>
GRR: 20184771


**Tema:** Blog de Entretenimento Virtual

**Definição:** Um site onde novos usuários podem se cadastrar e fazer postagens e comentá-las, podem configurar sua conta, apagar
suas postagens ou comentários.

**Linguagens Usadas:** HTML, CSS, JavaScript e PHP.<br>
Banco de Dados Usado: MySql.

- **Implementação HTML:**
A implementação da linguagem HTML foi feita de forma simples usando as tags padrões da própria linguagem.

- **Implementação CSS:**
A implementação da linguagem CSS foi feita no seu padrão e em algumas partes do código foi feito o uso do framework
Bootstrap que auxilia no design do site.

- **Implementação JavaScript:**
A Implementação do JavaScript na sua maior parte foi na validação de dados do cadastro do usuário, onde ele verifica
se o usuário realmente digitou algo. E também foi implementado na parte de alteração de dados, quando os dados são salvos
no banco de dados depois da alterção, surge uma caixa falando que os dados foram alterados com sucesso.

- **Implementação PHP:**
A implementação da linguagem PHP foi a maior parte do código. Foi usada para validação de dados digitados pelo
usuário, validação de imagens enviadas pelo usuário, inserção no banco de dados, alteração no banco de dados e
exclusão no banco de dados.

- **Implementação MySql:**
A implementação do Banco de Dados foi feita no MySql. Foram criadas três tabelas: Login(onde ficam armazenados os dados
do usuário), posts(são armazenadas as postagens feitas pelos usuários) e comentarios(são armazenados os comentarios que
cada usuário fez).


#### Funcionamento ####
 - **Página de Cadastro:** Esta página tem o intuito de cadastro de novos usuários. Nela é preenchido todos os campos que são validados
  pelo PHP e se tudo estiver correto as informações preenchidas pelo usuário são gravadas no banco de dados na tabela *Login*.
  A validação da imagem é um pouco diferente dos outros campos, são validados a extensão e o tamanho da imagem, e se estiver correto a
  imagem é salva no servidor e o caminho dela é salva na tabela.
 - **Página de Login:** Esta página tem o intuito de validar as informações que usuário passou, de certa forma que essas
 informações estejam gravadas no banco de dados na tabela Login. Caso as informações estejam corretas é iniciada uma nova sessão e o
 usuário é direcionado para a página inicial do blog.
 - **Página Inicial:** Esta página tem intuito de mostrar as postagens dos usuários e também a criação de novas postagens.
 Na criação de postagens o usuário informa um título, texto e opcionalmente uma imagem que são validados e, se estiver tudo certo,
 gravado no banco de dados na tabela *posts*. Nesta mesma página quando o usuário clica em algum título de alguma postagem ele
é direcionado para a mesma, onde a página vai apresentar o título, texto, imagem(caso tenha) e comentários(caso alguém tenha comentado
  antes). Nessa página o usuário poderá fazer as seguintes ações: Fazer comentários, excluir seus comentários e excluir a postagem caso
  seja dele.
 - **Página de Alteração de dados:** Esta página tem intuito de alteração de email e senha. Nela vão ter duas opções - de alteração
 de email e de alteração de senha - onde usuário poderá selecionar a opção desejada.
 - **Página de Alteração de Email:** Esta página tem o intuito de alterar o email do usuário, onde o usuário digita o novo email
 desejado, a confirmação do mesmo e a sua senha. Essas informações são validadas e caso não exista o novo email desejado e ele esteja
 de acordo com as validações e a senha estiver correta o email é alterado, o banco de dados é atualizado, a sessão do usuário é encerrada.
 - **Página de Alteração de Senha:** Esta Página tem o intuito de alterar a senha, onde o usuário digita a nova senha desejada,
 a confirmação da mesma e a senha atual. A senha é validada e se estiver tudo correto a senha é alterada, o banco de dados é
 atualizado e a sessão do usuário é encerrada.

**Tabelas Sql<br>**
 Dados da tabela Login:

 <code>id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,<br>
 name VARCHAR(100) NOT NULL,<br>
 email VARCHAR(100) NOT NULL,<br>
 password VARCHAR(128) NOT NULL,<br>
 created_at DATETIME,<br>
 updated_at DATETIME,<br>
 last_login_at DATETIME,<br>
 last_logout_at DATETIME,<br>
 UNIQUE (email)<br>
 );</code><br>


 Dados da tabela posts:<br>

 <code>id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,<br>
 idUser INT(6) UNSIGNED AUTO_INCREMENT,<br>
 imagem VARCHAR(100),<br>
 CONSTRAINT fkpostlogin FOREIGN KEY (idUser) REFERENCES Login(id)<br>
 );</code><br>

 Dados da tabela  comentarios:<br>

 <code>id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,<br>
 idUserCom INT(6) UNSIGNED AUTO_INCREMENT,<br>
 idPost INT(6) UNSIGNED AUTO_INCREMENT,<br>
 CONSTRAINT fkcomentlogin FOREIGN KEY (idUserCom) REFERENCES Login(id),<br>
 CONSTRAINT fkpostcoment FOREIGN KEY (idPost) REFERENCES posts(id)<br>
 );</code><br>
