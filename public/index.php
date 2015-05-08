<?php

require_once __DIR__ . '/../bootstrap.php';

use Code\Sistema\Service\ProdutoService;
use Code\Sistema\Mapper\ProdutoMapper;
use Code\Sistema\Connection\SQLite3Connection;
use Code\Sistema\Entity\Produto;
use Symfony\Component\HttpFoundation\Request;

$app['produtoService'] = function () {
    return $produtoService = new ProdutoService(new ProdutoMapper(new SQLite3Connection(new SQLite3(__DIR__ . "/../database/sistema.db"))), new Produto());
};

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.twig', []);
})->bind('inicio');

$app->get('/produtos', function () use ($app) {
    $result = $app['produtoService']->findAll();
    return $app['twig']->render('produto/produtos.twig', ['produtos' => $result]);
})->bind('produtos_listar');

$app->get('/produtos/novo', function () use ($app) {
    return $app['twig']->render('produto/produto_novo.twig', []);
})->bind('produto_novo');

$app->post('/produtos/novo', function (Request $request) use ($app) {
    $app['produtoService']->insert($request->request->all());
    return $app['twig']->render('produto/produto_novo.twig', []);
})->bind('produto_novo_post');

$app->get('/produtos/edit/{id}', function ($id) use ($app) {
    $result = $app['produtoService']->find($id);
    return $app['twig']->render('produto/produto_edit.twig', ["produto" => $result]);
})->bind('produto_edit');

$app->post('/produtos/edit', function (Request $request) use ($app) {
    $app['produtoService']->update($request->request->all());
    return $app->redirect("/produtos");
})->bind('produto_edit_post');

$app->get('/produtos/delete/{id}', function ($id) use ($app) {
    $app['produtoService']->delete($id);
    return $app->redirect("/produtos");
})->bind('produtos_delete');

//APIS RESET

$app->get('/api/produtos', function () use ($app) {
    $result = $app['produtoService']->findAll();
    return $app->json($result);
});

$app->get('/api/produtos/{id}', function ($id) use ($app) {
    $result = $app['produtoService']->find($id);
    return $app->json($result);
});

$app->post('/api/produtos', function (Request $request) use ($app) {
    $serviceManager = $app['produtoService'];
    $result = $serviceManager->insert($request->request->all());
    if (!$result) {
        return $app->json($serviceManager->getMessage());
    }
    return $app->json($result);
});

$app->put('/api/produtos', function (Request $request) use ($app) {
    $serviceManager = $app['produtoService'];
    $result = $serviceManager->update($request->request->all());
    if (!$result) {
        return $app->json($serviceManager->getMessage());
    }
    return $app->json($result);
});

$app->delete('/api/produtos/{id}', function ($id) use ($app) {
    $serviceManager = $app['produtoService'];
    $result = $serviceManager->delete($id);
    if (!$result) {
        return $app->json($serviceManager->getMessage());
    }
    return $app->json($result);
});

$app->run();


