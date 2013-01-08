<?php
namespace QuerySniffer\Formatter;
use QuerySniffer\Model\QueryMySQL;
use QuerySniffer\Model\QueriesBag;


class QueryMySQLFormatter implements IFormatter
{
	public function format(QueriesBag $queries)
	{
		$sheet = '';


		foreach ($queries->asArray() as $query) {
			assert($query instanceof QueryMySQL);

			/* @var $query QueryMySQL */
			$sheet.= sprintf("%s\n\n\n", $query->argument);
		}

		return $sheet;
	}

	public function __invoke(QueriesBag $queries)
	{
		return $this->format($queries);
	}
}
