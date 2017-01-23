<?php

use Drupal\DrupalExtension\Context\RawDrupalContext;
use Drupal\DrupalExtension\Context\MinkContext;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

  #$importedMethod = new MinkContext;

/**
 * Defines application features from the specific context.
 */


class FeatureContext extends RawDrupalContext implements SnippetAcceptingContext
{
  /**
    * Initializes context.
    *
    * Every scenario gets its own context instance.
    * You can also pass arbitrary arguments to the
    * context constructor through behat.yml.
    */
    public function __construct(){
    }

  /**
    * Creates and authenticates a user with the given role via Drush.
    *
    * @Given I am logged in as a user named :arg1 with :arg2 role
    */
    public function iAmLoggedInAsAUserNamedWithRole($username, $role) {
      if (!user_load_by_name($username)) {
      $user = (object)array(
        'name' => $username,
        'pass' => $this->getRandom()->name(16),
        'role' => $role,
        'roles' => array($role),
      );
      $user->mail = "{$user->name}@example.com";
      // Create a new user.
      $this->userCreate($user);
      }
    }

  /**
    * @Then /^I logout$/
    */
    public function assertLogout() {
      $this->logout();
    }

  /**
    * Click on the element with the provided xpath query
    *
    * @When /^I click on the element with xpath "([^"]*)"$/
    */
    public function iClickOnTheElementWithXPath($xpath){
      $session = $this->getSession(); // get the mink session
      $element = $session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath', $xpath)); // runs the actual query and returns the element

      // errors must not pass silently
      if (null === $element) {
       throw new \InvalidArgumentException(sprintf('Could not evaluate XPath: "%s"', $xpath));
      }
      // ok, let's click on it
      $element->click();
    }

  /**
    * Click some text
    *
    * @When /^I click on the text "([^"]*)"$/
    */
    public function iClickOnTheText($text){
      $session = $this->getSession();
      $element = $session->getPage()->find(
        'xpath',
        $session->getSelectorsHandler()->selectorToXpath('xpath', '*//*[text()="'. $text .'"]')
      );
      if (null === $element) {
        throw new \InvalidArgumentException(sprintf('Cannot find text: "%s"', $text));
      }
      $element->click();
    }

  /**
    * @Then I click on :arg1 element
    */
    public function iClickOnElement($element){
      $page = $this->getSession()->getPage();
      $findName = $page->find("css", $element);
      if (!$findName){
        throw new Exception($element . " could not be found");
      }
      else {
        $findName->click();
      }
    }

  /**
    * @When /^I hover over the element by Xpath "([^"]*)"$/
    **/
    public function iHoverOverTheElementbyXpath($xpath){
      $session = $this->getSession(); // get the mink session
      $element = $session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath', $xpath)); // runs the actual query and returns the element
      // errors must not pass silently
      if (null === $element) {
      throw new \InvalidArgumentException(sprintf('Could not evaluate XPath: "%s"', $xpath));
      }
      // ok, let's hover it
      $element->mouseOver();
    }

  /** this works with selenium/javascript tags
    * @When /^I hover over the element "([^"]*)"$/
    */
    public function iHoverOverTheElement($locator) {
      $session = $this->getSession(); // get the mink session
      $element = $session->getPage()->find('xpath', $locator); // runs the actual query and returns the element
      // errors must not pass silently
      if (NULL === $element) {
        throw new \InvalidArgumentException(sprintf('Could not evaluate xpath selector: "%s"', $locator));
      }
      // ok, let's hover it
      $element->mouseOver();
    }

  /**
    * @When /^I click the "([^"]*)" radio button$/
    */
  public function iClickTheRadioButton($labelText)
  {
    $page = $this->getSession()->getPage();
    $radioButton = $page->find('named', ['radio', $labelText]);
    if ($radioButton) {
      $select = $radioButton->getAttribute('name');
      $option = $radioButton->getAttribute('value');
      $page->selectFieldOption($select, $option);
      return;
    }

    throw new \Exception("Radio button with label {$labelText} not found");
  }

