<?php

require '../vendor/autoload.php';

/**
 * For debugging
 * @param type ...$vars 
 * @return Array
 */
function dd(...$vars)
{
	foreach ($vars as $var)
	{
		echo '<pre>';
		print_r($var);
		echo '</pre>';
	}
}

/**
 * Connection to database
 * @return PDO
 */
function getPDO() : PDO
{
	return new PDO('mysql:host=localhost;dbname=calendar', 'root', 'root',[
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		]);
}

/**
 * clean the variable of input
 * @param string $val 
 * @return string
 */
function clean(?string $val) : string
{
	if($val === null)
	{
		return '';	
	}

	return htmlentities($val);
}

function render(string $view, array $parameters = []) : void
{
	extract($parameters);
	include "../views/{$view}.php";
}

?>