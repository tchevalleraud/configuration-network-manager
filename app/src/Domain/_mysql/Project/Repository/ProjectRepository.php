<?php
    namespace App\Domain\_mysql\Project\Repository;

    use App\Domain\_mysql\Project\Entity\Project;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\Persistence\ManagerRegistry;

    class ProjectRepository extends ServiceEntityRepository {

        public function __construct(ManagerRegistry $registry) {
            parent::__construct($registry, Project::class);
        }

    }