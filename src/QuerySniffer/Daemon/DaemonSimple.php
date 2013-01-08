<?php
namespace QuerySniffer\Daemon;
use QuerySniffer\Patcher\IQuerySniffer;

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

	public function setPatcher(IQuerySniffer $patcher)
	{
		$this->patcher = $patcher;
	}
}