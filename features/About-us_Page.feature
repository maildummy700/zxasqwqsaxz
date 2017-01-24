Feature: Automation for PAbout Us Page to reduce manual effort of manual testing, here we will going to automate validation of CSS, nested CSS, response status of hrefs and sources of images.
  @blackbox @1
  Scenario: Redirection from homepage to About-us page.
    Given I am on "/"
    Then I follow "About" in the "secondary_orange_menu_bar" region
    Then print current URL
    Then the response status code should be 200

  @blackbox @2
  Scenario: Resource block
    Given I am on "/"
    Then I follow "About" in the "secondary_orange_menu_bar" region
    Then print current URL

    Then I should see CSS "#block-mainpagecontent" in the "page_class" region
    Then I should see CSS ".resource-count-view>div>div>div:nth-child(1)" in the "about_us_page_resource_block" region
    Then I should see CSS ".resource-count-view>div>div>div:nth-child(2)" in the "about_us_page_resource_block" region
    Then I should see CSS ".row>.col-3:nth-child(1)" in the "about_us_page_resource_block_row" region
    Then I should see CSS ".row>.col-3:nth-child(2)" in the "about_us_page_resource_block_row" region
    Then I should see CSS ".row>.col-3:nth-child(3)" in the "about_us_page_resource_block_row" region
    Then I should see CSS ".row>.col-3:nth-child(4)" in the "about_us_page_resource_block_row" region


  @blackbox @3
  Scenario: Resource block each column
    Given I am on "/"
    #Then I follow "About" in the "secondary_orange_menu_bar" region
    Then print current URL

    Then I should see CSS ".main-circle" in the "about_us_page_resource_block_column" region
    Then I should see CSS ".name" in the "about_us_page_resource_block_column" region
    Then I should see CSS ".line" in the "about_us_page_resource_block_column" region
    Then I should see CSS ".grey-circle" in the "about_us_page_resource_block_column" region
    Then I should see CSS ".count" in the "about_us_page_resource_block_column" region


  @blackbox @4
  Scenario: About Block row below resource blocks
    Given I am on "/"
    Then I follow "About" in the "secondary_orange_menu_bar" region
    Then print current URL

    And I should see CSS "#block-mainpagecontent" in the "page_class" region
    Then I should see the text "About Us" in the "about_us_page_About_Us_block" region

    Then I should see CSS ".node__content>div>div>div:nth-child(1)" in the "about_us_page_About_Us_block" region
    Then I should see CSS ".node__content>div>div>div:nth-child(2)" in the "about_us_page_About_Us_block" region
    Then I should see CSS ".node__content>div>div>div:nth-child(3)" in the "about_us_page_About_Us_block" region
    Then I should see CSS ".node__content>div>div>div:nth-child(4)" in the "about_us_page_About_Us_block" region
    Then I should see CSS ".node__content>div>div>div:nth-child(5)" in the "about_us_page_About_Us_block" region

    And I should see CSS ".about-title" in the "about_us_page_About_Us_block_1" region
    And I should see CSS ".about-content" in the "about_us_page_About_Us_block_1" region
