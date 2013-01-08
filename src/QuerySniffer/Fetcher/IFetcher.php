<?php
namespace QuerySniffer\Fetcher;

interface IFetcher
{
	/**
	 * @param $value
	 * @return \QuerySniffer\Model\QueriesBag
	 */
	public function fetch($value);
}
