<?php
namespace Application\Filter;


class FilterChain extends AbstractFilter implements IFilterChain
{
	/**
	 * @var array
	 */
	protected $filters = array();

	/**
	 * @param $filter
	 * @return FilterChain|IFilterChain
	 */
	public function append($filter)
	{
		assert(is_callable($filter));

		array_push($this->filters, $filter);

		return $this;
	}

	/**
	 * @param $filter
	 * @return FilterChain|IFilterChain
	 */
	public function prepend($filter)
	{
		assert(is_callable($filter));

		array_unshift($this->filters, $filter);

		return $this;
	}

	/**
	 * @param mixed $value
	 * @return mixed
	 */
	public function filter($value) {
		$filtered = $value;
		foreach ($this->filters as $filter) {
			$filtered = call_user_func($filter, $filtered);
		}

		return $filtered;
	}
}
