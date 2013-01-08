<?php
namespace QuerySniffer\Filter;


interface IFilter
{
	/**
	 * Link to filter() method
	 * @see IFilter::filter()
	 */
	public function __invoke($value);

	/**
	 * @param mixed $value
	 * @return mixed
	 */
	public function filter($value);
}
