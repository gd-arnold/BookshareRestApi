<?php


namespace BookshareRestApiBundle\Controller;


use BookshareRestApiBundle\Entity\SuggestedBook;
use BookshareRestApiBundle\Service\Suggestions\SuggestionServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use FOS\RestBundle\Controller\Annotations\Route;

class SuggestedBookController extends Controller
{
    private $encoder;
    private $normalizer;
    private $suggestionService;

    public function __construct(SuggestionServiceInterface $suggestionService)
    {
        $this->encoder = new JsonEncoder();
        $this->normalizer = new ObjectNormalizer();
        $this->normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $this->suggestionService = $suggestionService;
    }

    /**
     * @Route("/private/suggest-book", methods={"POST"})
     * @param Request $request
     *
     * @return Response
     */
    public function suggestBook(Request $request)
    {
        $bookTitle = "9/11";
        $bookAuthor = "Джордж Буш";
//        $bookTitle = json_decode($request->getContent(), true)["title"];
//        $bookAuthor = json_decode($request->getContent(), true)["author"];

        $this->suggestionService->createSuggestion($bookTitle, $bookAuthor);

        return new Response(null, Response::HTTP_CREATED);
    }

}