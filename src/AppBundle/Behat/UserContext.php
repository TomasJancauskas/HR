<?php

namespace AppBundle\Behat;

use AppBundle\Entity\User;

class UserContext extends BaseContext
{
    /**
     * @BeforeScenario
     */
    function resetSecurityContext()
    {
        $this->get('security.context')->setToken(null);
    }

    /**
     * @Given /^(confirmed|unconfirmed) (user|admin) named "([^"]+)"$/
     */
    function userNamed($status, $type, $name)
    {
        $names = explode(' ', $name);
        list ($firstname, $lastname) = $names;

        $em = $this->get('em');
        $user = new User();
        if ('confirmed' === $status) {
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
        }
        $user->setEmail(strtolower(implode('.', $names)) . '@test.lt');
        $user->setRoles($type == 'user' ? ['ROLE_USER'] : ['ROLE_ADMIN']);

        if ('unconfirmed' === $status) {
            $user->setConfirmationToken(implode('-', array_map('strtolower', $names)) . '-token');
        } else {
            $encoder = $this->get('security.encoder_factory')->getEncoder($user);
            $user->setPassword($encoder->encodePassword('S3cretpassword', $user->getSalt()));
        }
        $em->persist($user);
        $em->flush();
        return $user;
    }

    /**
     * @Given /^I have signed up as "([^"]*)"$/
     */
    function iHaveSignedUpAs($email)
    {
        $this->visit('app_user_signup');
        $this->mink->fillField('Email', $email);
        $this->mink->pressButton('Signup');
    }

    /**


    /**
     * @Given /^I'm logged in as "([^"]*)"$/
     * @When /^I login as "([^"]*)" using password "([^"]*)"$/
     * @When /^I try to login as "([^"]*)" using password "([^"]*)"$/
     */
    function iTryToLoginAsUsingPassword($email, $password = 'S3cretpassword')
    {
        $this->visit('app_user_login');
        $this->mink->fillField("Username", $email);
        $this->mink->fillField("Password", $password);
        $this->mink->pressButton("Login");
    }
}
