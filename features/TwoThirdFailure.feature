Feature: Return Exit Status for Tests

Background:
  Given a file named "behat.yml" with:
  """
  default:
    formatters:
      SensuFormatter: ~
    extensions:
      miamioh\BehatSensuFormatter\BehatSensuFormatterExtension: ~

  """
  And a file named "features/bootstrap/FeatureContext.php" with:
    """
    <?php
      use Behat\Behat\Context\CustomSnippetAcceptingContext,
          Behat\Behat\Tester\Exception\PendingException,
          PHPUnit\Framework\Assert;

      class FeatureContext implements CustomSnippetAcceptingContext
      {
          public static function getAcceptedSnippetType() { return 'regex'; }
          /** @When /^I give a passing step$/ */
          public function passingStep() {
            Assert::assertEquals(2, 2);
          }
          /** @When /^I give a failing step$/ */
          public function failingStep() {
            Assert::assertEquals(1, 2);
          }
      }
    """

  Scenario: Suite with all Multiple tests
    Given a file named "features/testScenario.feature" with:
      """
      Feature: Suite running with passing scenarios
        Scenario: Passing scenario
          When I give a passing step
        Scenario: Failing scenario
          When I give a failing step
        Scenario: Failing scenario
          When I give a failing step
      """
    When I run "behat --no-colors"
    Then the output should contain "Critical: 2 tests out of 3 total tests failed"
    And the Return Code Should Be 2
