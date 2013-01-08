<?php
namespace QuerySniffer\Model;
use DateTime;


class QuerySQL extends Query
{
	/**
	 * @var DateTime|null
	 */
	public $date = null;

	/**
	 * @var QuerySQLTypeEnum|null;
	 */
	public $type = null;

	/**
	 * @var string|null;
	 * @todo Сделать данное поле классом QuerySQLArgument где будет метод normalize
	 */
	public $argument = null;
}
