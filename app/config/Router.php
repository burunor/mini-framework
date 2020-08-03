<?php

$this->get('/', function(){
    echo 'Estou na HOME!!!';
});

$this->get('/about', function(){
    echo 'Estou na ABOUT!!!';
});
