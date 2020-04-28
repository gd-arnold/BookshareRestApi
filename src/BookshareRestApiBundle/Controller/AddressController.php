<?php

namespace BookshareRestApiBundle\Controller;

use BookshareRestApiBundle\Service\Addresses\AddressServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class AddressController extends Controller
{
    private $addressService;
    private $encoder;
    private $normalizer;

    public function __construct(AddressServiceInterface $addressService)
    {
        $this->addressService = $addressService;
        $this->encoder = new JsonEncoder();
        $this->normalizer = new ObjectNormalizer();
        $this->normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
    }

    /**
     * @Route("/couriers", methods={"GET"})
     *
     * @return Response
     */
    public function getAllCourierServices() {

        $couriers = $this->addressService->getAllCourierServices();

        $this->normalizer->setIgnoredAttributes(['addresses']);
        
        $serializer = new Serializer(array($this->normalizer), array($this->encoder));
        $json = $serializer->serialize($couriers, 'json');

        return new Response($json,
            Response::HTTP_OK,
            array('content_type' => 'application/json'));
    }
}
