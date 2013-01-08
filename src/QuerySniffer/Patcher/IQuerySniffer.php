<?php
namespace QuerySniffer\Patcher;

interface IQuerySniffer
{
	public function __construct(array $sources);
	public function run();
}