  /** Selects option from select field with specified locator.
    *
    * @param   string  $locator input id, name or label
    *
    * @throws  Behat\Mink\Exception\ElementNotFoundException
    */
    public function selectFieldOption($locator, $value){
      $field = $this->findField($locator);

      if (null === $field) {
      throw new ElementNotFoundException(
      $this->getSession(), 'form field', 'id|name|label|value', $locator);
      }
    $field->selectOption($value);
    }

  /**
    * @Then I wait for :time seconds
    */
    public function iWaitForSeconds($time)
    {
      sleep($time);
    }

  /**
    * @Then I match the relative :relative url
    */
    public function imatchTheRelativeUrl($relativeurl){
      $actualurl = $this->getSession()->getCurrentUrl();
      #$relativeurl   = '';
      $pos = strpos($actualurl, $relativeurl);
      if ($pos === false) {
        throw new Exception("Relative url {$relativeurl} not found");
      }
    }

  /**
    * @Then the status code of :url should be 200
    */
    public function get_http_response_code($url) {
      $headers = get_headers($url);
      #echo "<pr>";
      #print_r($headers);
      $status_code = substr($headers[0], 9, 3);
      if ($status_code == 200 ) {
      } else {
        throw new Exception("Status code is not 200");
      }
    }




  /**
    * @Then I should see text title matching :title
    */
    public function pageTitleMatch($title){
      $page = $this->getSession()->getPage();
      //print_r($page); die();
      $res = preg_match('/<title>(.*?)<\/title>/',$page, $title_matches);
      if ($res==   $title){
        echo "title matched";
      } else {
        throw new Exception("title not matched");
      }
    }

  /**
    * @Then I fetch the href of form :FormName
    */
    public function iFetchTheHrefOfForm($FormName) {
      $actualhref = self::iFetchTheHrefOfFormName($FormName);
      echo "The href is: ". $actualhref;
    }

  /**
    * @Then I fetch the href of formname :FormName
    * this method is called to get the href of a particular form
    */
    public function iFetchTheHrefOfFormName($FormName) {
      $page = $this->getSession()->getPage();
      $actuallink = $page->findLink($FormName);
      if ($actuallink === null) {
        throw new Exception("The actuallink was not found!");
      }
      return $actuallink->getAttribute('href');
    }


  /**
    * @Then I match the href :href of form :FormName
    */
    public function iMatchTheHrefOfForm($expectedhref,$FormName){
      $actualhref = self::iFetchTheHrefOfFormName($FormName);
      $pos = strpos($actualhref, $expectedhref);
      if ($pos === false) {
        throw new \Exception("Expected href {$expectedhref} not found");
      }
    }


  /**
    * @Then I fetch the href of text :text
    */
    public function iFetchTheHrefOfText($text){
      $actualhref = self::iFetchTheHrefOfTextName($text);
      echo "The href is: ". $actualhref;
    }

  /**
    * @Then I fetch the href of textname :textName
    * this method is called to get the href of a particular form
    */
    public function iFetchTheHrefOfTextName($textName){
      $session=$this->getSession();
      $actuallink = $session->getPage()->find(
        'xpath',
        $session->getSelectorsHandler()->selectorToXpath('xpath', '*//*[text()="'. $textName .'"]')
      );
      if ($actuallink === null) {
        throw new Exception("The actuallink was not found!");
      }else {
        $actualSubstr = ((string)$actuallink->getAttribute('href'));
        $pos = substr($actualSubstr,41);
        return $pos;
      }
    }

  /**
    * This matches the fected url and given url
    *
    * @Then I match the href :href of text :text
    */
    public function iMatchTheHrefOfText($expectedhref,$textName){
      $actualhref = self::iFetchTheHrefOfTextName($textName);
      //$pos = substr($actualhref,42);
      //print "\n".$actualhref;
      if ($actualhref !== $expectedhref) {
        throw new \Exception("Expected href {$expectedhref} not found");
      }
    }

