<?php
namespace App\Services;

use App\Entity\Animal;
use App\Entity\Gerant;
use App\Form\AnimalType;
use Doctrine\ORM\EntityManager;
use App\Repository\AnimalRepository;
use App\Repository\GerantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use App\Services\ContainerParametersHelper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AnimalService extends AbstractController 
{    

    public function __construct(GerantRepository $gerantRepository, EntityManagerInterface $entityManager, ContainerParametersHelper $pathHelpers, SluggerInterface $slugger)
    {
        $this->gerantRepository = $gerantRepository;
        $this->entityManager = $entityManager;
        $this->pathHelpers = $pathHelpers;
        $this->slugger = $slugger;

    }
    
    public function createAnimal(FormInterface $addAnimalForm, Animal $animal){
        $isModalValid = true;

        if ($addAnimalForm->isSubmitted()) {
            if ($addAnimalForm->isValid()){
                $gerant = $this->gerantRepository->findOneByUser($this->getUser());
                $animal->setGerant($gerant);
                $animal->setIsHosted(false);
                $animal->setDateAdd(new \DateTime('now'));
                /** @var UploadedFile $picture */
                $picture = $addAnimalForm->get('imageLinks')->getData();
                if ($picture){
                    $originalFileName = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                    $fileExtension = pathinfo($picture->getClientOriginalName(), PATHINFO_EXTENSION);

                    $relativeSaveDir = '/img/Animals/'.$this->slugger->slug($animal->getName())."/";
                    $saveDir = $this->pathHelpers->getApplicationRootDir(). "/public" . $relativeSaveDir;

                    $safeFileName = $this->slugger->slug($originalFileName) . "." .  $fileExtension;
                    
                    $picture->move(
                        $saveDir,
                        $safeFileName
                    );

                    $animal->setImageLinks([$relativeSaveDir . "/" . $safeFileName]);
                }
                $this->entityManager->persist($animal);
                $this->entityManager->flush();
                $this->addFlash(
                    'success',
                    'L\'animal a bien été ajouté !'
                );
                $animal = new Animal();
                $addAnimalForm = $this->createForm(AnimalType::class, $animal);
                $this->redirectToRoute('animalList', ['addAnimalForm' => $addAnimalForm->createView(), 'isModalValid' => $isModalValid]);
            } else {
                $isModalValid = false;
                $this->addFlash(
                    'warning',
                    'Erreur dans le formulaire.'
                );
            }
            $this->redirectToRoute('animalList', ['addAnimalForm' => $addAnimalForm->createView(), 'isModalValid' => $isModalValid]);
        }
    }
}
?>