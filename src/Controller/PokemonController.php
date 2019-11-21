<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use App\Helper\ApiHelper;
use App\Repository\PokemonRepository;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Pokemon;

class PokemonController extends AbstractController
{

    private function addPokemons($pokemon) {
        $addPokemon = new Pokemon();
        $addPokemon->setName($pokemon['name'])
            ->setUrl($pokemon['url']);
        $em = $this->getDoctrine()->getManager();
        $em->persist($addPokemon);
        $em->flush();
    }

    private function fetchPokemons($url) {
        $client = HttpClient::create();
        $response = $client->request('GET', $url);
        $content = $response->getContent();
        $result = json_decode($content, true);
        $r = array_map(array($this, 'addPokemons'), $result["results"]);
        if($result["next"]) {
            $this->fetchPokemons($result["next"]);
        } else return;
    }

    /**
     * Route(/"pokemon", name="pokemon")
     */
    public function allPokemon() {
        $URL_API_POKEMON = 'https://pokeapi.co/api/v2/pokemon';
        $response = $this->fetchPokemons($URL_API_POKEMON);
        return new Response($response);
    }
}