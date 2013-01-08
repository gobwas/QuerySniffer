<?php
namespace QuerySniffer\Model;
use QuerySniffer\Model\QuerySQLTypeEnum;
use \DateTime;

class QueryBuilderMySQL
{
	/**
	 * @param array $action
	 * @return QueryMySQL
	 */
	public function build(array $action)
	{
		$query = new QueryMySQL();


		$query->command  = new CommandEnumMySQL($action['command']);
		$query->argument = (string) $action['argument'];
		$query->id       = (integer) $action['id'];
		$query->date     = DateTime::createFromFormat('ymd H:i:s', $action['date']);

		$query->type = in_array($query->command->getValue(), CommandEnumMySQL::getTypeable())
			? new QuerySQLTypeEnum(strtoupper(preg_filter("/^[^a-zA-Z]*([a-zA-Z]+).*/is", "$1", $query->argument)))
			: null;

		return $query;
	}

}
