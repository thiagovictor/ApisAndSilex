<?php

require_once __DIR__ . '/../bootstrap.php';

use Code\Sistema\Service\ProdutoService;
use Code\Sistema\Mapper\ProdutoMapper;
use Code\Sistema\Connection\SQLite3Connection;
use Code\Sistema\Entity\Produto;

$app['produtoService'] = function () {
    return $produtoService = new ProdutoService(new ProdutoMapper(new SQLite3Connection(new SQLite3(__DIR__ . "/../database/sistema.db"))), new Produto());
};

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.twig', []);
})->bind('inicio');

$app->get('/produtos', function () use ($app) {
    $result = $app['produtoService']->findAll();
    return $app['twig']->render('produtos.twig', ['produtos' => $result]);
})->bind('produtos_listar');

$app->get('/produtos/novo', function () use ($app) {
    return $app['twig']->render('produto_novo.twig', []);
})->bind('produto_novo');

$app->get('/produtos/delete/{id}', function ($id) use ($app) {
    $app['produtoService']->delete($id);
    return $app->redirect("/produtos");
})->bind('produtos_delete');

$app->run();


