<?php
namespace QuerySniffer\Model;

final class CommandEnumMySQL extends Enum
{
	const SQL_INIT_DB = 'Init DB';
	const SQL_CONNECT = 'Connect';
	const SQL_QUERY   = 'Query';
	const SQL_PREPARE = 'Prepare';
	const SQL_EXECUTE = 'Execute';
	const SQL_QUIT    = 'Quit';

	/**
	 * Возвращает типизируемые команды
	 * @return array
	 */
	public static function getTypeable()
	{
		return array(self::SQL_QUERY, self::SQL_PREPARE, self::SQL_EXECUTE);
	}
}
