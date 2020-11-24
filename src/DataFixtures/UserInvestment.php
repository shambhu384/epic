<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Investment;
use App\Entity\UserInvestment as EntityUserInvestment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserInvestment extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = $manager->getRepository(User::class)->findOneBy(['email' => 'test@epic.com']);
        $investment = $manager->getRepository(Investment::class)->findOneBy(['name' => 'Lic']);

        $userInvestment = new EntityUserInvestment();
        $userInvestment->setUser($user);
        $userInvestment->setInvestment($investment);
        $manager->persist($userInvestment);
        $manager->flush();
    }
}
