<?php
namespace Application\Patcher;

interface IPatcher
{
	public function __construct(array $sources);
	public function run();
}
