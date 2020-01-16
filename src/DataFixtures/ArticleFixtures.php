<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return array(
            UserFixtures::class,
            CategoryFixtures::class
        );
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for($i=1; $i<=8; $i++){
            $article = new Article();
            $article->setTitle($faker->word());
            $article->setContent($faker->paragraphs(4, true));
            $article->setCategory($this->getReference('CAT'.mt_rand(1, 5)));
            $article->setAuthor($this->getReference('USER'.mt_rand(0, 1)));

            $manager->persist($article);
            $this->addReference('ART'.$i, $article);
        }
        $manager->flush();
    }
}
