@chrome @firefox @test2.m.wikipedia.org @vagrant
Feature: Generic special page features

  Background:
    Given I am using the mobile site
      And I am on the "Main Page" page

  @skip
  Scenario: Search from Watchlist
    Given I am logged into the mobile website
    When I click on "Watchlist" in the main navigation menu
      And I click the placeholder search box
    Then I should see the search overlay

  @en.m.wikipedia.beta.wmflabs.org @extension-geodata
  Scenario: Search from Nearby
    When I click on "Nearby" in the main navigation menu
      And I click the placeholder search box
    Then I should see the search overlay

  @en.m.wikipedia.beta.wmflabs.org
  Scenario: Search from Login
    When I click on "Log in" in the main navigation menu
      And I click the placeholder search box
    Then I should see the search overlay
