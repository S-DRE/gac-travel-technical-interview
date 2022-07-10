<?php

// src/DataFixtures/ProductFixtures.php
namespace App\DataFixtures;

use App\Entity\Categories;
use App\Entity\Products;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 20; $i++) {
            $product = new Products();

            $productData = $this->fetchApi($i);

            $existeProducto = $manager->getRepository(Products::class)->findOneBy(['name' => $productData->title]);

            if ($existeProducto === null) {

                $product->setName($productData->title);
                $product->setStock(mt_rand(10, 100));
                $product->setCreatedAt(new DateTime());

                $category = $manager->getRepository(Categories::class)->findOneBy(['name' => $productData->category]); // <-- Unique index

                // dump($productData->category, $category);

                if ($category === null) {
                    $category = new Categories();
                    $category->setName($productData->category);
                    $category->setCreatedAt(new DateTime());
                    $manager->persist($category);
                    $manager->flush();
                }

                $product->setCategory($category);
                $manager->persist($product);
                dump("Producto nº " . $i . " añadido.");
            } else {
                dump("Producto nº " . $i . " ya existe, por lo que se omitirá.");
            }
        }

        $manager->flush();
    }

    public function fetchApi(int $iteration) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fakestoreapi.com/products/'. $iteration);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);

        return json_decode($res);
    }
}