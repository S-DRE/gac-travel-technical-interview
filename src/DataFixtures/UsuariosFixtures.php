<?php

// src/DataFixtures/ProductsFixtures.php
namespace App\DataFixtures;

use App\Entity\Categories;
use App\Entity\Products;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UsuariosFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;
    private HttpClientInterface $client;

    public function __construct(UserPasswordHasherInterface $hasher, HttpClientInterface $client) {
        $this->hasher = $hasher;
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
        $usersData = $this->fetchApi();

        foreach ($usersData as $clave => $userData) {
            $existeUsuario = $manager->getRepository(Products::class)->findOneBy(['name' => $userData->username]);

            if ($existeUsuario === null) {
                $usuario = new User();
                $usuario->setUsername($userData->username);
                $usuario->setPassword($this->hasher->hashPassword($usuario, $userData->password));
                $usuario->setRoles(['ROLE_ADMIN']); // <-- Duda, si solo hay uno, como comprobamos que no pueda acceder? (He creado un usuario con un ROLE_USER puesto 'a mano' para realizar las pruebas)
                $usuario->setIsVerified(1); // <-- Duda, que valor debería tener por defecto?
                $usuario->setCreatedAt(new DateTime());
                $manager->persist($usuario);
                dump("Usuario nº " . $clave . " añadido.");
            } else {
                dump("Usuario nº " . $clave . " ya existe, por lo que se omitirá.");
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
        // cURL

        /*
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fakestoreapi.com/users/'. $iteration);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);
        */

        // HTTP Client Library Request
        $response = $this->client->request(
            'GET',
            'https://fakestoreapi.com/users'
        )->getContent();

        return json_decode($response);
    }
}