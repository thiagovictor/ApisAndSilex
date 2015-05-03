<?php

require_once __DIR__ . '/../bootstrap.php';

use Code\Sistema\Service\ProdutoService;
use Code\Sistema\Mapper\ProdutoMapper;
use Code\Sistema\Connection\SQLite3Connection;
use Code\Sistema\Entity\Produto;

$app['produtoService'] = function () {
    return $produtoService = new ProdutoService(new ProdutoMapper(new SQLite3Connection(new SQLite3(__DIR__ . "/../database/sistema.db"))), new Produto());
};
//So para não retornar erro quando iniciar -> para teste
$app->get('/', function (){
  return "Rodando em /produtos";  
});
$app->get('/produtos', function () use ($app) {
//    $inserir = [
//        "nome" => "Monitor",
//        "descricao" => "AOC LED 22 Pol.",
//        "valor" => 579.50
//    ];
//    $app['produtoService']->insert($inserir);
//    $app['produtoService']->update($atualizar);
//    $app['produtoService']->delete(27);
      $result = $app['produtoService']->findAll();
    return $app->json($result);
});
$app->run();


