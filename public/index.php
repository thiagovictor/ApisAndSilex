<?php

require_once __DIR__.'/../bootstrap.php';
 
$app->get('/clientes', function () use ($app){
    $clientes = [
        [nome=>"TSA Tecnologia",email=>"informatica@tsasistemas.com.br",doc=>"41.857.754/0001-68"],
        [nome=>"Anvisa Sistemas",email=>"informatica@anvisasistemas.com",doc=>"41.358.754/0001-00"],
        [nome=>"EPC Vistoria",email=>"contato@epcvistorias.com.br",doc=>"31.892.854/0001-18"],
        [nome=>"Marista Tecnologia",email=>"vendas@mtecnologia.com.br",doc=>"41.998.555/0001-10"]
    ];
    return $app->json($clientes);    
});
$app->run();


