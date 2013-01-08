<?php
namespace Application\Formatter;
use Application\Model\QueriesBag;


interface IFormatter
{
	/**
	 * @param QueriesBag $queries
	 * @return mixed
	 */
	public function format(QueriesBag $queries);

	/**
	 * Link to format() method
	 * @see IFormatter::format;
	 */
	public function __invoke(QueriesBag $queries);
}
