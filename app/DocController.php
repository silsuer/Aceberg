<?php
/**
 * Created by PhpStorm.
 * User: silsuer
 * Date: 2018/4/28
 * Time: 18:07
 */

namespace App;


use S\Template;

class DocController
{
    public function showDoc($request,$response){

        $config = [
            'debug' => C('TWIG_DEBUG'),
            'charset' => C('TWIG_CHARSET'),
//            'cache' => root_path() . C('TWIG_CACHE'),  不加缓存
            'auto_reload' => C('TWIG_AUTO_RELOAD'),
            'strict_variables' => C('TWIG_STRICT_VARIABLES'),
            'autoescape' => C('TWIG_AUTOESCAPE'),
            'optimizations' => C('TWIG_OPTIMIZATIONS')
        ];

        $docLoader = new \Twig_Loader_Filesystem(root_path());
        $docEnv = new \Twig_Environment($docLoader, $config);
        $docEnv->addGlobal('ace', new GlobalObj());

        $data = [
            'go' => 'world',
            'request' => $request,
            'response' => $response,
            'data_path' => '/data',
        ];

        $response->end($docEnv->loadTemplate('/data/page/doc.html')->render($data));
    }

}