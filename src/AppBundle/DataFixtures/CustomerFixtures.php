<?php

/**
 * Load Customer Fixtures
 */

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Customer;
use AppBundle\DataFixtures\UserFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * CustomerFixtures
 */
class CustomerFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $firstCustomer = new Customer;

        $secondCustomer = new Customer;

        $firstCustomer->setEmail('jeantest@yahoo.com');
        $firstCustomer->setFirstName('Jean');
        $firstCustomer->setLastName('Test');
        $firstCustomer->setCity('Bordeaux');
        $firstCustomer->setCountry('France');
        $firstCustomer->setAddress('52 rue des mimosas');
        $firstCustomer->setUser($this->getReference(UserFixtures::MAIN_TEST_USER_REFERENCE));

        $secondCustomer->setEmail('francoistest@orange.fr');
        $secondCustomer->setFirstName('Francois');
        $secondCustomer->setLastName('Test');
        $secondCustomer->setCity('Lille');
        $secondCustomer->setCountry('France');
        $secondCustomer->setAddress('78 rue des marguerite');
        $secondCustomer->setUser($this->getReference(UserFixtures::SECONDARY_TEST_USER_REFERENCE));

        $manager->persist($firstCustomer);
        $manager->persist($secondCustomer);

        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
}