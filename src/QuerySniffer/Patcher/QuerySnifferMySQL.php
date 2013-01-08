<?php
namespace QuerySniffer\Patcher;
use QuerySniffer\Patcher\IQuerySniffer;
use QuerySniffer\Formatter\QueryDumpFormatter;
use QuerySniffer\Model\QueriesBag;
use stdClass;
use QuerySniffer\Model\QuerySQLTypeEnum;

use QuerySniffer\Formatter\QueryMySQLFormatter;
use QuerySniffer\Formatter\IFormatter;

use QuerySniffer\Filter\QueryMySQLCommandConnectFilter;
use QuerySniffer\Filter\QueryMySQLCommandInitDBFilter;
use QuerySniffer\Filter\QuerySQLTypeFilter;
use QuerySniffer\Filter\FilterChain;

use QuerySniffer\Fetcher\IFetcher;

use QuerySniffer\Filesystem\File;

use QuerySniffer\Writer\IWriter;
use QuerySniffer\Reader\IReader;

/**
 * Класс патчера
 * @todo Сохранять последнюю позицию чтения и начинать с нее в ридере
 */
class QuerySnifferMySQL implements IQuerySniffer
{
	/**
	 * @var IReader|null
	 */
	public $reader = null;

	/**
	 * @var IFetcher|null
	 */
	public $fetcher = null;

	/**
	 * @var IFormatter|null
	 */
	public $formatter = null;

	/**
	 * @var IWriter|null
	 */
	public $writer = null;

	/**
	 * @var File[]|null
	 */
	public $inputs = null;

	/**
	 * @var stdClass[]|null
	 */
	public $outputs = null;

	/**
	 * @var bool|null
	 */
	public $debug = null;


	/**
	 * @param array $sources
	 */
	public function __construct(array $sources)
	{
		assert(isset($sources['inputs']));
		assert(isset($sources['outputs']));

		foreach ($sources['inputs'] as $input) {
			$this->inputs[] = new File($input);
		}

		foreach ($sources['outputs'] as $output) {
			$outputObject = new stdClass();
			$outputObject->file = new File($output['file']);
			$outputObject->types = array_map(
				function($type) {
					return new QuerySQLTypeEnum($type);
				},
				$output['types']
			);
			$this->outputs[] = $outputObject;
		}
	}

	/**
	 *
	 */
	public function run()
	{
		$queriesBag = new QueriesBag();

		foreach ($this->inputs as $input) {
			$log = $this->reader->read($input);
			$queriesBag = QueriesBag::merge($queriesBag, $this->fetcher->fetch($log));
		}

		$formatter = new QueryMySQLFormatter();

		foreach ($this->outputs as $output) {
			$filter = new FilterChain();
			$filter
				->append(new QueryMySQLCommandConnectFilter())
				->append(new QueryMySQLCommandInitDBFilter())
				->append(new QuerySQLTypeFilter($output->types));

			$filtered = $queriesBag->filter($filter);

			$this->writer->write($output->file, $formatter->format($filtered));

			/** debug */
			if (!is_null($this->debug)) {
				$this->debug($filtered);
			}
		}
	}

	protected function debug(QueriesBag $filtered)
	{
		$dumpFormatter = new QueryDumpFormatter();

		if (!$this->debug instanceof File) {
			$this->debug = new File($this->debug);
		}
		$this->writer->write($this->debug, $dumpFormatter->format($filtered));
	}
}