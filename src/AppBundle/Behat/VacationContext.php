<?php

namespace AppBundle\Behat;

use AppBundle\Entity\Employee;
use AppBundle\Entity\Job;
use AppBundle\Entity\Location;
use AppBundle\Entity\Vacation;
use Behat\Behat\Tester\Exception\PendingException;

class VacationContext extends BaseContext
{
    /**
     * @Given /^employee "([^"]*)" "([^"]*)" who joined "([^"]*)" years ago$/
     */
    public function employeeWhoJoinedYearsAgo($fname, $lname, $years)
    {
        $em = $this->get('em');

        $employee = new Employee();
        $now = new \DateTime();
        $yearsAgo = $now->modify('-' . $years . ' years');
        $employee->setBirthdate($now);
        $employee->setFirstname($fname);
        $employee->setLastname($lname);
        $employee->setJoinedAt($yearsAgo);

        $em->persist($employee);
        $em->flush();
    }

    /**
     * @Then /^I should see that "([^"]*)" "([^"]*)" has "([^"]*)" remaining vacation days$/
     */
    public function iShouldSeeThatHasRemainingVacationDays($fname, $lname, $days)
    {
        $fullname = $fname . ' ' . $lname;
        $this->notNull(
            $foundDays = $this->find('xpath', '//tr/td[contains(., "' . $fullname . '")]/../td[7]'),
            "Employee '$fullname' was not found"
        );
        $this->true(($actual = trim($foundDays->getHtml())) === $days, "Employee has $actual instead of $days vacation days remaining");
    }

    /**
     * @Given /^employee "([^"]*)" "([^"]*)" used "([^"]*)" vacation days$/
     */
    public function employeeUsedVacationDays($fname, $lname, $days)
    {
        $em = $this->get('em');
        $employee = $em->getRepository('AppBundle:Employee')->findOneBy(['firstname' => $fname, 'lastname' => $lname]);
        $vacation = new Vacation();
        $starts = $employee->getJoinedAt();
        $ends = clone $starts;
        $ends->modify('+' . $days. ' days');
        $vacation->setStartsAt($starts);
        $vacation->setEndsAt($ends);
        $vacation->setEmployee($employee);
        $employee->addVacation($vacation);
        $em->persist($employee);
        $em->flush();
    }
}
