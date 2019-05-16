<?php

/**
 * Load User Fixtures
 */

namespace AppBundle\DataFixtures;

use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * UserFixtures
 */
class UserFixtures extends Fixture implements ContainerAwareInterface
{
    /**
     * @var string
     */
    const MAIN_TEST_USER_REFERENCE = 'main-test-user-reference';

    /**
     * @var string
     */
    const SECONDARY_TEST_USER_REFERENCE = 'secondary-test-user-reference';

    /**
     * @var string
     */
    const MAIN_DEMO_USER_REFERENCE = 'main-demo-user-reference';

    /**
     * @var string
     */
    const SECONDARY_DEMO_USER_REFERENCE = 'secondary-demo-user-reference';

    /**
     * @var ContainerInterface
     * @access private
     */
    private $container;
    
    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $env = $this->container->get('kernel')->getEnvironment();

        if ($env == 'test') {
            $bryanUser = new User('103947877496446', 'Bryan', 'Test', '');
            $pierreUser = new User('102799387618180', 'Pierre', 'Test', '');

            $manager->persist($bryanUser);
            $manager->persist($pierreUser);
        }

        if ($env == 'dev') {
            $mainUserDemo = new User('117342616129686', 'User', 'Demo', '');
            $secondaryUserDemo = new User('100036886091287', 'SecondaryUser', 'Demo', '');

            $manager->persist($mainUserDemo);
            $manager->persist($secondaryUserDemo);
        }

        $manager->flush();

        if ($env == 'test') {
            $this->addReference(self::MAIN_TEST_USER_REFERENCE, $bryanUser);
            $this->addReference(self::SECONDARY_TEST_USER_REFERENCE, $pierreUser);
        }

        if ($env == 'dev') {
            $this->addReference(self::MAIN_DEMO_USER_REFERENCE, $mainUserDemo);
            $this->addReference(self::SECONDARY_DEMO_USER_REFERENCE, $secondaryUserDemo);
        }
    }

    /**
     * @inheritDoc
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}