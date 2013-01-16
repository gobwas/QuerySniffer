<?php
// Создаем дочерний процесс
$pid = pcntl_fork();
if ($pid) {
	echo "$pid";
	exit();
}

// Делаем основным процессом дочерний.
posix_setsid();

require "bootstrap.php";

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

$container = new ContainerBuilder();
$loader = new YamlFileLoader($container, new FileLocator(__DIR__));
$loader->load('services.yml');

echo sprintf("[%s]\tReady to start application.\n", date('Y-m-d H:i:s'));

/* @var $daemon \QuerySniffer\Daemon\IDaemon */
$daemon = $container->get('daemon');
$daemon->run();