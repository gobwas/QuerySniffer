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

/* @var $daemon \Application\Daemon\IDaemon */
$daemon = $container->get('daemon');
$daemon->run();