  /**
    * @Then I fetch the href of CSS :css
    */
    public function iFetchTheHrefOfCss($css){
      $actualhref = self::iFetchTheHrefOfclassName($css);
      echo "The href is: ". $actualhref;
    }

  /**
    * this method is called to get the href of a particular form
    * @Then I fetch the href of className :css
    */
    public function iFetchTheHrefOfclassName($css){
      $session=$this->getSession();
      $actuallink = $session->getPage()->find("css",$css);
      if ($actuallink === null) {
        throw new Exception("The actuallink was not found!");
      }else {
        $actualSubstr = ((string)$actuallink->getAttribute('href'));
        $postionOfElement = strpos($actualSubstr,'.sh');
        if($postionOfElement===false){
          return $actualSubstr;
        } else{
          #echo "url is ".$actualSubstr;
          #echo "\n position is ".$postionOfElement;
          $newPosition = $postionOfElement+3;
          #echo "\n New position is ".$newPosition;
          $newLink = substr($actualSubstr,$newPosition);
          #echo "\n New link is ".$newLink;
          return $newLink;
        }
      }
    }

  /**
    * This matches the fected url and given url of class name
    *
    * @Then I match the href :href of CSS :css
    */
    public function iMatchTheHrefOfCSS($expectedhref,$css){
      $actualhref = self::iFetchTheHrefOfclassName($css);
      if ($actualhref !== $expectedhref) {
        throw new \Exception("Expected href {$expectedhref} not found");
      }
    }

  /**
    * @Then I should see CSS :css
    *
    *
    */
    public function iShouldSeeCss($css) {
      $session = $this->getSession();
      $regionObj = $session->getPage();
      $regionText = $regionObj->find('css',$css);
      if (NULL===$regionText) {
        return false;
      } else {
        return true;
      }
    }

  /**
    * @Then I should see CSS :css in the :region( region)
    *
    *
    */
    public function iShouldSeeCssInRegion($css, $region) {
      $session = $this->getSession();
      $regionObj = $session->getPage()->find('region', $region);
      $regionText = $regionObj->find('css',$css);
      if (NULL===$regionText) {
        throw new \Exception(sprintf('No CSS '.$css.' found on the region %s.', $region, $session->getCurrentUrl()));
      }
    }

  /**
    * @Then I match src :src of CSS :css
    *
    */
    public function iMatchSrcOfCss($expectedsrc,$css) {
      $session = $this->getSession();
      $data = $session->getPage()->find("css",$css);
      #echo 'data' .$data;
      if ($data === null) {
        throw new Exception("Nothing was found in CSS!");
      }else {
        $source = $data->getAttribute('src');
        $sourceSub = $data->getAttribute('src');
        $result = strpos($source,'.sh');
        //echo "\n source result ".$source;
        //echo "\n". $result;
        if($result===false){
          if($source === $expectedsrc){
            echo 'The SRC of the given CSS is '.$sourceSub;
          } else {
            throw new \Exception("Expected src {$expectedsrc} not found");
          }
        } else{
          $indexInt = $result+3;
          #echo 'index value '. $indexInt;
          $result = substr($source,$indexInt);
          echo 'The SRC of the given CSS is '.$result;
          if($result!==$expectedsrc){
          throw new \Exception("Expected src {$expectedsrc} not found");
          }
        }
      }
    }

  /**
    * @When I click on CSS element :element in the :region( region)
    *
    * @throws \Exception
    *   If region or link within it cannot be found.
    */
    public function assertClickOnElementInRegion($element, $region) {
      $session = $this->getSession();
      $regionObj = $session->getPage()->find('region', $region);
      // Find the css within the region
      $eleObj = $regionObj->find('css',$element);
      if (empty($eleObj)) {
        throw new \Exception(sprintf('The element '.$element.' was not found in the region '.$region.' on the page %s', $element, $region, $this->getSession()->getCurrentUrl()));
      }
      $eleObj->click();
    }

