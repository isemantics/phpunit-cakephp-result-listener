<?php
/**
 * Isemantics
 * Copyright (c) Michel Peters
 *
 * @copyright	 Copyright (c) Isemantics (http://www.isemantics.nl)
 * @author		Michel Peters <info@isemantics.nl>
 */

define('NEWLINE', "\n");
define('TAB', "\t");

class VerboseOutputListener implements PHPUnit_Framework_TestListener {

    private $currentTestSuiteName = null;
    private $currentTestName = null;
    private $currentTestPass = true;

    /**
     * Run when some error occurs while running the test
     * @param PHPUnit_Framework_Test $test 
     * @param Exception $e 
     * @param mixed $duration 
     */
    public function addError(PHPUnit_Framework_Test $test, Exception $e, $duration) {
        $this->testResult('ERROR',$duration,$e->getMessage());
        $this->currentTestPass = false;
    }

    /**
     * Run for failed tests
     * @param PHPUnit_Framework_Test $test 
     * @param PHPUnit_Framework_AssertionFailedError $e 
     * @param mixed $duration 
     */
    public function addFailure(PHPUnit_Framework_Test $test, PHPUnit_Framework_AssertionFailedError $e, $duration) {
        $this->testResult('FAILED',$duration,$e->getMessage());
        $this->currentTestPass = false;
    }

    /**
     * Run for incomplete tests
     * @param PHPUnit_Framework_Test $test 
     * @param Exception $e 
     * @param mixed $duration 
     */
    public function addIncompleteTest(PHPUnit_Framework_Test $test, Exception $e, $duration) {
        $this->testResult('INCOMPLETE', $duration, array(), 'Incomplete Test');
        $this->currentTestPass = false;
    }

    /**
     * Run for skipped tests 
     * @param PHPUnit_Framework_Test $test 
     * @param Exception $e 
     * @param mixed $duration 
     */
    public function addSkippedTest(PHPUnit_Framework_Test $test, Exception $e, $duration) {
        $this->testResult('SKIPPED', $duration, array(), 'Skipped Test');
        $this->currentTestPass = false;
    }
    
    /**
     * Run at start of testsuite
     * @param PHPUnit_Framework_TestSuite $suite 
     */
    public function startTestSuite(PHPUnit_Framework_TestSuite $suite) {
        $this->currentTestSuiteName = $suite->getName();
        $this->currentTestName = '';
        $this->write("RUNNING: " . $this->currentTestSuiteName . " (" . count($suite) . " tests)");
    }

    /**
     * Run at end of testsuite
     * @param PHPUnit_Framework_TestSuite $suite 
     */
    public function endTestSuite(PHPUnit_Framework_TestSuite $suite) {
        $this->currentTestSuiteName = '';
        $this->currentTestName = '';
    }

    /**
     * Run at start of test
     * @param PHPUnit_Framework_Test $test 
     */
    public function startTest(PHPUnit_Framework_Test $test) {
        $this->currentTestName = PHPUnit_Util_Test::describe($test);
        $this->currentTestPass = TRUE;
    }

    /**
     * Run when a test ends
     * @param PHPUnit_Framework_Test $test 
     * @param mixed $duration 
     */
    public function endTest(PHPUnit_Framework_Test $test, $duration) {
        if ($this->currentTestPass) {
            $this->testResult('SUCCESS', $duration);
        }
    }

    /**
     * Run when a testcase is marked as risky
     * @param PHPUnit_Framework_Test $test 
     * @param Exception $e 
     * @param mixed $duration 
     */
    public function addRiskyTest(PHPUnit_Framework_Test $test, Exception $e, $duration) {
    }

    /**
     * General output handler
     * @param mixed $status 
     * @param mixed $duration 
     * @param mixed $message 
     */
    private function testResult($status, $duration, $message = '') { 

        $data = [];

        // Round time (to prevent long list of decimals)
        $duration = round($duration * 1000,2) . 'ms';

        // Add detailed test information to output
        $data[] = "TEST: " . $this->_getMethodName($this->currentTestName);
        $data[] = TAB . "Result: " . $status;
        $data[] = TAB . "Time: " . $duration;

        // Add message if it's not empty
        if (!empty($message)) $data[] = TAB . "Message: " .$message;

        // Concat output and write it to console
        $message = NEWLINE . implode(NEWLINE,$data);
        $this->write($message);

    }

    /**
     * Helper to get the method name only from a full namespace string + methodname. 
     * Example: 'App\TestSuite\Controller\UsersControllerTest::testAction' will return 'testAction'
     * @param mixed $fullName 
     * @return mixed 
     */
    private function _getMethodName($fullName) {

        $methodName = null;

        // Search for '::' seperator
        if (stristr($fullName,'::')) {
            $ex = explode('::', $fullName);
            // Ensure exactly 2 elements after split
            if (count($ex) === 2) {
                // Assume second part is what we want
                $methodName = $ex[1];
            }
        }

        return $methodName;

    }

    /**
     * Helper function to print data to console.
     * TODO: Should use STDERR or some PHP output writer
     * 
     * @param mixed $data 
     */
    private function write($data) {
        // We dont support writing arrays (yet)
        if (is_array($data)) return false;

        // Print data directly to current output
        echo $data . NEWLINE;

        return true;
    }

}

?>