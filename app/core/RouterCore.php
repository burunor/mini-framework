<?php

namespace app\core;


class RouterCore
{
    private $uri;
    private $method;

    private $getArr = [];

    public function __construct()
    {
        $this->initialize();
        require_once('../app/config/Router.php');
        $this->execute();
    }

    private function initialize()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];

        $uri = $this->normalizeURI( explode('/', ($_SERVER['REQUEST_URI']) ) );

        for ($i = 0; $i < UNSET_URI_COUNT; $i++ )
        {
            unset($uri[$i]);
        }

        $this->uri = implode('/', $uri);

        if (DEBUG_URI)
            dd($this->uri);
    }

    private function get($router, $call)
    {
        $this->getArr[] = [
            'router'    => $router,
            'call'      => $call
        ];
    }

    private function execute()
    {
        switch ($this->method){
            case 'GET':
                $this->executeGet(); break;
            case 'POST':
                $this->executePost(); break;
        }
    }

    private function executeGet()
    {
        foreach($this->getArr as $get)
        {
            $get['router'] = substr($get['router'], 1);

            if ( substr($get['router'], 0, -1) == '/')
                substr($get['router'], 0, -1);

            if($get['router'] == $this->uri)
            {
                if ( is_callable($get['call']))
                {
                    $get['call']();
                    break;
                }
                echo 'achamos';
            }

        }
    }

    private function executePost()
    {

    }

    private function normalizeURI($arr)
    {
        return array_values( array_filter( $arr ) );
    }
}