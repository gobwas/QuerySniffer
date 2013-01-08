<?php
namespace Application\Fetcher;
use Application\Model\QueryBuilderMySQL;
use Application\Model\QueriesBag;

class QueryMySQLFetcher implements IFetcher
{
	/**
	 * @param string $value
	 * @return QueriesBag
	 */
	public function fetch($value)
	{
		assert(is_string($value));

		$matches = array();
		preg_match_all("/^([0-9]{6}\s[0-9\:]{8}\t+\s+|\t{2}\s+)([0-9]+)\s([\S ]+)\t([\S \r\n]+)$/m", $value, $matches, PREG_SET_ORDER);

		return new QueriesBag(array_map($this->getMapper(), $matches));
	}

	/**
	 * @return callable
	 */
	public function getMapper()
	{
		$lastDate = null;
		$builder = new QueryBuilderMySQL();

		return function($match) use (&$lastDate, $builder) {
			$lastDate = preg_match('/[0-9]{6}\s[0-9\:]{8}/', $match[1]) ? trim($match[1]) : $lastDate;
			return $builder->build(
				array(
					'command'  => trim($match[3]),
					'argument' => trim($match[4]),
					'id'       => trim($match[2]),
					'date'     => $lastDate,
				)
			);
		};
	}
}
