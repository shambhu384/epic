<?php

namespace App\DataFixtures;

use App\Entity\Section;
use App\Entity\Investment as InvestmentEntity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Investment extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $investmentEntity = new InvestmentEntity();
        $investmentEntity->setSummary('Life Insurance Corporation of India is an Indian state-owned insurance group and investment corporation owned by the Government of India.');
        $investmentEntity->setName('Lic');
        $investmentEntity->setCreatedAt(new \DateTime('now'));
        $manager->persist($investmentEntity);


        $section = new Section();
        $section->setName('80D');
        $section->addInvestment($investmentEntity);
        $section->setSummary('Every individual or HUF can claim a deduction under Section 80D for their medical insurance which is taken from their total income in any given year.');
        $manager->persist($section);

        $investmentEntity = new InvestmentEntity();
        $investmentEntity->setName('Permium Life cover');
        $investmentEntity->setSummary('Optional 34 Critical Illness Cover which cover breast & cervical cancer. Accident Death Benefit. Tax Benefits u/s 80C & 80D. Claims Settlement Ratio 98.6%. *T&C. 4 Term Plan Option. 30 Day Return Policy. Covers All forms of Death. High Cover at Low Rate.');
        $investmentEntity->setCreatedAt(new \DateTime('now'));
        $manager->persist($investmentEntity);


        $section = new Section();
        $section->setName('80C');
        $section->setSummary('Among the various tax-saving options, most individuals prefer to claim tax deduction under Section 80C of the Income Tax Act, 1961. Section 80C allows individuals and HUFs to claim tax deduction of up to Rs. 1,50,000 from their gross total income for certain investments and payments.');
        $section->addInvestment($investmentEntity);
        $manager->persist($section);



        $manager->flush();
    }
}
