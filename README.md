# Runners
 
Disponibiliza uma API REST que permite o cadastro de corredores, provas, vincular o corredor a prova e seu tempo e listagem com filtros.

## Métodos
Requisições para a API devem seguir os padrões:
| Método | Descrição |
|---|---|
| `GET` | Retorna informações de um ou mais registros. |
| `POST` | Utilizado para criar um novo registro. |
 
## Respostas

| Código | Descrição |
|---|---|
| `200` | Requisição executada com sucesso (success).|
| `201` | Requisição executada com sucesso, inserção de dados (success).|
| `401` | Dados de acesso inválidos.|
| `404` | Registro pesquisado não encontrado (Not found).|

 
## Tecnologias 
 
* Laravel Framework 7.30.4
* Mysql-5.7
* Docker 
 
## Serviços Usados
 
* Github 
* Postman

## Getting started
 
* Para criar o ambiente Docker e o container:
>    $ cd docker/dev/
>    $ docker-compose up -d
* Edite o arquivo hosts e adicione a linha abaixo na fila de links para executar como runner.local:
>    $ sudo nano /etc/hosts
>    
>    127.0.1.1       runners.local
* Acesse o bash do container:
>    $ docker exec -it runners bash
* Dentro do bash, execute os seguintes comandos para criar o banco de dados e suas migrations e seeders:
>    $ cd runners/
>    
>    $ php artisan db:create
>    
>	   $ php artisan migrate
>	   
>	   $ php artisan db:seed
* Checar os testes (se quiser)
>    $ composer tests  
 
## Como usar
 
Você pode usar o Postman para utilizar esta API.
 
 
## Recursos

### Inserir Prova

#### Request

`POST /api/add.competition/`

    curl -i -H 'Accept: application/json' http://runners.local/api/add.competition?type=10&date=2021-01-26&hour_init=08:00:00&min_age=18&max_age=25
    

### Listar Provas

#### Request

`GET /api/list.competition/`

    curl -i -H 'Accept: application/json' http://runners.local/api/list.competition
 
### Inserir Corredor

#### Request

`POST /api/add.runner/`

    curl -i -H 'Accept: application/json' http://runners.local/api/add.runner?name=Graziela&cpf=8888888884&birthday=2001-02-26

### Listar Corredores

#### Request

`GET /api/list.runner/`

    curl -i -H 'Accept: application/json' http://runners.local/api/list.runner
 
 ### Listar Resultados
 
 A lista de resultado, pode ser combinada com os parametros type, range_age e competition, sendo estes parametros:
 Type - integer
 range_age - array de duas posições(sendo a primeira com a idade minima e a idade máxima)
 competition - integer

#### Request por tipo

`POST /api/report.get.list/`

    curl -i -H 'Accept: application/json' http://runners.local/api/report.get.list?type=10

#### Request por tipo e idade

`POST /api/report.get.list/`

    curl -i -H 'Accept: application/json' http://runners.local/api/report.get.list?range_age=18,25&type=10
    
#### Request por prova

`POST /api/report.get.list/`

    curl -i -H 'Accept: application/json' http://runners.local/api/report.get.list?competition=1
    
#### Request de tudo

`POST /api/report.get.list/`

    curl -i -H 'Accept: application/json' http://runners.local/api/report.get.list
 
## Versionamento
 
1.0.0.0
 
 
## Autor
 
* **Luciano Bobsin**: @lucianosouzabobsin (https://github.com/lucianosouzabobsin)
 
 
Please follow github and join us!
Thanks to visiting me and good coding!
