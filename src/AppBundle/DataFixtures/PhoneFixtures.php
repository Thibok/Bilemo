<?php

/**
 * Load Phone Fixtures
 */

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Phone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * PhoneFixtures
 */
class PhoneFixtures extends Fixture
{
    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $firstPhone = new Phone;
        $secondPhone = new Phone;
        $thirdPhone = new Phone;
        $fourthPhone = new Phone;
        $fifthPhone = new Phone;
        $sixthPhone = new Phone;
        $seventhPhone = new Phone;
        $eighthPhone = new Phone;
        $ninthPhone = new Phone;
        $tenthPhone = new Phone;

        $firstPhone->setModel('IPhone XR');
        $secondPhone->setModel('P Smart');
        $thirdPhone->setModel('10 Lite');
        $fourthPhone->setModel('Pocophone');
        $fifthPhone->setModel('Galaxy S10 Plus');
        $sixthPhone->setModel('Lumia 950');
        $seventhPhone->setModel('Xperia 10 Plus');
        $eighthPhone->setModel('View2');
        $ninthPhone->setModel('Zenfone');
        $tenthPhone->setModel('G7');

        $firstPhone->setMemory(64);
        $secondPhone->setMemory(64);
        $thirdPhone->setMemory(64);
        $fourthPhone->setMemory(64);
        $fifthPhone->setMemory(128);
        $sixthPhone->setMemory(64);
        $seventhPhone->setMemory(64);
        $eighthPhone->setMemory(64);
        $ninthPhone->setMemory(64);
        $tenthPhone->setMemory(64);

        $firstPhone->setColor('Black');
        $secondPhone->setColor('Blue');
        $thirdPhone->setColor('Blue');
        $fourthPhone->setColor('Black');
        $fifthPhone->setColor('Black');
        $sixthPhone->setColor('Black');
        $seventhPhone->setColor('Black');
        $eighthPhone->setColor('Gold');
        $ninthPhone->setColor('White');
        $tenthPhone->setColor('Red');

        $firstPhone->setBrand('Apple');
        $secondPhone->setBrand('Huawei');
        $thirdPhone->setBrand('Honor');
        $fourthPhone->setBrand('Xiaomi');
        $fifthPhone->setBrand('Samsung');
        $sixthPhone->setBrand('Microsoft');
        $seventhPhone->setBrand('Sony');
        $eighthPhone->setBrand('Wiko');
        $ninthPhone->setBrand('Asus');
        $tenthPhone->setBrand('LG');

        $firstPhone->setPrice(800);
        $secondPhone->setPrice(192.20);
        $thirdPhone->setPrice(199);
        $fourthPhone->setPrice(287.90);
        $fifthPhone->setPrice(999.80);
        $sixthPhone->setPrice(229.50);
        $seventhPhone->setPrice(359.40);
        $eighthPhone->setPrice(158.90);
        $ninthPhone->setPrice(294.90);
        $tenthPhone->setPrice(350);

        $firstPhone->setDescription('Apple make the best phone !');
        $secondPhone->setDescription('Very smart !');
        $thirdPhone->setDescription('Lite smartphone');
        $fourthPhone->setDescription('A dark pocophone !');
        $fifthPhone->setDescription('Go to galaxy !');
        $sixthPhone->setDescription('Get the Lumia !');
        $seventhPhone->setDescription('Best Sony phone !');
        $eighthPhone->setDescription('Golden Wiko');
        $ninthPhone->setDescription('Asus power');
        $tenthPhone->setDescription('The new G7 !');

        $manager->persist($firstPhone);
        $manager->persist($secondPhone);
        $manager->persist($thirdPhone);
        $manager->persist($fourthPhone);
        $manager->persist($fifthPhone);
        $manager->persist($sixthPhone);
        $manager->persist($seventhPhone);
        $manager->persist($eighthPhone);
        $manager->persist($ninthPhone);
        $manager->persist($tenthPhone);

        $manager->flush();
    }
}