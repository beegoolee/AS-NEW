<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;

class ProductsFixture extends Fixture{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $product = new Product();
            $product->setName('Продукт  '.$i);
            $product->setSlug('product_'.$i);
            $product->setImage("https://asevalar.ru/upload/iblock/a66/6qr9fio0ckmbin1h7f4vclnfiszb67yl_480_480.jpg");
            $product->setPrice(mt_rand(10, 100));
            $product->setRating(mt_rand(1, 5));
            $product->setProductId($i);

            $manager->persist($product);
        }

        $manager->flush();
    }
}