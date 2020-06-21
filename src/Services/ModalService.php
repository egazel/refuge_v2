<?php
namespace App\Services;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModalService extends AbstractController 
{    
    private $serializerInterface;

    public function __construct(SerializerInterface $serializerInterface)
    {
        $this->serializerInterface = $serializerInterface;
    }

    public function injectEntityToModal($entityRepository, $request){
        $entityDetail = $entityRepository->findOneById($request->query->get('id'));
        $entityJson = $this->serializerInterface->serialize($entityDetail, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return $this->json($entityJson, 200, ['Content-Type' => 'application/json']);
    }
}
?>