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

## :pushpin: Documentação
A documentação da API foi construída através da ferramenta Swagger e o deploy do ambiente de testes foi feito no Heroku.
Acesse a documentação <b><a href="http://shelf-api-challenge.herokuapp.com/api/docs">aqui</a></b>.

## :pushpin: Modelagem do problema
### Consumo da API da VTEX

A ordenação foi realizada diretamente na requisição da API de busca. Foi utilizado o parâmetro <i> O=OrderByPriceDESC</i>, enviado como filtro na URL da requisição:

http://epocacosmeticos.vtexcommercestable.com.br/api/catalog_system/pub/products/search/?O=OrderByTopSaleDESC

Além disso, o parâmetro de busca foi omitido na URL, para não limitar a query da busca. A alternativa utilizada foi enviar no body da requisição o parâmetro <i>'fq'</i>, que indica a categoria dos produtos buscados. Portanto, a busca foi realizada dentre os produtos classificados na categoria Perfumes (1000001).

Para limitar a busca em 12 resultados, foram utilizados os parâmetros <i>_from</i> e <i>_to</i>.

<center><img width="80%" src="https://raw.githubusercontent.com/4ngelica/shelf-api/master/public/assets/VennDiagram.jpg"></center>

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
Para instalar o projeto localmente, é necessário ter o Composer e o PHP instalado na sua máquina.

Faça o download dos arquivos ou o clone desse repositório: <br>

`git clone https://github.com/4ngelica/shelf-api.git`

Uma vez clonado, é necessário rodar o seguinte comando para instalar as dependências:

`composer install` <br>

Renomeie o arquivo .env.example para .env

• No terminal, dentro da pasta do projeto, sirva a aplicação:

`php artisan serve` <br>

Acesse localhost:8000 no navegador e clique em Generate Key.

## :pushpin: Escolha da stack

Foi utilizado o framework Laravel por ter uma vasta gama de funcionalidades built-in para APIS. Ele também deixa o projeto bem estruturado em relação ao MVC e trás recursos para tratamento de excessões.

Também seria interessante utilizar o Lumen (um micro framework do Laravel), visto que deixaria o projeto mais enxuto, trazendo apenas as dependências necessárias para a criação da API.

## :pushpin: Possíveis melhorias
- Criação de versionamento da API;
- Criação de um middleware para permitir apenas requisições que contenham os headers <i>Accept: application/json</i> e <i>Content-type: application/json</i>.

## :pushpin: Referências
- https://laravel.com/docs/8.x
- https://github.com/laravel/laravel
- https://github.com/DarkaOnLine/L5-Swagger/wiki
- https://swagger.io/docs/
