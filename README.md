<h3 align="center">Shelf API</h3>

<p align="center">
   API baseada na construção de uma prateleira de produtos da Época Cosméticos utilizando a API de busca da VTEX como base de dados.
</p>

## :pushpin: Sobre

O objetivo da Shelf API é responder a uma requisição do tipo GET com uma lista de 12 perfumes de forma ordenada pelos produtos mais vendidos, permitindo que seja possível criar uma prateleira de ecommerce no front-end.

Ao receber a requisição, a API dispara uma requisição também do tipo GET para a API de busca da VTEX, trata os dados e devolve uma resposta com a lista de produtos no formato json.

## :pushpin: Tecnologias
- PHP 7.4
- Laravel 8
- Docker

## :pushpin: Documentação
A documentação da API foi construída através da ferramenta Swagger e o deploy do ambiente de testes foi feito no Heroku.
Acesse a documentação <b><a href="http://shelf-api-challenge.herokuapp.com/api/docs">aqui</a></b>.<br>
Obs: é necessário acessar via http devido a uma <a href="https://github.com/DarkaOnLine/L5-Swagger/issues/320">issue</a> do L5-swagger.

## :pushpin: Modelagem do problema
### Consumo da API da VTEX

A ordenação foi realizada diretamente na requisição da API de busca. Foi utilizado o parâmetro <i> O=OrderByPriceDESC</i>, enviado como filtro na URL da requisição:

`$url = epocacosmeticos.vtexcommercestable.com.br/api/catalog_system/pub/products/search/?O=OrderByTopSaleDESC`

Além disso, o parâmetro de busca foi omitido na URL, para não limitar a query da busca. A alternativa utilizada foi enviar no body da requisição o parâmetro <i>'fq'</i>, que indica a categoria dos produtos buscados. Portanto, a busca foi realizada dentre os produtos classificados na categoria Perfumes (1000001).

Para limitar a busca em 12 resultados, foram utilizados os parâmetros <i>_from</i> e <i>_to</i>.

O resultado da requisição deve conter os mesmos 12 primeiros produtos exibidos na página da <a href="https://www.epocacosmeticos.com.br/perfumes?PS=16&O=OrderByTopSaleDESC">Época Cosméticos</a>, ao acessar Perfumes e ordenar pelos mais vendidos.

<p align="center"><img width="80%" src="https://raw.githubusercontent.com/4ngelica/shelf-api/master/src/public/assets/VennDiagram.jpg"></p>

### Tratamento dos dados
Para otimizar o tratamento de dados e não comprometer a velocidade da resposta, foi definida uma lista de parâmetros essenciais para cada produto durante a criação da prateleira. A escolha desses parâmetros foi baseada na interface de prateleira da Época Cosméticos:

- item
- productName
- brand
- imageUrl
- pricesPerSize
  - {size}
      - Price
      - ListPrice

Visto que muitas informações foram omitidas nesse processo, foi implementado um segundo endpoint, que trás uma resposta mais detalhada para cada produto. O parâmetro <i>'item'</i> define esse endpoint para realizar a requisição e indica também a classificação do produto dentro da lista.

Como o intuito do projeto é criar uma API de leitura (não é possível registrar novos produtos ou modificá-los), não foi criada uma rota de autenticação, visto que os dados não são sensíveis e nem restritos.

## :pushpin: Instalação
Para instalar o projeto localmente, é necessário ter o Composer instalado na sua máquina. Para buildar a aplicação com o Docker, também é necessário tê-lo instalado.

Faça o download dos arquivos ou o clone desse repositório: <br>

```sh
git clone https://github.com/4ngelica/shelf-api.git
```
Acesse o diretório src e renomeie o arquivo .env.example para .env.

No mesmo diretório, é necessário rodar o seguinte comando para instalar as dependências:

```sh
composer install
```

### Executando a aplicação sem Docker

No terminal, sirva a aplicação:

```sh
php artisan serve
```

No navegador, acesse a porta onde a aplicação foi servida (Por ex http://localhost:8000/) e clique em Generate Key. Esse comando vai gerar a APP_KEY localizada dentro do arquivo .env.

### Executando a aplicação com Docker
Suba os containers do projeto:

```sh
docker-compose up -d
```
Rode o comando para gerar a APP_KEY no arquivo .env
```sh
docker-compose exec app php artisan key:generate
```

A aplicação poderá ser acessada no endereço: http://localhost:8008/


## :pushpin: Escolha da stack

Foi utilizado o framework Laravel por ter uma vasta gama de funcionalidades built-in para APIS. Ele também deixa o projeto bem estruturado em relação ao MVC e trás recursos para tratamento de excessões.

Também seria interessante utilizar o Lumen (um micro framework do Laravel), visto que deixaria o projeto mais enxuto, trazendo apenas as dependências necessárias para a criação da API.

Como desafio, foi utilizado o Docker. Com a virtualização por container, ele possibilita rodar a aplicação isoladamente. Também é reaproveitável e permite criar aplicações escaláveis.

## :pushpin: Possíveis melhorias
- Criar um versionamento da API;
- Criar um middleware para permitir apenas requisições que contenham os headers <i>Accept: application/json</i> e <i>Content-type: application/json</i>;
- Escrever testes para os endpoints e estruturar a API para passar neles.

## :pushpin: Referências
- [Laravel 8](https://laravel.com/docs/8.x)
- [L5-Swagger](https://github.com/DarkaOnLine/L5-Swagger/wiki)
- [Swagger](https://swagger.io/docs/)
- [EspecializaTI](https://github.com/especializati/setup-docker-laravel)
- [Docker](https://laravel.com/docs/8.x)
