<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\ProductSlider;
use App\Entity\SliderItem;
use App\Entity\Slider;
use App\Repository\ProductRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SlidersFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // создаём слайдер(ы)
        $faker = Factory::create();
        $arSliderCodes = [
            'mainpageTop'
        ];

        $arSliders = [];
        foreach ($arSliderCodes as $sSliderCode) {
            $slider = new Slider();
            $slider->setCode($sSliderCode);
            $sSliderTitle = $faker->word;
            $slider->setTitle($sSliderTitle);

            $manager->persist($slider);
            $arSliders[] = $slider;
        }

        $manager->flush();

        // добавляем слайды
        for ($i = 0; $i < 5; $i++) {
            $sliderItem = new SliderItem();

            $sliderItem->setLink('/');
            $sliderItem->setSlider($arSliders[array_rand($arSliders)]);
            $sliderItem->setImage("https://asevalar.ru/upload/iblock/102/w235dba3t0e1lcleafaa7y55526fs7ly_0_320.jpg");

            $manager->persist($sliderItem);
        }

        $arProductSliderCodes = [
            'hotDiscounts',
            'populars'
        ];

        $productsRepo = $manager->getRepository(Product::class);
        $productsQuery = $productsRepo->createQueryBuilder('products')->getQuery();
        $paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($productsQuery);
        $productsQuery = $paginator->getQuery()->setFirstResult(15)->setMaxResults(15);
        $arProducts = $productsQuery->getResult();

        foreach ($arProductSliderCodes as $sProductSliderCode) {
            $productSliderItem = new ProductSlider();
            $productSliderItem->setCode($sProductSliderCode);
            $productSliderItem->setTitle($faker->word);
            foreach ($arProducts as $product) {
                $productSliderItem->addSlide($product);
            }

            $manager->persist($productSliderItem);
        }
        $manager->flush();
    }
}