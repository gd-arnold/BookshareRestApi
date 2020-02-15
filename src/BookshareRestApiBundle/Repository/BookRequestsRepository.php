<?php

namespace BookshareRestApiBundle\Repository;

use BookshareRestApiBundle\Entity\BookRequest;
use BookshareRestApiBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * BookRequestsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BookRequestsRepository extends \Doctrine\ORM\EntityRepository
{
    public function __construct(EntityManagerInterface $em,
                                Mapping\ClassMetadata $metadata = null)
    {
        parent::__construct($em,
            $metadata == null ?
                new Mapping\ClassMetadata(BookRequest::class) :
                $metadata
        );
    }

    public function save(BookRequest $request): bool
    {
        try {
            $this->_em->persist($request);
            $this->_em->flush();
            return true;
        } catch ( OptimisticLockException $e ) {
            return false;
        } catch ( ORMException $e ) {
            return false;
        }
    }

    public function merge(BookRequest $request): bool
    {
        try {
            $this->_em->merge($request);
            $this->_em->flush();
            return true;
        } catch ( OptimisticLockException $e ) {
            return false;
        } catch ( ORMException $e ) {
            return false;
        }
    }

    public function findAllUnreadRequestsForCurrentUserCount(User $user) {
        try {
            return $this
                ->createQueryBuilder('book_requests')
                ->leftJoin('book_requests.receiver', 'receiver')
                ->leftJoin('book_requests.requester', 'requester')
                ->where('receiver.id = :id')
                ->andWhere('book_requests.isReadByReceiver = false')
                ->orWhere('requester.id = :id')
                ->andWhere('book_requests.isReadByRequester = false')
                ->setParameter('id', $user->getId())
                ->select('count(book_requests)')
                ->getQuery()
                ->getSingleScalarResult();
        } catch ( NoResultException $e ) {
            return false;
        } catch ( NonUniqueResultException $e ) {
            return false;
        }
    }

    public function findAllRequestsForCurrentUser(User $user) {
        return $this
            ->createQueryBuilder('book_requests')
            ->leftJoin('book_requests.receiver', 'receiver')
            ->leftJoin('book_requests.requester', 'requester')
            ->where('receiver.id = :id')
            ->orWhere('requester.id = :id')
            ->setParameter('id', $user->getId())
            ->select('book_requests')
            ->getQuery()
            ->getResult();
    }
}
