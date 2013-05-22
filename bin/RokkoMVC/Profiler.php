<?php
namespace Rokko;

class Profiler {
	private $microSum;
	private $tmpMicroSum;
	private $count;

	const SECONDS = 0;
	const MINUTES = 1;
	const HOURS = 2;
	const TIME = 3;

	public function __construct() {
		$this->microSum = 0;
		$this->tmpMicroSum = null;
		$this->count = 0;
	}

	public function clear() {
		$this->microSum = 0;
		$this->tmpMicroSum = null;
		$this->count = 0;
	}

	public function start() {
		$this->tmpMicroSum = microtime(true);
	}

	public function end() {
		if ($this->tmpMicroSum != null) {
			$this->microSum += microtime(true) - $this->tmpMicroSum;
			$this->tmpMicroSum = null;
			$this->count++;
		}
	}

	public function getAverage($format = self::SECONDS) {
		if ($this->microSum == 0) {
			return -1;
		}

		switch ($format) {
			case self::SECONDS:
				return number_format($this->microSum / $this->count, 4);
			case self::MINUTES:
				return number_format($this->microSum / $this->count / 60, 4);
			case self::HOURS:
				return number_format($this->microSum / $this->count / 60 / 60, 4);
			default:
				return number_format($this->microSum / $this->count, 4);
		}
	}

	public function getTotal($format = self::SECONDS) {
		switch ($format) {
			case self::SECONDS:
				return number_format($this->microSum, 4);
			case self::MINUTES:
				return number_format($this->microSum / 60, 4);
			case self::MINUTES:
				return number_format($this->microSum / 60 / 60, 4);
			default:
				return number_format($this->microSum, 4);
		}
	}

	public function getCount() {
		return $this->count;
	}
}

