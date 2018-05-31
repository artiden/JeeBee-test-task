<?php
namespace App\Repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Support\Config;

class TaskRepository extends EntityRepository
{

    public function getPaggedTasks(int $page = 1, string $order = null)
    {
        $defaultOrder = 't.id';
        $mode = 'DESC';
        $allowedOrder = [
            'name' => 't.userName',
            'email' => 't.userEmail',
            'status' => 't.isDone',
        ];
        if (!is_null($order)) {
            if (!in_array($order, array_keys($allowedOrder))) {
                $order = $defaultOrder;
            } else {
                $order = $allowedOrder[$order];
                $mode = 'ASC';
            }
        } else {
            $order = $defaultOrder;
        }
        $perPage = Config::get('TASKS_PER_PAGE', 3);
        $queryBuilder = Config::getEntityManager()->createQueryBuilder();
        $queryBuilder->select('t')
        ->from('App\Models\Task', 't')
        ->orderBy($order, $mode);
        $paginator = new Paginator($queryBuilder->getQuery());
        $paginator->getQuery()
        ->setFirstResult($perPage * ($page - 1))
        ->setMaxResults($perPage);

        return $paginator;
    }
}
