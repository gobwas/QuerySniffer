<?php
namespace Application\Writer;

/**
 * Created by JetBrains PhpStorm.
 * User: gobwas
 * Date: 01.01.13
 * Time: 19:10
 * To change this template use Filesystem | Settings | Filesystem Templates.
 */
interface IWriter
{
	public function write($target, $message);
}
