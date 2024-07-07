# Gestão de compra de ativos financeiros
## Descrição do projeto

API em PHP usando o framework Laravel para um MVP do curso de pós-graduação.

Contém funcionalidades para a gestão de operações de ativos do mercado financeiro.
É possível toda uma gestão das operações, bem como a consolidação e apuração da posição total, 
mostrando por ativo se está tendo lucro ou prejuízo.
Mas inicialmente possui suporte somente a gestão de compra e venda de ações e fundos imobiliários.

O projeto é uma evolução deste outro [repositório](https://github.com/jeangomes/eng-soft-mvp1-api). 

É consultado uma [api](https://brapi.dev/)
para obter a cotação atual das ações e fundos imobiliários.
Para o próposito inicial a quantidade de requisições do plano gratuito atende, mas é necessário um token, que deve ser 
adicionado das variáveis de ambiente.
**BRAPI_API_TOKEN=VALOR_DO_TOKEN**

### Sobre as rotas, os endpoints da api:

#### Rotas de Ativos Financeiros
- **Listar Ativos Financeiros**: `GET /api/financial-assets` (`FinancialAssetController@index`)
- **Criar Ativo Financeiro**: `POST /api/financial-assets` (`FinancialAssetController@store`)
- **Mostrar Ativo Financeiro**: `GET /api/financial-assets/{financial_asset}` (`FinancialAssetController@show`)
- **Atualizar Ativo Financeiro**: `PUT|PATCH /api/financial-assets/{financial_asset}` (`FinancialAssetController@update`)
- **Deletar Ativo Financeiro**: `DELETE /api/financial-assets/{financial_asset}` (`FinancialAssetController@destroy`)
#### Rotas de Notas de Negociação
- **Listar Notas de Negociação**: `GET /api/negotiation-notes` (`NegotiationNoteController@index`)
- **Criar Nota de Negociação**: `POST /api/negotiation-notes` (`NegotiationNoteController@store`)
- **Mostrar Nota de Negociação**: `GET /api/negotiation-notes/{negotiation_note}` (`NegotiationNoteController@show`)
- **Atualizar Nota de Negociação**: `PUT|PATCH /api/negotiation-notes/{negotiation_note}` (`NegotiationNoteController@update`)
- **Deletar Nota de Negociação**: `DELETE /api/negotiation-notes/{negotiation_note}` (`NegotiationNoteController@destroy`)
#### Outras Rotas
- **Listar Todos os Ativos**: `GET /api/assets-list` (`AssetsListForComboController`)
- **Posição Atual**: `GET /api/current-position` (`CurrentPositionController`)
- **Listar Operações**: `GET /api/operations` (`OperationListController`)

## Instruções de Instalação

1. Rode o comando **docker-compose up -d** para criar a imagem e levantar os containers necessários.
2. Rode o composer install
3. Verifique se o BD foi criado e execute as migrations para criar as tabelas necessárias.


