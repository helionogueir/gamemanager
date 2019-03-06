# GameManager
Dúvidas entre em contato ([Helio Nogueira](mail:helio.nogueir@gmail.com)).

## Deploy
Para executar o projeto basta executar o comando abaixo. Lembrando que o "docker" e o "docker-compose" precisam estar devidamente instalados, e a porta 80 liberada.

```bash
# Dentro da pasta do projeto
docker-compose up
```
Para acessar a aplicação http://localhost. email: __test__ e senha: __test__

## Packages
O projeto está dividido em 3 partes:
- Banco de dados (dbsql);
- Micro-Serviços (ms);
- E Aplicação (web).

### dbsql
O Banco de Dados é o MySQL, lembrando que conforme o volume das informações forem aumentando aconselho utilizar uma solução de cache ou elástica.

### ms
API com serviços. A aplicação web não acessa o banco de dados diretamente, somente através do da API. Para respostas mais complexas será melhor criar uma API Manager. Semelhante a solução que Sensedia comercializa.

### web
Interface web da aplicação. A ideia é manter toda a lógica na API, assim quando mover a aplicação para outra interface (mobile por exemplo) não teremos problemas.

## Arquitetura de Aplicação
Utilizei o [The Clean Architecture](https://blog.cleancoder.com/uncle-bob/2012/08/13/the-clean-architecture.html) do Uncle Bob na aplicação web e nos micro-serviços. 

![The Clean Architecture Image](https://blog.cleancoder.com/uncle-bob/images/2012-08-13-the-clean-architecture/CleanArchitecture.jpg)

A parte da autenticação foi estruturada para funcionar semelhante a autenticação do AWS Amazon cada usuário tem sua credencial de acesso a API. Por isso implementei o login.

## Arquitetura Cloud

- Para VPC podemos utilizar essa implementação https://github.com/helionogueir/basic-aws-cloudformation-vpc.

- Para troca de informação em tempo real podemos utilizar solução semelhantes a o Apache Kafka. Segue um exemplo de como faze-lo na AWS https://github.com/helionogueir/simple-aws-cloudformation-sns;

- E para impletação de API, normalmente utilizo essa implementação https://github.com/helionogueir/aws-cloudformation-api.

## Arquitetura de Testes
Como estou utilizando a "Clean Architecture":
- Todas as classes de negócio que possui integração com alguma aplicação externa está na cama de "Entity";
- Todas as classes de negócio que não possui integração externa foram concentradas na camada "UseCase".

Assim podemos separar sem complicações "Testes de Integração" de "Testes Unitários".

Obs. Os testes estão sendo desenvolvidos!