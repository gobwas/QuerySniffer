<?php
namespace Application\Filter;
use Application\Model\QuerySQL;
use Application\Filter\Exception\FilterException;
use Application\Exception\AssertionException;
use Application\Model\QuerySQLTypeEnum;


class QuerySQLTypeFilter extends AbstractFilter
{
	/**
	 * @param array $options
	 * @throws FilterException
	 */
	public function __construct(array $options = array())
	{
		parent::__construct($options);

		try {
			$this->options = array_map(
				function($option) {
					assert($option instanceof QuerySQLTypeEnum);
					/* @var $option QuerySQLTypeEnum */
					return $option->getValue();
				},
				$this->options
			);
		} catch (AssertionException $e) {
			throw new FilterException(sprintf("Filter not configured properly. %s allows just instances of %s in options list.", __CLASS__, "QuerySQLTypeEnum"));
		}
	}

	/**
	 * @param mixed $value
	 * @return QuerySQL|mixed
	 * @todo Решить, что делать, когда type = null
	 */
	public function filter($value)
	{
		if ($value instanceof QuerySQL) if (!is_null($value->type)) {
			return in_array($value->type->getValue(), $this->options, true) ? $value : null;
		}

		return null;
	}
}
