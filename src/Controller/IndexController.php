<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Task;

class IndexController extends AbstractController
{

    public function index()
    {
    	$tasks = $this->getDoctrine()
	        ->getRepository(Task::class)
	        ->findAll();

        return $this->render('index.html.twig', [
        	'tasks' => $tasks
        ]);
    }

    public function addTask(Request $request)
    {
    	$entityManager = $this->getDoctrine()->getManager();

    	$task = new Task();
    	$task->setName($request->get('name'));
    	$entityManager->persist($task);
    	$entityManager->flush($task);

    	return new JsonResponse(['id' => $task->getId()]);
    }

    public function editTask(Request $request)
    {
    	$task = $this->getDoctrine()
	        ->getRepository(Task::class)
	        ->find($request->get('id'));
	    $task->setName($request->get('name'));
	    $entityManager = $this->getDoctrine()->getManager();
	    $entityManager->persist($task);
    	$entityManager->flush($task);

        return new JsonResponse([]);
	}
	
	public function deleteTask(Request $request)
    {
    	$task = $this->getDoctrine()
	        ->getRepository(Task::class)
	        ->find($request->get('id'));	    
	    $entityManager = $this->getDoctrine()->getManager();
	    $entityManager->remove($task);
    	$entityManager->flush($task);
		
        return new JsonResponse([]);
    }

}