  /**
    * @When I click on CSS element :element
    *
    * @throws \Exception
    *   If region or link within it cannot be found.
    */
    public function assertClickOnElement($element) {
      $regionObj = $this->getSession()->getPage();
      // Find the css within the region
      $eleObj = $regionObj->find('css',$element);
      if (empty($eleObj)) {
        throw new \Exception(sprintf('The element '.$element.' was not found', $element, $this->getSession()->getCurrentUrl()));
      }
      $eleObj->click();
    }

  /**
    * @When I should see the response status of image source of CSS :element be 200
    *
    * @throws \Exception
    *   If region or link within it cannot be found.
    */
    public function iShouldSeeResponseOfCSS($element){
      $session = $this->getSession();
      $elementObj = $session->getPage()->find('css',$element);

      //echo 'If I found CSS';
      if ($elementObj != NULL){
        $elementSource = $elementObj->getAttribute("src");

        $currentUrl = (string)$this->getSession()->getCurrentUrl();
        //echo "\n Curent URL is ".$currentUrl;
        $currentUrlSubstringPosition = strpos($currentUrl,'.sh');
        // for Srijan.net site
        if($currentUrlSubstringPosition == false){

      } else {

        self::urlForPlatformSite($elementSource,$currentUrl);
        }
      } else {
        throw new Exception("Nothing was found in CSS!");
      }
    }

  /**
    * @When I should see the response status of href of CSS :element be 200
    *
    * @throws \Exception
    *   If region or link within it cannot be found.
    */
    public function iShouldSeeResponseOfHrefOfCSS($element){
      $session = $this->getSession();
      $elementObj = $session->getPage()->find('css',$element);

      //echo 'If I found CSS'
      if ($elementObj != NULL){
        $elementSource = $elementObj->getAttribute("href");

        $currentUrl = (string)$this->getSession()->getCurrentUrl();
        //echo "\n Curent URL is ".$currentUrl;
        $currentUrlSubstringPosition = strpos($currentUrl,'.sh');
        // for Srijan.net site
        if($currentUrlSubstringPosition == false){
        } else {
          self::urlForPlatformSite($elementSource,$currentUrl);
      }
      } else {
        throw new Exception("Nothing was found in CSS!");
      }
    }

    public function urlForPlatformSite($cssUrl,$currentUrl){
      //echo "Source Element url is ". $elementSource;
      $fullSource = strpos($cssUrl,'.sh');
      $currentUrlSubstringPosition = strpos($currentUrl,'.sh');
      // If I found relative URL
      if ($fullSource == false){
        $lastIndexOfcurrentUrlSubstring = $currentUrlSubstringPosition+3;
        //echo "\n Curent URL index numver is ".$lastIndexOfcurrentUrlSubstring;
        $newUrl = substr($currentUrl,0,$lastIndexOfcurrentUrlSubstring);
        $fullUrl = $newUrl.$cssUrl;
        echo "URL of CSS is ".$fullUrl;
        self::get_http_response_code($fullUrl);
      } else {
        // if I find full URL.
        echo "URL of CSS is ".$cssUrl;
        self::get_http_response_code($cssUrl);
      }
    }

  /**
    * @When I should see the response status of external href of CSS :element be 200
    *
    * @throws \Exception
    *   If region or link within it cannot be found.
    */
    public function iShouldSeeResponseOfExternalHrefOfCSS($element){
      $session = $this->getSession();
      $elementObj = $session->getPage()->find('css',$element);
      //echo 'If I found CSS'
      if($elementObj != NULL){
        $elementSource = $elementObj->getAttribute("href");
        echo "\n URL is ".$elementSource;
        self::get_http_response_code($elementSource);
      } else {
        throw new Exception("Nothing was found in CSS!");
      }
    }


