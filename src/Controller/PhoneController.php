<?php

namespace App\Controller;

use App\Entity\Phone;
use App\Repository\PhoneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;

/**
 * @Route("/api")
 */
class PhoneController extends AbstractController
{
    /**
     * Details of one phone.
     * 
     * @Route("/phones/{id}", name="show_phone", methods={"GET"})
     * @OA\Response(
     *     response=200,
     *     description="Return details for one phone",
     *     @Model(type=Phone::class, groups={"show"})
     * )
     * @OA\Tag(name="phones")
     */
    public function show(Phone $phone, PhoneRepository $phoneRepository, SerializerInterface $serializer)
    {
        $phone = $phoneRepository->find($phone->getId());
        $data = $serializer->serialize($phone, 'json', [
            'groups' => ['show']
        ]);
        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * List of phones.
     * 
     * @Route("/phones/{page<\d+>?1}", name="list_phone", methods={"GET"})
     * @OA\Parameter(
     *     name="page",
     *     in="query",
     *     description="Page",
     *     required=false,
     *     @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     *         response=200,
     *         description="Return an array of phones",
     *         @OA\JsonContent(ref="#/components/schemas/Phone")
     * )
     * @OA\Tag(name="phones")
     */
    public function index(Request $request, PhoneRepository $phoneRepository, SerializerInterface $serializer)
    {
        $page = $request->query->get('page');
        if(is_null($page) || $page < 1) {
            $page = 1;
        }
        $limit = 10;
        $phones = $phoneRepository->findAllPhones($page, $limit);
        $data = $serializer->serialize($phones, 'json', [
            'groups' => ['list']
        ]);
        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * Add new phone to the Database.
     * 
     * @Route("/phones", name="add_phone", methods={"POST"})
     * @OA\Response(
     *     response=200,
     *     description="Phone has been add to the database"
     * )
     * @OA\Response(
     *     response=401,
     *     description="Unauthorized"
     * )
     * @OA\RequestBody(
     *     request="Phone",
     *     description="Phone that needs to be added to the store",
     *     required=true,
     *     @OA\JsonContent(@OA\Schema(
     *         type="json"
     *     )),     
     * )
     * @OA\Tag(name="new")
     * @Security(name="Bearer")
     */
    public function new(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $phone = $serializer->deserialize($request->getContent(), Phone::class, 'json');
        $errors = $validator->validate($phone);
        if(count($errors)) {
            $errors = $serializer->serialize($errors, 'json');
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
        }
        $entityManager->persist($phone);
        $entityManager->flush();
        $data = [
            'status' => 201,
            'message' => 'Le téléphone a bien été ajouté'
        ];
        return new JsonResponse($data, 201);
    }

    /**
     * @Route("/phones/{id}", name="update_phone", methods={"PUT"})
     */
    public function update(Request $request, SerializerInterface $serializer, Phone $phone, ValidatorInterface $validator, EntityManagerInterface $entityManager)
    {
        $phoneUpdate = $entityManager->getRepository(Phone::class)->find($phone->getId());
        $data = json_decode($request->getContent());
        foreach ($data as $key => $value){
            if($key && !empty($value)) {
                $name = ucfirst($key);
                $setter = 'set'.$name;
                $phoneUpdate->$setter($value);
            }
        }
        $errors = $validator->validate($phoneUpdate);
        if(count($errors)) {
            $errors = $serializer->serialize($errors, 'json');
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
        }
        $entityManager->flush();
        $data = [
            'status' => 200,
            'message' => 'Le téléphone a bien été mis à jour'
        ];
        return new JsonResponse($data);
    }

     /**
     * @Route("/phones/{id}", name="delete_phone", methods={"DELETE"})
     */
    public function delete(Phone $phone, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($phone);
        $entityManager->flush();
        return new Response(null, 204);
    }
}
