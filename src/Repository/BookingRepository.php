<?php

namespace App\Repository;

use App\Entity\Booking;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Booking>
 *
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    public function save(Booking $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Booking $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Booking[] Returns an array of Bookings objects
     */
    public function findFuturesBookingsByUser(User $user): array
    {
        return $this->createQueryBuilder('b')
            ->where('b.user = :user')
            ->setParameter('user', $user->getId())
            ->andWhere('b.bookingTime > :today')
            ->setParameter('today', new \DateTime('today'))
            ->orderBy('b.bookingTime', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Booking[] Returns an array of Bookings objects
     * @throws \Exception
     */
    public function findConcurrency($args): array
    {
        $qb = $this->createQueryBuilder('b');
        $duration = $args['duration'];//->format('Y-m-d H:i:s');
        $start = $args['bookingTime'];//->format('Y-m-d H:i:s');
//        $end = $args['endTime'];//->format('Y-m-d H:i:s');
        $end = (clone $start)->add(new \DateInterval('PT' . $duration . 'M'));

        return $qb

            ->andWhere($qb->expr()->orX(
                $qb->expr()->between('b.bookingTime ', ':bookingTime', ':endTime'),
                $qb->expr()->between('b.endTime ', ':bookingTime', ':endTime')
            ))

            ->setParameter('bookingTime', $start)
            ->setParameter('endTime', $end)
            ->setMaxResults(2)
            ->getQuery()->getResult()
        ;
    }


    /**
     * @return array|null Returns an array of Bookings objects
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getCurrentDateTimeBooking(): ?array
    {
        return $this->createQueryBuilder('b')
            ->where('b.bookingTime < :now')
            ->andWhere('b.endTime > :now')
            ->setParameter('now', new \DateTime('now'))
            ->orderBy('b.bookingTime', 'ASC')
            ->getQuery()
            ->getOneOrNullResult();
    }


    /**
     * @return Booking[] Returns an array of Bookings objects
     */
    public function findPreviousBookingsByUser(User $user): array
    {
        return $this->createQueryBuilder('b')
            ->where('b.user = :user')
            ->setParameter('user', $user->getId())
            ->andWhere('b.bookingTime < :today')
            ->setParameter('today', new \DateTime('today'))
            ->orderBy('b.bookingTime', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return Booking[] Returns an array of Bookings objects
     */
    public function findBookingsByDateRangeAndUser(\DateTime $startDate, \DateTime $endTime, ?User $user = null): array
    {
        $qb = $this->createQueryBuilder('b')
            ->where('b.bookingTime > :startDate')
            ->setParameter('startDate',  new \DateTime('last year'))
            ->andWhere('b.bookingTime <= :endDate')
            ->setParameter('endDate', new \DateTime('next year'));

        if($user instanceof User){
            $qb->andWhere('b.user = :user')
                ->setParameter('user', $user);
        }
            return $qb->orderBy('b.bookingTime', 'ASC')
                ->setMaxResults(100)
                ->getQuery()
                ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?Bookings
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
