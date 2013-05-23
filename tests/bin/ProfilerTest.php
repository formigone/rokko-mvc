<?php
require_once("./PHPUnit/Autoload.php");
require_once("./bootstrap.php");

class RokkoMVC_ProfilerTest extends PHPUnit_Framework_TestCase {
	private $prof;

	public function setup() {
		$this->prof = new MockProfiler();
	}

	public function testCount_noTimers_shouldBeZero() {
		$count = $this->prof->getCount();
		$this->assertEquals(0, $count);
	}

	public function testTotal_noTimers_shouldBeZero() {
		$total = $this->prof->getTotal(\Rokko\Profiler::SECONDS);
		$this->assertEquals(0, $total);

		$total = $this->prof->getTotal(\Rokko\Profiler::MINUTES);
		$this->assertEquals(0, $total);

		$total = $this->prof->getTotal(\Rokko\Profiler::HOURS);
		$this->assertEquals(0, $total);

		$total = $this->prof->getTotal(\Rokko\Profiler::TIME);
		$this->assertEquals("00:00:00", $total);
	}

	public function testTotal_openTimer_shouldBeZero() {
		$this->prof->start();

		$total = $this->prof->getTotal(\Rokko\Profiler::SECONDS);
		$this->assertEquals(0, $total);

		$total = $this->prof->getTotal(\Rokko\Profiler::MINUTES);
		$this->assertEquals(0, $total);

		$total = $this->prof->getTotal(\Rokko\Profiler::HOURS);
		$this->assertEquals(0, $total);

		$total = $this->prof->getTotal(\Rokko\Profiler::TIME);
		$this->assertEquals("00:00:00", $total);
	}

	public function testTotal_closedTimerOneSec_shouldBeOneSec() {
		$PHP_SLEEP_DISCLAIMER = "Tough to test because this relies on the accuracy of PHP's sleep()";
		$this->prof->start();
		sleep(1);
		$this->prof->end();

		$total = $this->prof->getTotal(\Rokko\Profiler::SECONDS);
		$this->assertTrue($total >= 1.0 - 0.5 && $total < 1.5, $PHP_SLEEP_DISCLAIMER);

		$total = $this->prof->getTotal(\Rokko\Profiler::MINUTES);
		$this->assertTrue($total >= 1/60 - 0.5 && $total < 0.1, $PHP_SLEEP_DISCLAIMER);

		$total = $this->prof->getTotal(\Rokko\Profiler::HOURS);
		$this->assertTrue($total >= 1/60/60 - 0.5 && $total < 0.1, $PHP_SLEEP_DISCLAIMER);
	}

	public function testTotal_injectedSecond_shouldBeOneSec() {
		$this->prof->start();
		$this->prof->end();

		$sec = 1.0000;
		$min = number_format($sec / 60, 4);
		$hour = number_format($sec / 60 / 60, 4);
		$this->prof->setSeconds($sec);

		$total = $this->prof->getTotal(\Rokko\Profiler::SECONDS);
		$this->assertEquals($sec, $total);

		$total = $this->prof->getTotal(\Rokko\Profiler::MINUTES);
		$this->assertEquals($min, $total);

		$total = $this->prof->getTotal(\Rokko\Profiler::HOURS);
		$this->assertEquals($hour, $total);

		$total = $this->prof->getTotal(\Rokko\Profiler::TIME);
		$this->assertEquals("00:00:01", $total);
	}

	public function testTotal_complexInjectedTime_shouldFormatAsTime() {
		$this->prof->setSeconds(125.0000);
		$total = $this->prof->getTotal(\Rokko\Profiler::TIME);
		$this->assertEquals("00:02:05", $total);

		$this->prof->setSeconds(345.000);
		$total = $this->prof->getTotal(\Rokko\Profiler::TIME);
		$this->assertEquals("00:05:45", $total);

		$this->prof->setSeconds(76543.000);
		$total = $this->prof->getTotal(\Rokko\Profiler::TIME);
		$this->assertEquals("21:15:43", $total);

		$this->prof->setSeconds(59022.000);
		$total = $this->prof->getTotal(\Rokko\Profiler::TIME);
		$this->assertEquals("16:23:42", $total);
	}

	public function testAverage_noTimers_shouldBeNegOne() {
		$total = $this->prof->getAverage(\Rokko\Profiler::SECONDS);
		$this->assertEquals(-1, $total);

		$total = $this->prof->getAverage(\Rokko\Profiler::MINUTES);
		$this->assertEquals(-1, $total);

		$total = $this->prof->getAverage(\Rokko\Profiler::HOURS);
		$this->assertEquals(-1, $total);

		$total = $this->prof->getAverage(\Rokko\Profiler::TIME);
		$this->assertEquals(-1, $total);
	}

