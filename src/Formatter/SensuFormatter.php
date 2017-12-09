<?php

namespace miamioh\BehatSensuFormatter\Formatter;

use Behat\Testwork\Output\Formatter;
use miamioh\BehatSensuFormatter\Printer\StreamOutputPrinter;
use Behat\Behat\EventDispatcher\Event\AfterScenarioTested;
use Behat\Behat\EventDispatcher\Event\BeforeScenarioTested;

use Behat\Testwork\EventDispatcher\Event\ExerciseCompleted;
use Behat\Testwork\EventDispatcher\Event\BeforeExerciseCompleted;
use Behat\Testwork\EventDispatcher\Event\AfterExerciseCompleted;
use Behat\Testwork\Counter\Timer;

/**
 * Class: SensuFormatter
 *
 * @see Formatter
 */
class SensuFormatter implements Formatter
{
    /** @var mixed */
    private $printer;

    /** @var Timer */
    private $exerciseTimer;

    /** @var Timer */
    private $scenarioTimer;

    /** @var int */
    private $passedCounter = 0;
    /** @var int */
    private $failedCounter = 0;

    public function __construct($warning, $critical)  {
        $this->options['warning'] = $warning;
        $this->options['critical'] = $critical;

        $this->printer  = new StreamOutputPrinter();
        $this->exerciseTimer  = new Timer();
        $this->exerciseTimer->start();
        $this->scenarioTimer = new Timer();

    }


  /**
   * Returns formatter name.
   *
   * @return string
   */
  public function getName()
  {
          return 'SensuFormatter';
  }


  /**
   * Returns formatter description.
   *
   * @return string
   */
  public function getDescription()
  {
      return 'Generates output for Sensu';
  }


  /**
   * Returns formatter output printer.
   *
   * @return OutputPrinter
   */
  public function getOutputPrinter()
  {
          return $this->printer;
  }


  /**
   * Sets formatter parameter.
   *
   * @param string $name
   * @param mixed  $value
   */
  public function setParameter($name, $value)
  {
    $this->parameters[ $name ] = $value;
  }


  /**
   * Returns parameter name.
   *
   * @param string $name
   *
   * @return mixed
   */
  public function getParameter($name)
  {
    return $this->parameters[ $name ];
  }
  /**
   * {@inheritDoc}
   */
  public static function getSubscribedEvents()
  {
    return array(
            'tester.exercise_completed.after'  => array('afterExercise', -50),
            'tester.scenario_tested.before'    => array('beforeScenario', -50),
            'tester.scenario_tested.after'     => array('afterScenario', -50),
            );
  }

  /**
   * @param AfterExerciseCompleted $event
   */
  public function afterExercise(AfterExerciseCompleted $event)
  {
    $this->exerciseTimer->stop();
    $this->calcRunStatus();
  }

  protected function calcRunStatus(){
    $totalTests = $this->passedCounter + $this->failedCounter;
    $failRate = round(($this->failedCounter / $totalTests) * 100);
    // print_r($failRate . '-'. $this->options['warning'].'-' .$this->options['critical']);
    $failedStats = "$this->failedCounter tests out of $totalTests total tests failed";
      if ($failRate == 0) {
        $this->printer->write("OK: All $totalTests tests passed");
        exit(0);
          return;
      }
      if (($failRate > 1) && ($failRate < $this->options['warning'])) {
        $this->printer->write("OK: $this->passedCounter tests out of $totalTests passed");
        exit(0);
        return;
      }
      if (($failRate > $this->options['warning']) && ($failRate < $this->options['critical'])) {
        $this->printer->write("Warning: $failedStats");
        exit(1);
        return;
      }
      if (($failRate > $this->options['critical']) && ($failRate < 99 )) {
        $this->printer->write("Critical: $failedStats");
        exit(2);
        return;
      }
      if ($failRate == 100) {
        $this->printer->write("Critical: All $totalTests tests failed");
        exit(2);
        return;
      }
  }
  /**
   * @param BeforeScenario $event
   */
  public function beforeScenario(BeforeScenarioTested $event)
  {
      $this->scenarioTimer->start();
  }
  /**
   * @param AfterScenario $event
   */
  public function afterScenario(afterScenarioTested $event)
  {
    $scenarioPassed = $event->getTestResult()->isPassed();
    $this->scenarioTimer->stop();
    if ($scenarioPassed) {
        $this->passedCounter++;
    } else {
        $this->failedCounter++;
    }

  }

}
