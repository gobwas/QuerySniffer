<?php
use Symfony\Component\ClassLoader\UniversalClassLoader;
use Application\Exception\AssertionException;

// Timezone
date_default_timezone_set('Europe/Moscow');

/*
 * Логирование ошибок
 * TODO Конфигурируемый путь к файлам логов
 */
error_reporting(E_ERROR | E_PARSE | E_COMPILE_ERROR | E_RECOVERABLE_ERROR);
ini_set('log_errors', 1);
ini_set('error_log', 'log/error.log');
ini_set('display_errors', 1);

fclose(STDIN);
fclose(STDOUT);
fclose(STDERR);
$STDIN = fopen('/dev/null', 'r');
$STDOUT = fopen('log/application.log', 'wb');
$STDERR = fopen('log/error.log', 'wb');

// Реакция на assert
assert_options(ASSERT_CALLBACK, function($script, $line, $message) {
	throw new AssertionException("Assert failed in $script:$line. $message");
});

require_once dirname(__DIR__)."/vendor/autoload.php";

// Автозагрузка классов приложения
$classLoader = new UniversalClassLoader();
$classLoader->registerNamespace('Application', dirname(__DIR__).'/src/');
$classLoader->register();
