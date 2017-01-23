# This is the Installation process fo

Requirements :
- 200 MB of storage
- Globally Installed Composer
- Project installed in the system.
- Github access
- Chromedriver.exe Download it from : https://christopher.su/2015/selenium-chromedriver-ubuntu/#selenium-version
- phantomjsdriver.exe Download and Install if from : https://gist.github.com/julionc/7476620

# Steps to follow to enable Automation Test Cases
- After setting up proejct in the system, go to test folder.
- Inside test folder, run "composer install" to install all the dependencies present in composer.json file
- After Installing all the dependencies, run bin/behat --init
- It will create "feature" folder in you directory
- Now copy all the files present in "copy_feature" folder to feature folder.


# Now you are ready to go.

Enhancement from developer site:
- If developer changes any in site on which he is runnung test cases, then he needs to chasnge in script as well which is present in feature. 
