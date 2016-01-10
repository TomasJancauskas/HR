Feature: Calculate remaining vacation days

  Scenario: should award 28 vacation days per year
    Given confirmed user named "Test User"
    And employee "Harry" "Potter" who joined "1" years ago
    And I'm logged in as "test.user@test.lt"
    When I visit "employees" page
    Then I should see that "Harry" "Potter" has "28" remaining vacation days

  Scenario: should subtract vacation days correctly
    Given confirmed user named "Test User"
    And employee "Harry" "Potter" who joined "1" years ago
    And employee "Harry" "Potter" used "10" vacation days
    And I'm logged in as "test.user@test.lt"
    When I visit "employees" page
    Then I should see that "Harry" "Potter" has "18" remaining vacation days
