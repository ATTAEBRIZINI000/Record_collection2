<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Manager\UserManager;
use App\Repository\UserRepository;
use App\Traits\ApiResponseTrait;
use App\Traits\FormHandlerTrait;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Form\FormFactoryInterface;

#[Route('/api/users')]
class UserController extends AbstractFOSRestController
{
    use ApiResponseTrait;
    use FormHandlerTrait;

    private $userManager;
    private $formFactory;
    private $userRepository;
    private $serializer;

    public function __construct(UserManager $userManager, FormFactoryInterface $formFactory, UserRepository $userRepository, SerializerInterface $serializer)
    {
        $this->userManager = $userManager;
        $this->formFactory = $formFactory;
        $this->userRepository = $userRepository;
        $this->serializer = $serializer;
    }

    #[Route('/', name: 'user_list', methods: ['GET'])]
    public function listUsers(): Response
    {
        $users = $this->userRepository->findAll();
        $serializedUsers = $this->serializer->normalize($users, null, ['groups' => ['get_user']]);
        return $this->createApiResponse($serializedUsers, Response::HTTP_OK);
    }

    #[Route('/{id}', name: 'user_get', methods: ['GET'])]
    public function getUserAction(User $user): Response
    {
        $serializedUser = $this->serializer->normalize($user, null, ['groups' => ['get_user']]);
        return $this->createApiResponse($serializedUser, Response::HTTP_OK);
    }

    #[Route('/', name: 'user_create', methods: ['POST'])]
    public function createUserAction(Request $request): Response
    {
        $user = new User();
        $form = $this->formFactory->create(UserType::class, $user);
        $this->handleForm($request, $form);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userManager->save($user);
            return $this->renderCreatedResponse('User created successfully');
        }

        return $this->createApiResponse($form, Response::HTTP_BAD_REQUEST);
    }

    #[Route('/{id}', name: 'user_update', methods: ['PUT'])]
    public function updateUserAction(Request $request, User $user): Response
    {
        $form = $this->formFactory->create(UserType::class, $user);
        $this->handleForm($request, $form);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userManager->update($user);
            return $this->renderUpdatedResponse('User updated successfully');
        }

        return $this->createApiResponse($form, Response::HTTP_BAD_REQUEST);
    }

    #[Route('/{id}', name: 'user_delete', methods: ['DELETE'])]
    public function deleteUserAction(User $user): Response
    {
        $this->userManager->removeUser($user);
        return $this->renderDeletedResponse('User deleted successfully');
    }
}
