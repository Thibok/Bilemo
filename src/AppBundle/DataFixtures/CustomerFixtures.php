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
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * CustomerFixtures
 */
class CustomerFixtures extends Fixture implements DependentFixtureInterface, ContainerAwareInterface
{
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
            $mainUser = $this->getReference(UserFixtures::MAIN_TEST_USER_REFERENCE);
            $secondaryUser = $this->getReference(UserFixtures::SECONDARY_TEST_USER_REFERENCE);
        }

        if ($env == 'dev') {
            $mainUser = $this->getReference(UserFixtures::MAIN_DEMO_USER_REFERENCE);
            $secondaryUser = $this->getReference(UserFixtures::SECONDARY_DEMO_USER_REFERENCE);
        }

        $firstCustomer = new Customer;
        $secondCustomer = new Customer;
        $thirdCustomer = new Customer;
        $fourthCustomer = new Customer;
        $fifthCustomer = new Customer;
        $sixthCustomer = new Customer;
        $seventhCustomer = new Customer;
        $eighthCustomer = new Customer;
        $ninthCustomer = new Customer;
        $tenthCustomer = new Customer;
        $eleventhCustomer = new Customer;

        $firstCustomer->setEmail('jeantest@yahoo.com');
        $firstCustomer->setFirstName('Jean');
        $firstCustomer->setLastName('Test');
        $firstCustomer->setCity('Bordeaux');
        $firstCustomer->setCountry('France');
        $firstCustomer->setAddress('52 rue des mimosas');
        $firstCustomer->setUser($mainUser);

        $secondCustomer->setEmail('francoistest@orange.fr');
        $secondCustomer->setFirstName('Francois');
        $secondCustomer->setLastName('Test');
        $secondCustomer->setCity('Lille');
        $secondCustomer->setCountry('France');
        $secondCustomer->setAddress('78 rue des marguerite');
        $secondCustomer->setUser($secondaryUser);

        $thirdCustomer->setEmail('seb852@gmail.com');
        $thirdCustomer->setFirstName('Sebastien');
        $thirdCustomer->setLastName('Test');
        $thirdCustomer->setCity('Paris');
        $thirdCustomer->setCountry('France');
        $thirdCustomer->setAddress('2 impasse Jean Mermoz');
        $thirdCustomer->setUser($mainUser);

        $fourthCustomer->setEmail('fred356@hotmail.com');
        $fourthCustomer->setFirstName('Frederic');
        $fourthCustomer->setLastName('Test');
        $fourthCustomer->setCity('Bordeaux');
        $fourthCustomer->setCountry('France');
        $fourthCustomer->setAddress('40 rue des mimosas');
        $fourthCustomer->setUser($mainUser);

        $fifthCustomer->setEmail('odili789@yahoo.com');
        $fifthCustomer->setFirstName('Odile');
        $fifthCustomer->setLastName('Test');
        $fifthCustomer->setCity('Lille');
        $fifthCustomer->setCountry('France');
        $fifthCustomer->setAddress('20 rue des paquerette');
        $fifthCustomer->setUser($mainUser);

        $sixthCustomer->setEmail('jeanjean@gmail.com');
        $sixthCustomer->setFirstName('Jean');
        $sixthCustomer->setLastName('Test');
        $sixthCustomer->setCity('Montpellier');
        $sixthCustomer->setCountry('France');
        $sixthCustomer->setAddress('12 rue de la gare');
        $sixthCustomer->setUser($mainUser);

        $seventhCustomer->setEmail('alex563@hotmail.com');
        $seventhCustomer->setFirstName('Alexandre');
        $seventhCustomer->setLastName('Test');
        $seventhCustomer->setCity('Bordeaux');
        $seventhCustomer->setCountry('France');
        $seventhCustomer->setAddress('52 rue des mimosas');
        $seventhCustomer->setUser($mainUser);

        $eighthCustomer->setEmail('gerard85@orange.com');
        $eighthCustomer->setFirstName('Gerard');
        $eighthCustomer->setLastName('Test');
        $eighthCustomer->setCity('St-Brieuc');
        $eighthCustomer->setCountry('France');
        $eighthCustomer->setAddress('8 rue de la falaise');
        $eighthCustomer->setUser($mainUser);

        $ninthCustomer->setEmail('alain520@yahoo.com');
        $ninthCustomer->setFirstName('Alain');
        $ninthCustomer->setLastName('Test');
        $ninthCustomer->setCity('Toulouse');
        $ninthCustomer->setCountry('France');
        $ninthCustomer->setAddress('42 bd du grand test');
        $ninthCustomer->setUser($mainUser);

        $tenthCustomer->setEmail('myriam523@gmail.com');
        $tenthCustomer->setFirstName('Myriam');
        $tenthCustomer->setLastName('Test');
        $tenthCustomer->setCity('Lyon');
        $tenthCustomer->setCountry('France');
        $tenthCustomer->setAddress('20 avenue des pupilles');
        $tenthCustomer->setUser($mainUser);

        $eleventhCustomer->setEmail('caro231@gmail.com');
        $eleventhCustomer->setFirstName('Caroline');
        $eleventhCustomer->setLastName('Test');
        $eleventhCustomer->setCity('Nice');
        $eleventhCustomer->setCountry('France');
        $eleventhCustomer->setAddress('89 rue de la cote');
        $eleventhCustomer->setUser($mainUser);

        $manager->persist($firstCustomer);
        $manager->persist($secondCustomer);
        $manager->persist($thirdCustomer);
        $manager->persist($fourthCustomer);
        $manager->persist($fifthCustomer);
        $manager->persist($sixthCustomer);
        $manager->persist($seventhCustomer);
        $manager->persist($eighthCustomer);
        $manager->persist($ninthCustomer);
        $manager->persist($tenthCustomer);
        $manager->persist($eleventhCustomer);

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

    /**
     * @inheritDoc
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}