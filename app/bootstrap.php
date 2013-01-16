<?php
use Symfony\Component\ClassLoader\UniversalClassLoader;
use QuerySniffer\Exception\AssertionException;

// Timezone
date_default_timezone_set('Europe/Moscow');

/*
 * Логирование ошибок
 * TODO Конфигурируемый путь к файлам логов
 * TODO абсолютные пути ко всем файлам
 * TODO Сейчас работает только если запускать команду из QuerySniffer/
 */
fclose(STDIN);
fclose(STDOUT);
fclose(STDERR);
$STDIN = fopen('/dev/null', 'r');
$STDOUT = fopen('log/application.log', 'a');
$STDERR = fopen('log/error.log', 'a');

error_reporting(E_ERROR | E_PARSE | E_COMPILE_ERROR | E_RECOVERABLE_ERROR);

ini_set('log_errors', 1);
ini_set('error_log', 'log/error.log');
ini_set('display_errors', 1);

// Реакция на assert
assert_options(ASSERT_CALLBACK, function($script, $line, $message) {
	throw new AssertionException("Assert failed in $script:$line. $message");
});

require_once dirname(__DIR__)."/vendor/autoload.php";

// Автозагрузка классов приложения
$classLoader = new UniversalClassLoader();
$classLoader->registerNamespace('QuerySniffer', dirname(__DIR__).'/src');
$classLoader->register();