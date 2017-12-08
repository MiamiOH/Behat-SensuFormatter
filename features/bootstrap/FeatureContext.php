<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;
use Behat\Behat\Tester\Exception\PendingException;
use PHPUnit\Framework\Assert;



/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
  /**
   * @var string
   */
  private $phpBin;
  /**
   * @var Process
   */
  private $process;
  /**
 * @var string
 */
private $workingDir;
/**
 * @var string
 */
private $output;


/**
   * Cleans test folders in the temporary directory.
   *
   * @BeforeSuite
   * @After Suite
   */
  public static function cleanTestFolders()
  {
      if (is_dir($dir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'behat')) {
          self::clearDirectory($dir);
      }
  }

  /**
   * Prepares test folders in the temporary directory.
   *
   * @BeforeScenario
   */
  public function prepareTestFolders()
  {
      $dir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'behat';

      $this->createDirectory($dir . '/features/bootstrap/i18n', 0777, true);

      $phpFinder = new PhpExecutableFinder();
      if (false === $php = $phpFinder->find()) {
          throw new \RuntimeException('Unable to find the PHP executable.');
      }
      $this->workingDir = $dir;
      $this->phpBin = $php;
      $this->process = new Process(null);
  }
    /**
     * Creates a file with specified name and context in current workdir.
     *
     * @Given /^(?:there is )?a file named "([^"]*)" with:$/
     *
     * @param string       $filename name of the file (relative path)
     * @param PyStringNode $content  PyString string instance
     */
    public function aFileNamedWith($filename, PyStringNode $content)
    {
        $content = strtr((string) $content, array("'''" => '"""'));
        $this->createFile($this->workingDir . '/' . $filename, $content);
    }

    /**
     * Runs behat command with provided parameters
     *
     * @When /^I run "behat(?: ((?:\"|[^"])*))?"$/
     *
     * @param string $argumentsString
     */
    public function iRunBehat($argumentsString = '')
    {
        $argumentsString = strtr($argumentsString, array('\'' => '"'));

        $this->process->setWorkingDirectory($this->workingDir);
        $this->process->setCommandLine(
            sprintf(
                '%s %s %s %s',
                $this->phpBin,
                escapeshellarg(BEHAT_BIN_PATH),
                $argumentsString,
                strtr('--format-settings=\'{"timer": false}\'', array('\'' => '"', '"' => '\"'))
            )
        );

        // Don't reset the LANG variable on HHVM, because it breaks HHVM itself
        if (!defined('HHVM_VERSION')) {
            $env = $this->process->getEnv();
            $env['LANG'] = 'en'; // Ensures that the default language is en, whatever the OS locale is.
            $this->process->setEnv($env);
        }

        $this->process->run();

        $this->output = $this->process->getOutput();
    }

   private function createFile($filename, $content)
   {
       $path = dirname($filename);
       $this->createDirectory($path);

       file_put_contents($filename, $content);
   }
   private function createDirectory($path)
   {
       if (!is_dir($path)) {
           mkdir($path, 0777, true);
       }
   }
   private static function clearDirectory($path)
   {
       $files = scandir($path);
       array_shift($files);
       array_shift($files);

       foreach ($files as $file) {
           $file = $path . DIRECTORY_SEPARATOR . $file;
           if (is_dir($file)) {
               self::clearDirectory($file);
           } else {
               unlink($file);
           }
       }

       rmdir($path);
   }
  private function getExitCode()
  {
      return $this->process->getExitCode();
  }

  /**
  * @Then the return code should be :returnCode
  */
 public function theReturnCodeShouldBe($returnCode)
 {
   // print_r($this->process);
   print_r($this->output);
   Assert::assertEquals($returnCode, $this->getExitCode());
 }

 /**
  * @Then the output should contain :outputString
  */
 public function theOutputShouldContain($outputString)
 {
     print_r($this->output);
     Assert::assertEquals($outputString,$this->output);
 }

}
