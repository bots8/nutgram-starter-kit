<?php

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use App\QueryBuilder;

$qb = new QueryBuilder();

$id = $qb->table('users')
	->select('id', 'name')
	->where('username', '=', 'f')
	->first();

var_dump($id);