	public function testAverage_openTimer_shouldNegOne() {
		$this->prof->start();

		$total = $this->prof->getAverage(\Rokko\Profiler::SECONDS);
		$this->assertEquals(-1, $total);

		$total = $this->prof->getAverage(\Rokko\Profiler::MINUTES);
		$this->assertEquals(-1, $total);

		$total = $this->prof->getAverage(\Rokko\Profiler::HOURS);
		$this->assertEquals(-1, $total);

		$total = $this->prof->getAverage(\Rokko\Profiler::TIME);
		$this->assertEquals(-1, $total);
	}

	public function testTotal_AverageTimerOneSec_shouldBeOneSec() {
		$PHP_SLEEP_DISCLAIMER = "Tough to test because this relies on the accuracy of PHP's sleep()";
		$this->prof->start();
		sleep(1);
		$this->prof->end();

		$total = $this->prof->getAverage(\Rokko\Profiler::SECONDS);
		$this->assertTrue($total >= 1.0 - 0.5 && $total < 1.5, $PHP_SLEEP_DISCLAIMER);

		$total = $this->prof->getAverage(\Rokko\Profiler::MINUTES);
		$this->assertTrue($total >= 1/60 - 0.5 && $total < 0.1, $PHP_SLEEP_DISCLAIMER);

		$total = $this->prof->getAverage(\Rokko\Profiler::HOURS);
		$this->assertTrue($total >= 1/60/60 - 0.5 && $total < 0.1, $PHP_SLEEP_DISCLAIMER);
	}

	public function testAverage_injectedSecond_shouldBeOneSec() {
		$this->prof->start();
		$this->prof->end();

		$sec = 1.0000;
		$min = number_format($sec / 60, 4);
		$hour = number_format($sec / 60 / 60, 4);
		$this->prof->setSeconds($sec);

		$count = $this->prof->getCount();
		$this->assertEquals(1, $count);

		$total = $this->prof->getAverage(\Rokko\Profiler::SECONDS);
		$this->assertEquals($sec, $total);

		$total = $this->prof->getAverage(\Rokko\Profiler::MINUTES);
		$this->assertEquals($min, $total);

		$total = $this->prof->getAverage(\Rokko\Profiler::HOURS);
		$this->assertEquals($hour, $total);

		$total = $this->prof->getAverage(\Rokko\Profiler::TIME);
		$this->assertEquals("00:00:01", $total);
	}

	public function testAverage_complexInjectedTime_shouldFormatAsTime() {
		$this->prof->start();
		$this->prof->end();

		$this->prof->start();
		$this->prof->end();

		$this->prof->start();
		$this->prof->end();

		$count = $this->prof->getCount();
		$this->assertEquals(3, $count);

		$this->prof->setSeconds(125.0000); // Avg 41.66666
		$total = $this->prof->getAverage(\Rokko\Profiler::TIME);
		$this->assertEquals("00:00:42", $total);

		$this->prof->setSeconds(345.000); // Avg 115.00000
		$total = $this->prof->getAverage(\Rokko\Profiler::TIME);
		$this->assertEquals("00:01:55", $total);

		$this->prof->setSeconds(76543.000); // Avg 25514.33333
		$total = $this->prof->getAverage(\Rokko\Profiler::TIME);
		$this->assertEquals("07:05:14", $total);

		$this->prof->setSeconds(59022.000); // Avg 19674
		$total = $this->prof->getAverage(\Rokko\Profiler::TIME);
		$this->assertEquals("05:27:54", $total);
	}

	public function testClear_closedTimerOneSec_shouldBeZero() {
		$this->prof->start();
		sleep(1);
		$this->prof->end();
		$this->prof->clear();
	
		$count = $this->prof->getCount();
		$this->assertEquals(0, $count);

		$total = $this->prof->getTotal(\Rokko\Profiler::SECONDS);
		$this->assertEquals(0, $total);

		$total = $this->prof->getTotal(\Rokko\Profiler::MINUTES);
		$this->assertEquals(0, $total);

		$total = $this->prof->getTotal(\Rokko\Profiler::HOURS);
		$this->assertEquals(0, $total);

		$total = $this->prof->getTotal(\Rokko\Profiler::TIME);
		$this->assertEquals("00:00:00", $total);

		$total = $this->prof->getAverage(\Rokko\Profiler::SECONDS);
		$this->assertEquals(-1, $total);

		$total = $this->prof->getAverage(\Rokko\Profiler::MINUTES);
		$this->assertEquals(-1, $total);

		$total = $this->prof->getAverage(\Rokko\Profiler::HOURS);
		$this->assertEquals(-1, $total);

		$total = $this->prof->getAverage(\Rokko\Profiler::TIME);
		$this->assertEquals(-1, $total);
	}
}

class MockProfiler extends \Rokko\Profiler {
	public function setSeconds($seconds) {
		$this->microSum = $seconds;
	}

	public function getAverageDebug() {
		return $this->microSum;
	}
}
