<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class MonApiController extends AbstractController
{
    /**
     * @Route("/mon/api", name="mon_api")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/MonApiController.php',
        ]);
    }

    /**
    * @Route("/articles/{id}", name="article_show")
    */
    public function showAction(Article $article)
    {
        $data = $this->get('serializer')->serialize($article, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
    * @Route("/articles", name="article_create")
    * @Method({"POST"})
    */
    public function createAction(Request $request)
    {
        $data = $request->getContent();
        $article = $this->get('serializer')->deserialize($data, 'App\Entity\Article', 'json');
        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();
        return new Response('', Response::HTTP_CREATED);
    }

    /**
    * @Route("/articles_list", name="article_list")
    * @Method({"GET"})
    */
    public function listAction()
    {
        $articles = $this->getDoctrine()->getRepository('App:Article')->findAll();
        $data = $this->get('serializer')->serialize($articles, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
