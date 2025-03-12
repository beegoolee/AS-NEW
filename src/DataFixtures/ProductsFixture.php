<?php

namespace App\DataFixtures;

use App\Entity\CatalogSection;
use App\Kernel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;
use App\Helpers\RandomImagesHelper;
use Faker\Factory;

class ProductsFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('ru_RU');

        // добавляем разделы каталога
        for ($i = 0; $i < 10; $i++) {
            $section = new CatalogSection();

            $sSectionName = $faker->name;
            $section->setName(current(explode(" ", $sSectionName)));

            $section->setSlug("section-" . $i);
            $section->setUrl("/catalog/section-" . $i . "/");

            $manager->persist($section);
        }
        $manager->flush();

//      $sGeneratedPicPath = RandomImagesHelper::getImageByPrompt("big realistic fluffy white cat on not cut watermelon");
        $_SERVER['DOCUMENT_ROOT'] = (new Kernel('dev', true))->getProjectDir();
        $arProductRandomPics = glob($_SERVER['DOCUMENT_ROOT'] . '/public/upload/*');

        // Добавляем товары с привязкой к разделам
        $arSections = $manager->getRepository(CatalogSection::class)->findAll();
        for ($i = 0; $i < 2000; $i++) {
            $product = new Product();
            $parentSection = $arSections[array_rand($arSections)];
            $product->addParentSection($parentSection);

            $sProductName = $faker->name;
            $product->setName(current(explode(" ", $sProductName)));

            $product->setDescription($sProductName);

            $sProductBarcode = $faker->ean8;
            $product->setBarcode($sProductBarcode);

            $sSlug = 'product_' . $i;
            $product->setSlug($sSlug);
            $product->setUrl($parentSection->getUrl() . $sSlug . '/');

            $product->setImage('http://localhost:8080' . str_replace($_SERVER['DOCUMENT_ROOT'] . '/public', '', $arProductRandomPics[array_rand($arProductRandomPics)]));
//          $product->setImage($sGeneratedPicPath);

            $product->setPrice(mt_rand(100, 1000));
            $product->setProductId($i);

            $manager->persist($product);
        }

        $manager->flush();
    }
}