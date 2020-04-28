<?php

namespace BookshareRestApiBundle\Controller;

use BookshareRestApiBundle\Service\Addresses\AddressServiceInterface;
use BookshareRestApiBundle\Service\Cities\CityServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class AddressController extends Controller
{
    private $addressService;
    private $cityService;
    private $encoder;
    private $normalizer;

    public function __construct(
        AddressServiceInterface $addressService,
        CityServiceInterface $cityService
    )
    {
        $this->addressService = $addressService;
        $this->cityService = $cityService;
        $this->encoder = new JsonEncoder();
        $this->normalizer = new ObjectNormalizer();
        $this->normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
    }

    /**
     * @Route("/private/couriers", methods={"GET"})
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

    /**
     * @Route("/private/cities-by-courier", methods={"POST"})
     * @param Request $request
     *
     * @return Response
     */
    public function getAllCitiesByCourierServices(Request $request) {

        $id = intval(json_decode($request->getContent(), true)['id']);
        $courierService = $this->addressService->courierServiceById($id);

        $cities = $this->addressService->getAllCitiesByCourierService($courierService);

        $this->normalizer->setIgnoredAttributes(['addresses', 'users', 'courierService', 'address', '__initializer__', '__cloner__', '__isInitialized__']);

        $serializer = new Serializer(array($this->normalizer), array($this->encoder));
        $json = $serializer->serialize($cities, 'json');

        return new Response($json,
            Response::HTTP_OK,
            array('content_type' => 'application/json'));
    }

    /**
     * @Route("/private/addresses-by-city", methods={"POST"})
     * @param Request $request
     *
     * @return Response
     */
    public function getAllAddressesByCityAndCourier(Request $request) {

        $cityId = intval(json_decode($request->getContent(), true)['cityId']);
        $courierId = intval(json_decode($request->getContent(), true)['courierId']);

        $city = $this->cityService->cityById($cityId);
        $courier = $this->addressService->courierServiceById($courierId);

        $addresses = $this->addressService->getAllAddressesByCityAndCourier($city, $courier);

        $this->normalizer->setIgnoredAttributes(['courierService', 'city', 'users']);

        $serializer = new Serializer(array($this->normalizer), array($this->encoder));
        $json = $serializer->serialize($addresses, 'json');

        return new Response($json,
            Response::HTTP_OK,
            array('content_type' => 'application/json'));
    }
}
