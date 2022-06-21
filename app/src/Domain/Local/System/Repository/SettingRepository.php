<?php
    namespace App\Domain\Local\System\Repository;

    use App\Domain\Local\System\Entity\Setting;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\Persistence\ManagerRegistry;

    class SettingRepository extends ServiceEntityRepository {

        public function __construct(ManagerRegistry $registry) {
            parent::__construct($registry, Setting::class);
        }

    }