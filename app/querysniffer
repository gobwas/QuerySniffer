#!/usr/bin/php

<?php
require_once dirname(__DIR__)."/vendor/autoload.php";
error_reporting(E_ERROR);

final class Starter
{
	const SHELL_TAB = "\t\t";
	const USAGE = "Usage %s {%s}\n\n";

	const PATH_TO_LOCK = "/var/lock/subsys";
	const PATH_TO_PID = "/var/run";
	const APPLICATION = "application.php";

	protected $application = null;
	protected static $functions = array('start', 'stop', 'restart');

	protected $bad = null;
	protected $good = null;
	protected $fatal = null;

	protected $lockFile = null;
	protected $pidFile = null;

	public function __construct(array $argv, $argc)
	{
		$this->argv = $argv;
		$this->argc = $argc;

		$this->application = realpath(__DIR__.'/'.self::APPLICATION);

		$this->command  = strtolower(basename(__FILE__));
		$this->lockFile = self::PATH_TO_LOCK.'/'.$this->command;
		$this->pidFile  = self::PATH_TO_PID.'/'.$this->command.'.pid';

		$this->bad   = new ShellStyle(array(ShellStyle::FOREGROUND_RED, ShellStyle::STYLE_BOLD));
		$this->good  = new ShellStyle(array(ShellStyle::FOREGROUND_GREEN));
		$this->fatal = new ShellStyle(array(ShellStyle::FOREGROUND_WHITE, ShellStyle::BACKGROUND_RED));
	}

	public function init()
	{
		if ($this->argc <= 1 or !in_array($this->argv[1], self::$functions)) {
			exit(sprintf(self::USAGE, $this->command, implode('|', self::$functions)));
		}

		$call = $this->argv[1];
		$this->$call();
	}

	protected function start()
	{
		echo "Starting {$this->command}: ";

		try {
			if (!is_file($this->application)) {
				throw new Exception("Path to application.php not correct: ".$this->application);
			}

			if (!is_file($this->lockFile)) {
				if (!touch($this->lockFile)) {
					throw new Exception("Could not create file {$this->lockFile}");
				}

				$pid = exec(sprintf('php %1$s "%2$s"', $this->application, $this->pidFile));

				if (!is_numeric(trim($pid))) {
					throw new Exception("Application has returned invalid processId");
				}

				if ($pidHandle = @fopen($this->pidFile, 'w')) {
					fwrite($pidHandle, trim($pid)."\n");
					fclose($pidHandle);
				} else {
					$this->kill($pid);
					throw new Exception("Could not write in file {$this->pidFile}");
				}

				$status = true;
				$tip = null;

			} else {
				$status = false;
				$tip = "Application already running";
			}
		} catch (Exception $e) {
			$status = false;
			$tip = $e;
		}

		$this->handleResult($status, $tip);
	}

	protected function kill($pid)
	{
		exec(sprintf("kill %d", $pid));
	}

	protected function stop()
	{
		echo "Stopping {$this->command}: ";

		try {
			if (is_file($this->lockFile)) {
				if (!unlink($this->lockFile)) {
					throw new Exception("Could not unlink file {$this->lockFile}");
				}

				if ($pidHandle = @fopen($this->pidFile, 'r')) {
					$pidList = fread($pidHandle, filesize($this->pidFile));
					fclose($pidHandle);

					foreach (explode("\n", $pidList) as $pid) {
						if (is_numeric($pid)) {
							$this->kill($pid);
						}
					};

					if (!unlink($this->pidFile)) {
						throw new Exception("Could not unlink file {$this->pidFile}");
					}

					$status = true;
					$tip = null;

				} else {
					throw new Exception("Could not open file {$this->pidFile}");
				}
			} else {
				$status = false;
				$tip = "Nothing to stop";
			}
		} catch (Exception $e) {
			$status = false;
			$tip = $e;
		}

		$this->handleResult($status, $tip);
	}

	protected function restart()
	{
		$this->stop();
		$this->start();
	}

	public function handleResult($status, $tip = null)
	{
		if (!is_null($tip)) if ($tip instanceof Exception) {
			echo $this->fatal->parse($tip->getMessage())."\n";
		} else {
			echo $tip."\n";
		}

		if ($status == true) {
			echo self::SHELL_TAB.'[   '.$this->good->parse('OK')."   ]\n";
		} else {
			echo self::SHELL_TAB.'[   '.$this->bad->parse('FAILED')."   ]\n";
		}
	}

}

$starter = new Starter($argv, $argc);
$starter->init();

?>