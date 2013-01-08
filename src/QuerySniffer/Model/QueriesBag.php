<?php
namespace QuerySniffer\Model;
use QuerySniffer\Filter\IFilter;


class QueriesBag
{
	/**
	 * @var Query[]
	 */
	protected $queries = array();

	/**
	 * @param array $queries
	 */
	public function __construct(array $queries = array())
	{
		$bag = $this;

		array_walk($queries, function(Query $query) use ($bag) {
			$bag->add($query);
		});
	}

	/**
	 * @param Query $query
	 */
	public function add(Query $query)
	{
		$this->queries[] = $query;
	}

	/**
	 * @param IFilter $filter
	 * @return QueriesBag
	 */
	public function filter(IFilter $filter)
	{
		return new QueriesBag(array_filter(
			array_map(
				function($query) use($filter) {
					return $filter->filter($query);
				},
				$this->asArray()
			),
			function($query) {
				return !is_null($query);
			}
		));
	}

	/**
	 * Возвращает список склонированных запросов
	 * @return Query[]
	 */
	public function asArray()
	{
		$array = array();
		foreach ($this->queries as $query) {
			$array[] = clone $query;
		}

		return $array;
	}


	public static function merge(QueriesBag $bagOne, QueriesBag $bagTwo)
	{
		return new QueriesBag(array_merge($bagOne->asArray(), $bagTwo->asArray()));
	}

	/**
	 * @return array
	 */
	public function getUnique() {
		$unique = array();
		foreach ($this->queries as $query) {
			$unique[$this->getKey($query)] = clone $query;
		}

		return $unique;
	}

	/**
	 * @param $query
	 * @return string
	 */
	public function getKey($query)
	{
		return md5(print_r($query, true));
	}
}
