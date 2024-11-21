Feature: Manage Courses in mod/icourse Plugin
  As an admin, user, or guest
  I want to interact with the icourse plugin page
  So that the system behaves according to my permissions

  Background:
    And the following "courses" exist:
      | fullname      | shortname | category | visible |
      | Course A      | CA       | 0        | 1       |
      | Course B     |  CB       | 0        | 0       |
      | Course C     |  CC       | 0        | 1       |
    And the following "users" exist:
      | username  | firstname | lastname | email              | role   |
      | student1  | Student   | One      | student1@example.com | student |
      | guestuser | Guest     | User     | guest@example.com   | guest  |
    And the following "activities" exist:
      | activity | name     | course |
      | icourse     | I Course | CA     |
    And the following "course enrolments" exist:
      | user      | course   |  role          |
      | student1  | CA | student        |
      | student1  | CC | student        |
      

    @javascript
  Scenario: Admin can view all courses and manage them
    Given I am logged in as "student1"
    And I am on "Course A" course homepage
    And I follow "I Course"
    And I pause
    Then I should see a table with the following columns:
      | ID    | Image | Name   | Date Created | Action |
    And I should see "Course A" in the table
    And I should see "Course B" in the table
    And I should see "Course C" in the table
    And I press "Create New Course"
    Then I should be redirected to the Moodle course creation page
    When I create a course with the name "New Course"
    Then I should be redirected back to "/mod/icourse/view.php"
    And I should see "New Course" in the table
    When I press "Update" next to "Course A"
    Then I should be redirected to the Moodle course update page
    When I press "Delete" next to "Course B"
    Then I should see "Hidden" in the "Action" column for "Course B"

  Scenario: User can only see enrolled courses
    Given I am logged in as "student1"
    When I navigate to "/mod/icourse/view.php"
    Then I should see a table with the following rows:
      | ID   | Name      | Date created | Action |
      | CA   | Course A  | ...          | ...    |
      | CC   | Course C  | ...          | ...    |
    And I should not see "Course B" in the table

  Scenario: Guest cannot access the page
    Given I am logged in as "guestuser"
    When I navigate to "/mod/icourse/view.php"
    Then I should see the error message "You cannot access this page"

  Scenario: Unauthenticated user cannot access the page
    Given I am not logged in
    When I navigate to "/mod/icourse/view.php"
    Then I should see the error message "You cannot access this page"
