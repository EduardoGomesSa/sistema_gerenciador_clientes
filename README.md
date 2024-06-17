# Sistema para Gerenciamento de Clientes

## Sobre o projeto

Esse sistema foi projeto para realizar as operações CRUDs básicas sobre os usuários, tais como criação, atualização, exclusão e leitura de dados. Para um melhor controle foi definido o acesso por nível de usuário a algumas funcionalidades, que exigem mais cautela, tais como alterações de dados na base. 

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
:construction:Obs: Para adicionar uma imagem inclua o campo ``path_photo`` e mude o modo de envio para Multpart Form

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
:construction:Obs: Para adicionar uma imagem inclua o campo ``path_photo`` e mude o modo de envio para Multpart Form

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
