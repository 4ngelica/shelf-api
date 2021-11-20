<h3 align="center">Shelf API</h3>

<p align="center">
   API baseada na construção de uma prateleira de produtos tendo a API de busca da VTEX como base de dados.
</p>

## :pushpin: Sobre

O objetivo da Shelf API é responder a uma requisição do tipo GET com uma lista de 12 perfumes de forma ordenada pelos produtos mais vendidos, permitindo que seja possível criar uma prateleira de eccommerce no front-end.

Ao receber a requisição, a API dispara uma requisição também do tipo GET para a API de busca da VTEX, trata os dados e devolve uma resposta com a lista de produtos no formato json.

## :pushpin: Tecnologias
- PHP 7.4
- Laravel 8

## :pushpin: Documentação
Acesse a documentação <b>aqui</b>.

## :pushpin: Execução
### Consumo da API da VTEX

A ordenação foi realizada diretamente na requisição da API de busca. Foi utilizado o parâmetro O=OrderByPriceDESC, enviado como filtro na URL da requisição:

http://epocacosmeticos.vtexcommercestable.com.br/api/catalog_system/pub/products/search/?O=OrderByTopSaleDESC

Além disso, o parâmetro de busca foi omitido na URL, para não limitar a query da busca. A alternativa utilizada foi enviar no body da requisição o parâmetro 'fq', que indica a categoria dos produtos buscados. Portanto, a busca foi realizada dentre os produtos classificados na categoria Perfumes (1000001).
Para limitar a busca em 12 resultados, foram utilizados os parâmetros _from e _to.

### Tratamento dos dados
Para otimizar o tratamento de dados e não comprometer a velocidade da resposta, foi definida uma lista de parâmetros essenciais para cada produto durante a geração da prateleira. A escolha desses parâmetros foi baseada na interface de prateleira da Época Cosméticos:

- productName
- productId
- brand
- Price
- ListPrice
- imageUrl

Visto que muitas informações foram omitidas nesse processo, foi implementado um segundo endpoint, que trás uma resposta mais detalhada para cada produto. O parâmetro item foi utilizado para realizar essa requisição e indica também a classificação do produto dentro da lista.

## :pushpin: Instalação

## :pushpin: Escolha da stack

## :pushpin: Próximos passos
