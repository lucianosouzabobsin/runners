# Runners

Disponibiliza uma API REST que permite o cadastro de corredores, provas, vincular o corredor a prova e seu tempo e listagem com filtros, somente com autorização token.
Para enviar o token na solicitação, você pode fazer isso enviando um atributo api_token no payload ou como um token no header:

Authorization: Bearer 0syHnl0Y9jOIfszq11EC2CBQwCfObmvscrZYo5o2ilZPnohvndH797nDNyAT

## Métodos
Requisições para a API devem seguir os verbos:
| Método | Descrição |
|---|---|
| `GET` | Retorna informações de um ou mais registros. |
| `POST` | Utilizado para criar um novo registro. |

## Respostas

| Código | Descrição |
|---|---|
| `200` | Requisição executada com sucesso (success).|
| `201` | Requisição executada com sucesso, inserção de dados (success).|
| `401` | Dados de acesso inválidos (Unauthenticated).|
| `404` | Registro pesquisado não encontrado (Resource not found).|


## Tecnologias

* Laravel Framework 7.30.4
* Mysql-5.7
* Docker

## Serviços Usados

* Github
* Postman

## Getting started

* Para criar o ambiente Docker e o container:
>    $ cd docker
* Instale o ambiente:
>    $ docker-compose up -d
* Edite o arquivo hosts e adicione a linha abaixo na fila de links para executar como runner.local:
>    $ sudo nano /etc/hosts
>
>    127.0.1.1       runners.local
* Acesse o bash do container:
>    $ docker exec -it runners bash
* Dentro do bash, execute os seguintes comandos para criar o banco de dados e suas migrations e seeders:
>    $ chmod 777 -R runners/
>    
>    $ cd runners/
>
>    $ php artisan db:create
>
>	 $ php artisan migrate
>
>	 $ php artisan db:seed
>	 
* Checar os testes (se quiser)
>    $ composer tests

## Como usar

Você pode usar o Postman para utilizar esta API.


## Recursos

### Inserir Prova

#### Request

`POST /api/add.competition/`

    curl --location --request POST 'http://runners.local/api/add.competition?type=10&date=2021-01-26&hour_init=08:00:00&min_age=18&max_age=25' \ --header 'Authorization: Bearer 0syHnl0Y9jOIfszq11EC2CBQwCfObmvscrZYo5o2ilZPnohvndH797nDNyAT'


### Listar Provas

#### Request

`GET /api/list.competition/`

    curl --location --request GET 'http://runners.local/api/list.competition' \ --header 'Authorization: Bearer 0syHnl0Y9jOIfszq11EC2CBQwCfObmvscrZYo5o2ilZPnohvndH797nDNyAT'

### Inserir Corredor

#### Request

`POST /api/add.runner/`

    curl --location --request POST 'http://runners.local/api/add.runner?name=Joana&cpf=8888888885&birthday=2001-02-28' \ --header 'Authorization: Bearer 0syHnl0Y9jOIfszq11EC2CBQwCfObmvscrZYo5o2ilZPnohvndH797nDNyAT'

### Listar Corredores

#### Request

`GET /api/list.runner/`

    curl --location --request GET 'http://runners.local/api/list.runner' \ --header 'Authorization: Bearer 0syHnl0Y9jOIfszq11EC2CBQwCfObmvscrZYo5o2ilZPnohvndH797nDNyAT'

 ### Listar Resultados

 A lista de resultado, pode ser combinada com os parametros type, range_age e competition, sendo estes parametros:
 Type - integer
 range_age - array de duas posições(sendo a primeira com a idade minima e a idade máxima)
 competition - integer

#### Request (por tipo)

`GET /api/report.get.list/`

    curl --location --request GET 'http://runners.local/api/report.get.list?type=10' \ --header 'Authorization: Bearer 0syHnl0Y9jOIfszq11EC2CBQwCfObmvscrZYo5o2ilZPnohvndH797nDNyAT'

#### Request (por tipo e idade)

`GET /api/report.get.list/`

    curl --location --request GET 'http://runners.local/api/report.get.list?range_age=18,25&type=10' \ --header 'Authorization: Bearer 0syHnl0Y9jOIfszq11EC2CBQwCfObmvscrZYo5o2ilZPnohvndH797nDNyAT'

#### Request (por prova)

`GET /api/report.get.list/`

    curl --location --request GET 'http://runners.local/api/report.get.list?competition=1' \ --header 'Authorization: Bearer 0syHnl0Y9jOIfszq11EC2CBQwCfObmvscrZYo5o2ilZPnohvndH797nDNyAT'

#### Request (tudo)

`GET /api/report.get.list/`

    curl --location --request GET 'http://runners.local/api/report.get.list' \ --header 'Authorization: Bearer 0syHnl0Y9jOIfszq11EC2CBQwCfObmvscrZYo5o2ilZPnohvndH797nDNyAT'

## Versionamento

1.0.0.0

## Links

Link do ambiente Docker montado com Apache, PHP7.2 e Mysql utilizado:
* [**lucianobobsin/apache-php7.2-cli**](https://hub.docker.com/repository/docker/lucianobobsin/apache-php7.2-cli)
* [**lucianobobsin/mysql-5.7**](https://hub.docker.com/repository/docker/lucianobobsin/mysql-5.7)

## Autor

* **Luciano Bobsin**: @lucianosouzabobsin (https://github.com/lucianosouzabobsin)
