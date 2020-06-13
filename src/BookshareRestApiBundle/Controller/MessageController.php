<?php


namespace BookshareRestApiBundle\Controller;


use BookshareRestApiBundle\Service\Messages\MessageServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use FOS\RestBundle\Controller\Annotations\Route;

class MessageController extends Controller
{
    private $encoder;
    private $normalizer;
    private $messageService;

    public function __construct(MessageServiceInterface $messageService)
    {
        $this->encoder = new JsonEncoder();
        $this->normalizer = new ObjectNormalizer();
        $this->normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $this->messageService = $messageService;
    }

    /**
     * @Route("/private/send-message", methods={"POST"})
     * @param Request $request
     *
     * @return Response
     */
    public function sendMessage(Request $request) {
        $description = json_decode($request->getContent(), true)['description'];

        $this->messageService->createMessage($description);

        return new Response(null, Response::HTTP_CREATED);
    }
}