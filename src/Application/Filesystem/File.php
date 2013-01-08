<?php
namespace Application\Filesystem;
use ReflectionObject;

/**
 * Created by JetBrains PhpStorm.
 * User: gobwas
 * Date: 01.01.13
 * Time: 19:27
 * To change this template use Filesystem | Settings | Filesystem Templates.
 */
class File
{
	const WRITE = 'ab';
	const READ      = 'rb';

	/**
	 * @var null|string
	 */
	protected $file = null;

	/**
	 * @param $file
	 * @throws FilesystemException
	 */
	public function __construct($file)
	{
		assert(is_string($file) and !empty($file));

		if (!is_file($file)) if (!touch($file)) {
			throw new FilesystemException("Cant create file $file");
		}

		$this->file = $file;
	}

	/**
	 * @return null|string
	 */
	public function getFile()
	{
		return $this->file;
	}

	/**
	 * @param string $flag
	 * @return resource
	 */
	public function open($flag)
	{
		$reflection = new ReflectionObject($this);
		assert(in_array($flag, $reflection->getConstants()));

		return fopen($this->file, $flag);
	}

	/**
	 *
	 */
	public function close($handle)
	{
		assert(is_resource($handle));

		fclose($handle);
	}

	/**
	 * @return null|string
	 */
	public function __toString()
	{
		return is_null($this->file) ? '' : $this->file;
	}
}
