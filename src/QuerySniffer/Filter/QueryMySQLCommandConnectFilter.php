<?php
namespace QuerySniffer\Filter;
use QuerySniffer\Model\QueryMySQL;
use QuerySniffer\Model\QuerySQLTypeEnum;
use QuerySniffer\Model\CommandEnumMySQL;

class QueryMySQLCommandConnectFilter extends AbstractFilter
{
	public function filter($value)
	{
		if ($value instanceof QueryMySQL) {
			/* @var $value QueryMySQL */
			if ($value->command->getValue() == CommandEnumMySQL::SQL_CONNECT) {
				$value->type     = QuerySQLTypeEnum::SQL_USE();
				$value->command  = CommandEnumMySQL::SQL_QUERY();
				$value->argument = sprintf("%s %s", QuerySQLTypeEnum::SQL_USE, preg_replace("/.*\son\s(\S+)/", "$1", $value->argument));
			}
		}

		return $value;
	}
}
