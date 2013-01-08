<?php
namespace Application\Fetcher;

interface IFetcher
{
	/**
	 * @param $value
	 * @return \Application\Model\QueriesBag
	 */
	public function fetch($value);
}
