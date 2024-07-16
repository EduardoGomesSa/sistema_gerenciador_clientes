# Teste Prático de Seleção para Estagiário Back-end (Laravel/PHP) 🔧

Olá candidato(a)!

Seja bem-vindo(a) ao desafio de desenvolvimento Back-end da VOKERÊ. Estamos em busca de um talento para a vaga de Estagiário de Back-end com conhecimentos em Laravel e PHP. Este desafio visa avaliar suas habilidades técnicas no desenvolvimento de aplicações web, bem como sua capacidade de trabalhar com banco de dados.

## Tarefa: 📋

Desenvolva um sistema de gerenciamento de clientes com as seguintes funcionalidades principais:

### Funcionalidades Gerais
- **Autenticação e Autorização**: Registro e login de usuários. Você pode utilizar algum starter kit do Laravel, como [Sanctum](https://laravel.com/docs/11.x/sanctum), [Jetstream](https://jetstream.laravel.com/2.x/introduction.html) ou [Breeze](https://laravel.com/docs/11.x/starter-kits#laravel-breeze).
- **CRUD de Clientes**: Implementar funcionalidades de Cadastro, Leitura, Atualização e Exclusão de clientes.
- **Cadastro de Endereços**: Permitir o cadastro de endereços associados a cada cliente.
- **Listagem de Clientes**: Listar clientes com opções de busca por nome.

### Detalhamento das Funcionalidades

#### Dados dos Usuários
- Nome
- CPF (Deve validar CPF e garantir unicidade)
- Email
- Senha
- Data de Nascimento (Deve ser formatada)
- Endereço Completo (Rua, Número, Complemento, Bairro, Cidade, Estado, CEP)
- Foto (Opcional)

#### Funcionalidades por Nível de Acesso

**Cliente**
- Atualização de Dados Pessoais (incluindo foto)
- Visualização de Informações

**Gestor**
- Cadastro, Edição e Exclusão de Clientes
- Listagem de Clientes com Filtro por Nome e Data de Cadastro

**Administrador**
- Todas as funcionalidades de um Gestor

#### Listagem de Clientes
- Filtros: Nome e Data de Cadastro
- Colunas: ID, Nome, Data de Nascimento, Data de Cadastro

## Requisitos Técnicos: 🛠️

- Todos os métodos que utilizam banco de dados devem ser implementados utilizando Eloquent.
- As datas devem ser formatadas apropriadamente para exibição.

## Critérios de Avaliação: 📝

- Qualidade do código: organização, legibilidade e boas práticas.
- Funcionalidade: a aplicação deve cumprir os requisitos propostos.
- Uso de Eloquent: deve ser utilizado para todas as operações com banco de dados.

# Sistema para Gerenciamento de Clientes

## Tecnologias e padrões utilizados
- ``Laravel 11``
- ``Eloquent ORM``
- ``PHP``
- ``MySQL``
- ``MVC``
- ``Insomnia``
- ``PHPMyAdmin``
## Comandos para inicialização
Instala as dependências e pacotes do projeto
```bash
  composer install
```
Renomeie o arquivo .env.example para ``.env`` e gere uma nova chave da API
```bash
  php artisan key:generate
```
Executa as migrations, criando ou atualizando o banco e tabelas no banco de dados 
```bash
  php artisan migrate
```
Executa o projeto, tornando-o acessível
```bash
  php artisan serve
```

## Endpoints
post `` /api/login`` Realiza o login no sistema, retornando um token para acesso a outras rotas 
```bash
{
    "email": "exemplo@exemplo.com",
    "password": "exemplo"
}
```
post ``/api/users`` Realiza a criação de novos usuários no sistema 
```bash
{
    {
        "name": "Exemplo",
        "email": "example@example.com",
        "password": "example",
        "cpf": "00000000000",
        "birth_date": "1991-04-08",
        "registration_date": "2024-03-13",
        "address": {
            "cep": "65800000",
            "state": "Ma",
            "city": "Cidade",
            "neighborhood": "Bairro",
            "street": "Rua X",
            "number": "111",
            "complement": "Complemento do endereco"
        }
    }
}
```
ℹ️ Obs: Para adicionar uma imagem inclua o campo ``path_photo`` e mude o modo de envio para Multpart Form

post ``/api/users`` Realiza a atualização de um usuário do sistema 
```bash
{
    "id": "1",
    "name": "Novo Nome",
    "cpf": "00000000001",
    "email":"novo.email@novoemail.com",
    "birth_date": "2000-12-04",
    "password":"nova.senha"
}
```
ℹ️ Obs: Para adicionar uma imagem inclua o campo ``path_photo`` e mude o modo de envio para Multpart Form

delete ``/api/users`` Realiza a exclusão de um usuário do sistema 
```bash
{
    "id":1
}
```
get ``/api/users/getbyname`` Realiza a busca de usuários do sistema pelo nome 
```bash
{
    "name": "Nome usuario"
}
```
get ``/api/users/getByRegistrationDate`` Realiza a busca de usuários do sistema pela data de cadastro dos mesmos 
```bash
{
    "registration_date": "2024-03-13"
}
```
get ``/api/users/getById`` Realiza a busca de usuários do sistema pelo id 
```bash
{
    "id":1
}
```

## Arquivos disponíveis 
- Json contendo os logins dos usuários já cadastrados
- Export do insomnia contendo os endpoints
- Export do banco de dados
  
  ℹ️ Todos os estão salvos na pasta ``others`` localizada na raiz do projeto
