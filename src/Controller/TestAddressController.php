<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Address;

class TestAddressController extends AbstractController
{

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @Route("/test/address", methods={"POST", "GET"})
     */
    public function postAddress(Request $request): Response
    {
        $a = $this->serializer->deserialize($request->getContent(), Address::class, 'json');

        return new Response($this->serializer->serialize($a, 'xml'));
    }
}
