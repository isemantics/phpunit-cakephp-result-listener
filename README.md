# phpunit-cakephp-result-listener
Custom ResultPrinterListener for more detailed view of the results, status, duration of your CakePHP testcases.

1. Put the VerboseOutputListener somewhere in your CakePHP3 application (where Cake/autoload can find it)
	=> For example: /src/Lib/VerboseOutputListener.php
2. Configure PHPUnit to use the new listener 
	=> Edit the file "phpunit.xml" (if you dont have it, create a default one from some template) and add the part below to the listeners list:

	  <listener class="VerboseOutputListener" file="./src/Lib/VerboseOutputListener.php"></listener>
3. Run "phpunit" in the main directory of your CakePHP3 application. Should show you better formatted test results


Notes
1. It still will try to output the default PHPUnit output (like: '...F..FF...') between the new output. I tried to
fix it by adding some newlines into the output. Not optimal.
