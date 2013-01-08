<?php
namespace QuerySniffer\Daemon;

abstract class AbstractDaemon implements IDaemon
{
	/**
	 * @var bool|null
	 */
	protected $running = null;

	/**
	 * @var \QuerySniffer\Patcher\IQuerySniffer|null
	 */
	protected $patcher = null;
}
