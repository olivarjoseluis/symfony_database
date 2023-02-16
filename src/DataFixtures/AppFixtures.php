<?php

namespace App\DataFixtures;

use App\Entity\Metadata;
use App\Entity\Product;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product = new Product();
        $product->setName('Test product');
        $product->setSummary('Summary product');

        $metadata = new Metadata();
        $metadata->setCode(rand(100, 200));
        $metadata->setContent('Oficcial content');
        $manager->persist($metadata);
        
        $manager->persist($product);
        
        $product->setMetadata($metadata);

        $manager->flush();
    }
}
