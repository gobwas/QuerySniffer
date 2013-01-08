<?php
namespace Application\Formatter;
use Application\Model\QueriesBag;
use Application\Model\Query;


class QueryDumpFormatter implements IFormatter
{
	public function format(QueriesBag $queries)
	{
		$sheet = '';

		foreach ($queries->asArray() as $query) {
			assert($query instanceof Query);
			$sheet.= sprintf("Dump of Query object: \n\t%s\n", self::dump($query));
		}

		return $sheet;
	}

	/**
	 * @param $dumpMe
	 * @return string
	 */
	public static function dump($dumpMe)
	{
		ob_flush();
		ob_start();
		var_dump($dumpMe);
		$dump = ob_get_contents();
		ob_clean();

		return $dump;
	}

	public function __invoke(QueriesBag $queries)
	{
		return $this->format($queries);
	}
}
