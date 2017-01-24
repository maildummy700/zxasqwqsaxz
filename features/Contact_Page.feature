Feature: Automation for Contact  page to check various static things to reduce manual effort, We going to automate resource block
        all its CSS alignments and response of images and hrefs.

  @blackbox @1
  Scenario: Redirection from homepage to Contact page.
    Given I am on "/"
    Then I follow "Contact" in the "secondary_orange_menu_bar" region
    Then print current URL
    Then the response status code should be 200

  @blackbox @2
  Scenario: Write to us form.
    Given I am on "/"
    Then I follow "Contact" in the "secondary_orange_menu_bar" region
    Then print current URL
    Then the response status code should be 200
    Then I should see CSS ".page-wrap" in the "page_class" region
    And I should see CSS ".sidebar_first" in the "contact_page_class" region


    Then I should see CSS "#block-sitewidecontactform-2" in the "contact_page_form" region
    #And I should see the heading "Write to us" in the "contact_page_form" region
    And I should see CSS "#contact-message-feedback-form" in the "contact_page_form" region



  @blackbox @3
  Scenario: Main Content, address of main content CSS and id's checkings.
    Given I am on "/"
    Then I follow "Contact" in the "secondary_orange_menu_bar" region
    Then print current URL
    Then the response status code should be 200
    And I should see CSS "#main-wrapper" in the "contact_page_class" region
    And I should see the heading "Locate us" in the "contact_page_main" region

    And I should see CSS ".India" in the "contact_page_main" region
    And I should see CSS ".America" in the "contact_page_main" region
    And I should see CSS ".South.East.Asia" in the "contact_page_main" region


  @javascript @4
  Scenario: India Address CSS checking
    Given I am on "/contact"
    Then I wait for 1 seconds
    Then I set browser window size to "1024" x "768"
    #Then I follow "Contact" in the "secondary_orange_menu_bar" region
    Then print current URL
    #Then the response status code should be 200
    Then I wait for 2 seconds

    #Delhi Address
    Then I should see CSS "ul>li:nth-child(1).tab-active" in the "contact_page_india_address_active" region
    And I should see CSS "ul>li:nth-child(1)#delhi.map-active" in the "contact_page_india_address_active_icon" region
    And I should see CSS ".location" in the "contact_page_india_address" region
    And I should see CSS ".col-4" in the "contact_page_india_address_location" region
    And I should see CSS ".side-tabs" in the "contact_page_india_address_location" region

    Then I should see the response status of image source of CSS ".India>.location>div>img" be 200

    And I should see CSS ".tab-links" in the "contact_page_india_address_location_right" region
    And I should see CSS ".tab-content" in the "contact_page_india_address_location_right" region

    #Then I should see the response status of href of CSS "#delhi>div>ul>li>a" be 200

    #Goa Address
    Then I click on CSS element ".India>div>.col-8>div>ul>li:nth-child(2)>a"
    And I wait for 1 seconds

    And I should see CSS "ul>li:nth-child(2).tab-active" in the "contact_page_india_address_active" region
    And I should see CSS "ul>li#goa.map-active" in the "contact_page_india_address_active_icon" region

    And I should see CSS ".location" in the "contact_page_india_address" region
    And I should see CSS ".col-4" in the "contact_page_india_address_location" region
    And I should see CSS ".side-tabs" in the "contact_page_india_address_location" region

    Then I should see the response status of image source of CSS ".India>.location>div>img" be 200

    And I should see CSS ".tab-links" in the "contact_page_india_address_location_right" region
    And I should see CSS ".tab-content" in the "contact_page_india_address_location_right" region

    #Then I should see the response status of href of CSS "#delhi>div>ul>li>a" be 200

    #Banglore Address
    Then I click on CSS element ".India>div>.col-8>div>ul>li:nth-child(3)>a"
    And I wait for 1 seconds

    And I should see CSS "ul>li:nth-child(3).tab-active" in the "contact_page_india_address_active" region
    And I should see CSS "ul>li#bengaluru.map-active" in the "contact_page_india_address_active_icon" region

    And I should see CSS ".location" in the "contact_page_india_address" region
    And I should see CSS ".col-4" in the "contact_page_india_address_location" region
    And I should see CSS ".side-tabs" in the "contact_page_india_address_location" region

    Then I should see the response status of image source of CSS ".India>.location>div>img" be 200

    And I should see CSS ".tab-links" in the "contact_page_india_address_location_right" region
    And I should see CSS ".tab-content" in the "contact_page_india_address_location_right" region

    #Then I should see the response status of href of CSS "#delhi>div>ul>li>a" be 200


  @javascript @5
  Scenario: America Address CSS checking
    Given I am on "/contact"
    Then I wait for 1 seconds
    Then I set browser window size to "1024" x "768"
    #Then I follow "Contact" in the "secondary_orange_menu_bar" region
    Then print current URL
    Then I wait for 2 seconds

    #california
    Then I should see CSS "ul>li:nth-child(1).tab-active" in the "contact_page_america_address_active" region
    And I should see CSS "ul>li:nth-child(1)#california.map-active" in the "contact_page_america_address_active_icon" region
    And I should see CSS ".location" in the "contact_page_america_address" region
    And I should see CSS ".col-4" in the "contact_page_america_address_location" region
    And I should see CSS ".side-tabs" in the "contact_page_america_address_location" region

    Then I should see the response status of image source of CSS ".America>.location>div>img" be 200

    And I should see CSS ".tab-links" in the "contact_page_america_address_location" region
    And I should see CSS ".tab-content" in the "contact_page_america_address_location_right" region

    #Then I should see the response status of href of CSS "#california>div>ul>li>a" be 200

  @javascript @6
  Scenario: South East Asia Address CSS checking
    Given I am on "/contact"
    Then I wait for 1 seconds
    Then I set browser window size to "1024" x "768"
    #Then I follow "Contact" in the "secondary_orange_menu_bar" region
    Then print current URL
    Then I wait for 2 seconds

    #Manila
    #Then I should see CSS "ul>li:nth-child(1).tab-active" in the "contact_page_south_east_asia_address_active" region
    And I should see CSS "ul>li:nth-child(1)#manila.map-active" in the "contact_page_south_east_asia_ddress_active_icon" region
    And I should see CSS ".location" in the "contact_page_south_east_asia_address" region
    And I should see CSS ".col-4" in the "contact_page_south_east_asia_address_location" region
    And I should see CSS ".side-tabs" in the "contact_page_south_east_asia_address_location" region

    Then I should see the response status of image source of CSS ".South>.location>div>img" be 200

    And I should see CSS ".tab-links" in the "contact_page_south_east_asia_address_location_right" region
    And I should see CSS ".tab-content" in the "contact_page_south_east_asia_address_location_right" region

    #Then I should see the response status of href of CSS "#manila>div>ul>li>a" be 200

    #Sydney
    Then I click on CSS element ".South>div>.col-8>div>ul>li:nth-child(2)>a"
    And I wait for 1 seconds
    Then I should see CSS "ul>li:nth-child(2).tab-active" in the "contact_page_south_east_asia_address_active" region
    And I should see CSS "ul>li:nth-child(2)#sydney.map-active" in the "contact_page_south_east_asia_ddress_active_icon" region
    And I should see CSS ".location" in the "contact_page_south_east_asia_address" region
    And I should see CSS ".col-4" in the "contact_page_south_east_asia_address_location" region
    And I should see CSS ".side-tabs" in the "contact_page_south_east_asia_address_location" region

    Then I should see the response status of image source of CSS ".South>.location>div>img" be 200

    And I should see CSS ".tab-links" in the "contact_page_south_east_asia_address_location_right" region
    And I should see CSS ".tab-content" in the "contact_page_south_east_asia_address_location_right" region

    #Then I should see the response status of href of CSS "#sydney>div>ul>li>a" be 200

    #Singapore
    Then I click on CSS element ".South>div>.col-8>div>ul>li:nth-child(3)>a"
    And I wait for 1 seconds
    Then I should see CSS "ul>li:nth-child(3).tab-active" in the "contact_page_south_east_asia_address_active" region
    And I should see CSS "ul>li:nth-child(3)#singapore.map-active" in the "contact_page_south_east_asia_ddress_active_icon" region
    And I should see CSS ".location" in the "contact_page_south_east_asia_address" region
    And I should see CSS ".col-4" in the "contact_page_south_east_asia_address_location" region
    And I should see CSS ".side-tabs" in the "contact_page_south_east_asia_address_location" region

    Then I should see the response status of image source of CSS ".South>.location>div>img" be 200

    And I should see CSS ".tab-links" in the "contact_page_south_east_asia_address_location_right" region
    And I should see CSS ".tab-content" in the "contact_page_south_east_asia_address_location_right" region

    #Then I should see the response status of href of CSS "#singapore>div>ul>li>a" be 200
