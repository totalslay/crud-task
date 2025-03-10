<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    #[Route('/user', name: 'index_user', methods:'GET')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $search = $request->query->get('search');
        $sort = $request->query->get('sort');

        $repo = $em->getRepository(User::class);
        $queryBuilder = $repo->createQueryBuilder('u');


        if ($search) {
            $queryBuilder->andWhere('u.first_name LIKE :search OR u.last_name LIKE :search')
                     ->setParameter('search', '%' . $search . '%');
        }

        if ($sort) {
            $queryBuilder->orderBy('u.' . $sort, 'ASC');
        }

        $users = $queryBuilder->getQuery()->getResult();

        return $this->render('user/index.html.twig', [
            'users' => $users,
            'search' => $search,
            'sort' => $sort,
        ]);
    }

    #[Route('/user/create', name: 'create_user', methods: ['POST'])]
    public function create(EntityManagerInterface $em, Request $request): Response
    {
        $user = new User();
        $user->setFirstName($request->request->get('first_name'));
        $user->setLastName($request->request->get('last_name'));
        $user->setAge($request->request->get('age'));
        $user->setStatus($request->request->get('status'));
        $user->setEmail($request->request->get('email'));
        $user->setTelegram($request->request->get('telegram'));
        $user->setAddress($request->request->get('address'));
        
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('index_user');
    }

    #[Route('/user/create')]
    public function formCreate(): Response
    {
        return $this->render('user/create.html.twig');
    }

    #[Route('/user/{user}', name: 'edit_user', methods: ['GET'])]
    public function edit(User $user): Response
    {
        return $this->render('user/edit.html.twig', ['user' => $user]);
    }

    #[Route('/user/{user}', name: 'update_user', methods: ['POST'])]
    public function update(Request $request, User $user, EntityManagerInterface $em): Response
    {
        $user->setFirstName($request->request->get('first_name'));
        $user->setLastName($request->request->get('last_name'));
        $user->setAge($request->request->get('age'));
        $user->setStatus($request->request->get('status'));
        $user->setEmail($request->request->get('email'));
        $user->setTelegram($request->request->get('telegram'));
        $user->setAddress($request->request->get('address'));

        $em->flush();

        return $this->redirectToRoute('edit_user', ['user' => $user->getId()]);
    }

    #[Route('/user/{user}/del', name: 'delete_user', methods: ['POST'])]
    public function delete(User $user, EntityManagerInterface $em): Response 
    {
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('index_user');
    }
}

