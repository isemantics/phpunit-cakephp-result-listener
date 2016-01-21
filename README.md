# phpunit-cakephp-result-listener
Custom ResultPrinterListener for more detailed view of the results, status, duration of your CakePHP testcases.

##Requirements
* PHPUnit
* CakePHP 3
* Some testcases and code to test :)

##Usage
1. Put the VerboseOutputListener somewhere in your CakePHP3 application (where Cake/autoload can find it)
	=> For example: /src/Lib/VerboseOutputListener.php
2. Configure PHPUnit to use the new listener 
	=> Edit the file "phpunit.xml" (if you dont have it, create a default one from some template) and add the part below to the listeners list:

	  <listener class="VerboseOutputListener" file="./src/Lib/VerboseOutputListener.php"></listener>
3. Run "phpunit" in the main directory of your CakePHP3 application. Should show you better formatted test results

##Notes
1. It still will try to output the default PHPUnit output (like: '...F..FF...') between the new output. I tried to
fix it by adding some newlines into the output. Not optimal.
2. Should maybe not define "TAB" and "NEWLINE". This could cause conflict with constants already defined by those names
3. Should add information about risky tests to the output
4. Should perform a code cleanup and add some better documentation in the README
5. Only works with CakePHP at the moment, because of the loading of namespaces/classes (could be improved)

##Status
This is currently in alpha. Main goal is to give other people an idea how to improve the output of PHPUnit, using CakePHP.

##License
Please see [LICENSE](LICENSE)