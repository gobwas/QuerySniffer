<?php
namespace QuerySniffer\Model;


class QueryMySQL extends QuerySQL
{
	/**
	 * @var integer|null
	 */
	public $id = null;

	/**
	 * @var CommandEnumMySQL|null;
	 */
	public $command = null;
}
