<?php
namespace QuerySniffer\Reader;
use QuerySniffer\Filesystem\File;

/**
 * Created by JetBrains PhpStorm.
 * User: gobwas
 * Date: 01.01.13
 * Time: 19:11
 * To change this template use Filesystem | Settings | Filesystem Templates.
 */
class ReaderFile implements IReader
{
	/**
	 * @var int
	 */
	protected $buffer = 400096;

	/**
	 * @var resource[]
	 */
	protected $handles = array();

	/**
	 * @var null
	 */
	public $seek = null;

	/**
	 * @param $source
	 * @return string
	 */
	public function read($source)
	{
		assert($source instanceof File);

		/* @var $source File */
		if (!array_key_exists((string) $source, $this->handles)) {
			// открываем файл
			$this->handles[(string) $source] = $source->open(File::READ);
			// перемещаем указатель на конец
			if ($this->seek === true) {
				fseek($this->handles[(string) $source], 0, SEEK_END);
			}
		}

		return fread($this->handles[(string) $source], $this->buffer);
	}

	/**
	 * @param int $buffer
	 */
	public function setBuffer($buffer)
	{
		$this->buffer = $buffer;
	}
}