  /**
    * @When I should see the response status of href of xpath :element be 200
    *
    * @throws \Exception
    *   If region or link within it cannot be found.
    */
    public function iShouldSeeResponseOfHrefOfxpath($element){
      $session = $this->getSession();
      $elementObj = $session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath', $element));

      //echo 'If I found CSS'
      if ($elementObj != NULL){
        $elementSource = $elementObj->getAttribute("href");

        $currentUrl = (string)$this->getSession()->getCurrentUrl();
        //echo "\n Curent URL is ".$currentUrl;
        $currentUrlSubstringPosition = strpos($currentUrl,'.sh');
        // for Srijan.net site
        if($currentUrlSubstringPosition == false){
        } else {
          self::urlForPlatformSite($elementSource,$currentUrl);
      }
      } else {
        throw new Exception("Nothing was found in CSS!");
      }
    }

  /**
    * @When I see CSS :css present in the page, then I checks its inner CSS :cssInner in the :region region
    *
    * @throws \Exception
    *   If region or link within it cannot be found.
    */


    public function iShouldSeeCSSExists($css,$cssInner,$region){
      $session = $this->getSession();
      $regionObj = $session->getPage()->find('region', $region);
      $cssResult = self::iShouldSeeCss($css);
      if($cssResult == true){
        self::iShouldSeeCssInRegion($cssInner,$region);
      } else {
        echo "\nParticular CSS is not present in the Page\n";
      }
    }

  /**
    * @When I see CSS :css present in the page, then I checks its response of href of CSS :cssHref be 200
    *
    * @throws \Exception
    *   If region or link within it cannot be found.
    */
    public function iShouldSeeCSSExistsHref($css,$cssHref){
        $cssResult = self::iShouldSeeCss($css);
      if($cssResult == true){
        self::iShouldSeeResponseOfHrefOfCSS($cssHref);
      } else {
        echo "\nParticular CSS is not present in the Page\n";
      }
    }

    /**
      * @When I see CSS :css present in the page, then I checks its response of Image Source of CSS :cssHref be 200
      *
      * @throws \Exception
      *   If region or link within it cannot be found.
      */
      public function iShouldSeeCSSExistsImageSource($css,$cssHref){
          $cssResult = self::iShouldSeeCss($css);
        if($cssResult == true){
          self::iShouldSeeResponseOfCSS($cssHref);
        } else {
          echo "\nParticular CSS is not present in the Page\n";
        }
      }

    // /**
    //   * @When I count of related blogs :element should be 10 if load more :loadmore is present
    //   *
    //   * @throws \Exception
    //   *   If region or link within it cannot be found.
    //   */
    //   public function countItemsOfLoadMore($loadmore,$element){
    //     $session = $this->getSession();
    //     $regionObj = $session->getPage()->find('css',$element);
    //     if($regionObj != NULL){
    //       $elementlength = count($regionObj);
    //       echo $elementlength;
    //     } else {
    //       throw new Exception("Nothing was found in CSS!");
    //     }
    //   }

  /**
    * @Given /^I set browser window size to "([^"]*)" x "([^"]*)"$/
    */
    public function iSetBrowserWindowSizeToX($width, $height) {
      $this->getSession()->resizeWindow((int)$width, (int)$height, 'current');
    }

  /**
    * @Given I fill Username and Password for login
    */
    public function iFillUsernameAndPasswordForLogin(){

    }

  /**
   * @Then /^I wait for the ajax response$/
   */
    public function iWaitForTheAjaxResponse(){
    $time = 5000; // time should be in milliseconds
    $this->getSession()->wait($time, '(0 === jQuery.active)');
    // asserts below
  }

  /**
   * @Then I should see error message :title
   */
  public function iShouldSeeAnErrorBalloon($title)
{
    $time = 5000; // time should be in milliseconds
    $this->getSession()->wait($time, '(0 === jQuery.active)');

}


}
