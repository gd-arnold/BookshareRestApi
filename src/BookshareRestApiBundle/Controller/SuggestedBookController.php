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
use Symfony\Component\Serializer\Serializer;

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
        $bookTitle = json_decode($request->getContent(), true)["title"];
        $bookAuthor = json_decode($request->getContent(), true)["author"];

        $this->suggestionService->createSuggestion($bookTitle, $bookAuthor);

        return new Response(null, Response::HTTP_CREATED);
    }

    /**
     * @Route("/private/suggestions", methods={"GET"})
     *
     * @return Response
     */
    public function getAllBookSuggestions()
    {
        $suggestions = $this->suggestionService->getAllBookSuggestions();

        $serializer = new Serializer(array($this->normalizer), array($this->encoder));

        $json = $serializer->serialize($suggestions, 'json', ['attributes' => ['id', 'bookTitle', 'bookAuthor',
            'proposer' => ['id', 'firstName', 'lastName', 'email']]]);

        return new Response($json,
            Response::HTTP_OK,
            array('content_type' => 'application/json'));
    }

    /**
     * @Route("/private/cancel-suggestion", methods={"POST"})
     *
     * @param Request $request
     * @return Response
     */
    public function cancelBookSuggestion(Request $request) {
        $suggestionId = json_decode($request->getContent(), true)["suggestionId"];

        $this->suggestionService->deleteBookSuggestion($this->suggestionService->bookSuggestionById($suggestionId));

        return new Response(null, Response::HTTP_CREATED);
    }

}