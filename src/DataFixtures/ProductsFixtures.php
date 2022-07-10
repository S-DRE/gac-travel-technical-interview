<?php

// src/DataFixtures/ProductsFixtures.php
namespace App\DataFixtures;

use App\Entity\Categories;
use App\Entity\Products;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ProductsFixtures extends Fixture
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function load(ObjectManager $manager)
    {
        $productsData = $this->fetchApi();

        foreach ($productsData as $clave => $productData) {
            $existeProducto = $manager->getRepository(Products::class)->findOneBy(['name' => $productData->title]);

            if ($existeProducto === null) {
                $product = new Products();
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
                dump("Producto nº " . $clave . " añadido.");
            } else {
                dump("Producto nº " . $clave . " ya existe, por lo que se omitirá.");
            }
        }

        $manager->flush();
    }


    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function fetchApi()
    {
        // cURL

        /*
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fakestoreapi.com/products/'. $iteration);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);
        */

        // HTTP Client Library Request
        $response = $this->client->request(
            'GET',
            'https://fakestoreapi.com/products'
        )->getContent();

        return json_decode($response);
    }
}