<?php
namespace Application\Writer;
use Application\Filesystem\File;

/**
 * Created by JetBrains PhpStorm.
 * User: gobwas
 * Date: 01.01.13
 * Time: 19:22
 * To change this template use Filesystem | Settings | Filesystem Templates.
 */
class WriterFile implements IWriter
{
	/**
	 * @var resource[]
	 */
	protected $handles = array();

	/**
	 * @param $target
	 * @param $message
	 */
	public function write($target, $message)
	{
		assert($target instanceof File);

		/* @var $target File */
		if (!array_key_exists((string) $target, $this->handles)) {
			$this->handles[(string) $target] = $target->open(File::WRITE);
		}

		fwrite($this->handles[(string) $target], $message);

		// TODO Сделать закрытие файла функцией без аргумента, а сами ссылки на ресурсы хранить в файле
		//$target->close($this->handles[(string) $target]);
	}
}
