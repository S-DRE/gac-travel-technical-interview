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

class CategoriasFixtures extends Fixture
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client) {
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
        $categoriesData = $this->fetchApi();

        foreach ($categoriesData as $clave => $categoryData) {

            $existeCategoria = $manager->getRepository(Products::class)->findOneBy(['name' => $categoryData]);

            if ($existeCategoria === null) {
                $categoria = new Categories();
                $categoria->setName($categoryData);
                $categoria->setCreatedAt(new DateTime());
                $manager->persist($categoria);
                dump("Categoría nº " . $clave . " añadida.");
            } else {
                dump("Categoría nº " . $clave . " ya existe, por lo que se omitirá.");
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
    public function fetchApi() {
        // HTTP Client Library Request
        $response = $this->client->request(
            'GET',
            'https://fakestoreapi.com/products/categories'
        )->getContent();

        return json_decode($response);
    }
}