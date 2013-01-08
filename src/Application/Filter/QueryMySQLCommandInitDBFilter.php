<?php
namespace Application\Filter;
use Application\Model\QueryMySQL;
use Application\Model\QuerySQLTypeEnum;
use Application\Model\CommandEnumMySQL;

class QueryMySQLCommandInitDBFilter extends AbstractFilter
{
	public function filter($value)
	{
		if ($value instanceof QueryMySQL) {
			/* @var $value QueryMySQL */
			if ($value->command->getValue() == CommandEnumMySQL::SQL_INIT_DB) {
				$value->type     = QuerySQLTypeEnum::SQL_USE();
				$value->command  = CommandEnumMySQL::SQL_QUERY();
				$value->argument = sprintf("%s %s", QuerySQLTypeEnum::SQL_USE, $value->argument);
			}
		}

		return $value;
	}
}
