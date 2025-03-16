<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Department;
use App\Repository\UserRepository;
use App\Repository\DepartmentRepository;
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
        $queryBuilder = $repo->createQueryBuilder('u')
        ->leftJoin('u.department', 'd')
        ->addSelect('d');
        
        if ($search) {
            $queryBuilder->andWhere('u.first_name LIKE :search OR u.last_name LIKE :search')
                     ->setParameter('search', '%' . $search . '%');
        }

        if ($sort) {
            if ($sort === 'department.name') {
                $queryBuilder->orderBy('d.name', 'ASC'); 
            } else {
            $queryBuilder->orderBy('u.' . $sort, 'ASC');
            }
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
        $departmentId = $request->request->get('department');
        if ($departmentId) {
        $department = $em->getRepository(Department::class)->find($departmentId);
        $user->setDepartment($department); 
        }
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('index_user');
    }

    #[Route('/user/create')]
    public function formCreate(EntityManagerInterface $em): Response
    {
        $departments = $em->getRepository(Department::class)->findAll();
        return $this->render('user/create.html.twig', [
            'departments' => $departments,
        ]);
    }

    #[Route('/user/{user}', name: 'edit_user', methods: ['GET'])]
    public function edit(User $user, EntityManagerInterface $em): Response
    {
        $departments = $em->getRepository(Department::class)->findAll();

        return $this->render('user/edit.html.twig', [
        'user' => $user,
        'departments' => $departments,
        ]);
    }

    #[Route('/user/{user}', name: 'update_user', methods: ['PUT'])]
    public function update(Request $request, User $user, EntityManagerInterface $em): Response
    {
        $user->setFirstName($request->request->get('first_name'));
        $user->setLastName($request->request->get('last_name'));
        $user->setAge($request->request->get('age'));
        $user->setStatus($request->request->get('status'));
        $user->setEmail($request->request->get('email'));
        $user->setTelegram($request->request->get('telegram'));
        $user->setAddress($request->request->get('address'));
        $departmentId = $request->request->get('department');
        if ($departmentId) {
        $department = $em->getRepository(Department::class)->find($departmentId);
        $user->setDepartment($department); 
        }

        $em->flush();

        return $this->redirectToRoute('edit_user', ['user' => $user->getId()]);
    }

    #[Route('/user/{user}/del', name: 'delete_user', methods: ['DELETE'])]
    public function delete(User $user, EntityManagerInterface $em): Response 
    {
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('index_user');
    }
}

