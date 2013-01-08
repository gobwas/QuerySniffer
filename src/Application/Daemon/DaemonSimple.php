<?php
namespace Application\Daemon;
use Application\Patcher\IPatcher;

/**
 * Created by JetBrains PhpStorm
 */
class DaemonSimple extends AbstractDaemon
{
	public function run()
	{
		while(true) {
			$this->patcher->run();
		}
	}

	public function setPatcher(IPatcher $patcher)
	{
		$this->patcher = $patcher;
	}
}