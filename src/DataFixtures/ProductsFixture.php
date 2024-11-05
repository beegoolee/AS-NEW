<?php

namespace App\DataFixtures;

use App\Entity\CatalogSection;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;

class ProductsFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // добавляем разделы каталога
        for ($i = 0; $i < 10; $i++) {
            $section = new CatalogSection();
            $section->setName('Section ' . $i);
            $section->setSlug("section-" . $i);
            $section->setUrl("/catalog/section-" . $i . "/");

            $manager->persist($section);
        }
        $manager->flush();

        // Добавляем товары с привязкой к разделам
        $arSections = $manager->getRepository(CatalogSection::class)->findAll();
        for ($i = 0; $i < 2000; $i++) {
            $product = new Product();
            $parentSection = $arSections[array_rand($arSections)];
            $product->addParentSection($parentSection);

            $product->setName('Продукт  ' . $i);
            $sSlug = 'product_' . $i;
            $product->setSlug($sSlug);
            $product->setUrl( $parentSection->getUrl() . $sSlug . '/');
            $product->setImage("https://asevalar.ru/upload/iblock/a66/6qr9fio0ckmbin1h7f4vclnfiszb67yl_480_480.jpg");
            $product->setPrice(mt_rand(10, 100));
            $product->setRating(mt_rand(1, 5));
            $product->setProductId($i);

            $manager->persist($product);
        }

        $manager->flush();
    }
}