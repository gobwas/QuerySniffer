<?php
namespace Application\Patcher;
use Application\Patcher\IPatcher;
use Application\Formatter\QueryDumpFormatter;
use Application\Model\QueriesBag;
use stdClass;
use Application\Model\QuerySQLTypeEnum;

use Application\Formatter\QueryMySQLFormatter;
use Application\Formatter\IFormatter;

use Application\Filter\QueryMySQLCommandConnectFilter;
use Application\Filter\QueryMySQLCommandInitDBFilter;
use Application\Filter\QuerySQLTypeFilter;
use Application\Filter\FilterChain;

use Application\Fetcher\IFetcher;

use Application\Filesystem\File;

use Application\Writer\IWriter;
use Application\Reader\IReader;

/**
 * Класс патчера
 * @todo Сохранять последнюю позицию чтения и начинать с нее в ридере
 */
class PatcherMySQL implements IPatcher
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