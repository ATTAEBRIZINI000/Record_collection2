<?php
namespace App\Controller;

use App\Entity\Records;
use App\Form\RecordsType;
use App\Manager\RecordsManager;
use App\Repository\RecordsRepository;
use App\Traits\ApiResponseTrait;
use App\Traits\FormHandlerTrait;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Form\FormFactoryInterface;

#[Route('/api/records')]
class RecordsController extends AbstractFOSRestController
{
    use ApiResponseTrait;
    use FormHandlerTrait;

    private $recordsManager;
    private $formFactory;
    private $recordsRepository;
    private $serializer;

    public function __construct(RecordsManager $recordsManager, FormFactoryInterface $formFactory, RecordsRepository $recordsRepository, SerializerInterface $serializer)
    {
        $this->recordsManager = $recordsManager;
        $this->formFactory = $formFactory;
        $this->recordsRepository = $recordsRepository;
        $this->serializer = $serializer;
    }

    #[Route('/', name: 'records_list', methods: ['GET'])]
    public function listRecords(Request $request): Response
    {
        $categories = $request->query->get('category');
       
        if (!empty($categories)) {
            
            $records = $this->recordsRepository->findByCategory($categories);
        } else {
            $records = $this->recordsRepository->findAll();
        }        $serializedRecords = $this->serializer->normalize($records, null, ['groups' => ['get_records']]);
        return $this->createApiResponse($serializedRecords, Response::HTTP_OK);
    }

    #[Route('/{id}', name: 'records_get', methods: ['GET'])]
    public function getRecordsAction(Records $records): Response
    {
        $serializedRecords = $this->serializer->normalize($records, null, ['groups' => ['get_records']]);
        return $this->createApiResponse($serializedRecords, Response::HTTP_OK);
    }

    #[Route('/', name: 'records_create', methods: ['POST'])]
    public function createRecordsAction(Request $request): Response
    {
        // Decode JSON data from request body
        $data = json_decode($request->getContent(), true);

        // Validate required fields (you can add more validation as per your needs)
        if (empty($data['artist']) || empty($data['album_title']) || empty($data['label']) || empty($data['date']) || empty($data['vinyls_number']) || empty($data['category']) || empty($data['state'])) {
            return $this->json(['message' => 'Missing required fields'], Response::HTTP_BAD_REQUEST);
        }

        // Create new Records entity
        $records = new Records();
        $records->setArtist($data['artist']);
        $records->setAlbumTitle($data['album_title']);
        $records->setLabel($data['label']);
        $records->setDate(new \DateTime($data['date'])); 
        $records->setVinylsNumber($data['vinyls_number']);
        $records->setCategory($data['category']); 
        $records->setState($data['state']);

        try {
            $this->recordsManager->save($records);

            return $this->json(['message' => 'Record created successfully'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return $this->json(['message' => 'Failed to create record', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/{id}', name: 'records_update', methods: ['PUT'])]
    public function updateRecordsAction(Request $request, Records $records): Response
    {
        // Decode JSON data from request body
        $data = json_decode($request->getContent(), true);

        // Validate required fields (you can add more validation as per your needs)
        if (empty($data['artist']) || empty($data['album_title']) || empty($data['label']) || empty($data['date']) || empty($data['vinyls_number']) || empty($data['category']) || empty($data['state'])) {
            return $this->json(['message' => 'Missing required fields'], Response::HTTP_BAD_REQUEST);
        }

        // Update existing Records entity
        $records->setArtist($data['artist']);
        $records->setAlbumTitle($data['album_title']);
        $records->setLabel($data['label']);
        $records->setDate(new \DateTime($data['date'])); 
        $records->setVinylsNumber($data['vinyls_number']);
        $records->setCategory($data['category']); 
        $records->setState($data['state']);

        try {
            $this->recordsManager->update($records);

            return $this->json(['message' => 'Record updated successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->json(['message' => 'Failed to update record', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/{id}', name: 'records_delete', methods: ['DELETE'])]
    public function deleteRecordsAction(Records $records): Response
    {
        $this->recordsManager->removeRecord($records);
        return $this->renderDeletedResponse('Record deleted successfully');
    }
    
}
