<?php

namespace App\Controllers;

use App\Support\Config;
use App\Models\Task;
use App\Repositories\TaskRepository;
use Suin\ImageResizer\ImageResizer;

class TaskController extends BaseController
{
    private $repository;

    public function __construct()
    {
        //DI container should be used here.
        $this->repository = Config::getEntityManager()->getRepository(Task::class);
    }

    /**
     * Shows all saved tasks
     * 
     * @return string
     */
    public function index()
    {
        $currentPage = intval($this->getParam('page', 1));
        $order = $this->getParam('order', null);
        $tasks = $this->repository->getpaggedTasks($currentPage, $order);
        $totalPages = ceil($tasks->count() / Config::get('TASKS_PER_PAGE'));

        return view('taskList.twig', compact('tasks', 'currentPage', 'totalPages', 'order'));
    }

    /**
     * Create a new task entity
     * 
     * @return string
     */
    public function create()
    {
        $userName = $this->getParam('user_name', null);
        $userEmail = $this->getParam('user_email', null);
        $description = $this->getParam('description', null);
        if (!$userName || !$userEmail || !$description) {
            return view('error.twig');
        }

        $task = new Task();
        $task->setUserName($userName);
        $task->setUserEmail($userEmail);
        $task->setDescription($description);
        $task->setCreatedAt();

        if ($_FILES['image'] && is_uploaded_file($_FILES['image']['tmp_name'])) {
            $isImage = true;
            $imageName = time();
            try {
                $imageResizer = new ImageResizer($_FILES['image']['tmp_name']);
                $imageResizer->maxWidth(Config::get('IMAGE_WIDTH', 320))
                ->maxHeight(Config::get('IMAGE_HEIGHT', 240))
                ->resize();
            } catch (\Exception $e) {
                $isImage = false;
                $imageName = null;
            }
            if ($isImage && move_uploaded_file($_FILES['image']['tmp_name'], __DIR__.'/../../images/'.$imageName)) {
                $task->setImage($imageName);
            }
        }
        $entityManager = Config::getEntityManager();
        $entityManager->persist($task);
        $entityManager->flush();
        $this->redirect('/');
    }

    /**
     * Edit a task entity
     */
    public function edit()
    {
        if (!isAdmin()) {
            $this->redirect('/');
        }
        $id = $this->getParam('id', null);

        if (!$id) {
            $this->redirect('/');
        }

        $entityManager = Config::getEntityManager();
        $task = $entityManager->find(Task::class, $id);
        if (!$task) {
            $this->redirect('/');
        }

        $task->setDone($this->getParam('done', $task->isDone()));
        $task->setDescription($this->getParam('description'));
        $entityManager->flush($task);
        $this->redirect('/');
    }
}
