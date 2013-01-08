<?php
namespace Application\Filter;


interface IFilterChain
{
	/**
	 * @param $filter
	 * @return IFilterChain
	 */
	public function append($filter);

	/**
	 * @param $filter
	 * @return IFilterChain
	 */
	public function prepend($filter);
}
