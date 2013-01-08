<?php
namespace Application\Daemon;

abstract class AbstractDaemon implements IDaemon
{
	/**
	 * @var bool|null
	 */
	protected $running = null;

	/**
	 * @var \Application\Patcher\IPatcher|null
	 */
	protected $patcher = null;
}
