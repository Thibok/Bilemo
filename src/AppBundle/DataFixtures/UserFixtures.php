<?php

/**
 * Load User Fixtures
 */

namespace AppBundle\DataFixtures;

use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * UserFixtures
 */
class UserFixtures extends Fixture
{
    /**
     * @var string
     */
    const MAIN_TEST_USER_REFERENCE = 'main-test-user-reference';
    
    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $bryanUser = new User('103947877496446', 'Bryan', 'Test', '');

        $manager->persist($bryanUser);
        $manager->flush();

        $this->addReference(self::MAIN_TEST_USER_REFERENCE, $bryanUser);
    }
}