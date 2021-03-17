<?php

namespace App\Repository;

use App\Entity\HttpLogEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UmaTech\HttpLogBundle\Service\HttpRecordRepositoryInterface;
use UmaTech\HttpLogBundle\Service\PersisterInterface;

class HttpLogEntryRepository extends ServiceEntityRepository implements HttpRecordRepositoryInterface, PersisterInterface
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, HttpLogEntry::class);
  }

  public function findByIpPaged(string $ip, int $page = 0, int $size = null): array
  {
    $qb = $this->createQueryBuilder('l');
    if ($size) {
      $qb->setFirstResult($page * $size);
      $qb->setMaxResults($size);
    }
    $qb->where('l.ip = :ip')
        ->setParameter(':ip', $ip);

    return $qb->getQuery()->getResult();
  }
  public function findPaged(int $page = 0, int $size = null): array
  {
    $qb = $this->createQueryBuilder('l');
    if ($size) {
      $qb->setFirstResult($page * $size);
      $qb->setMaxResults($size);
    }

    return $qb->getQuery()->getResult();
  }
  public function persist(Request $request, Response $response)
  {
    /** @var HttpLogEntry $record */
    $record = $this->getClassMetadata()->newInstance();
    $record->setIp($request->getClientIp());
    $record->setUri($request->getUri());
    $record->setStatus($response->getStatusCode());
    $record->setQueryTime($response->getDate());

    $record->setRequest(self::joinHeaders($request->headers) . "\r\n\r\n" . $request->getContent());
    $record->setResponse(self::joinHeaders($response->headers) . "\r\n\r\n" . $response->getContent());

    $em = $this->getEntityManager();
    $em->persist($record);
    $em->flush();
  }

  private static function joinHeaders(HeaderBag $headers): string
  {
    $list = [];
    foreach ($headers as $key => $value) {
      foreach ($value as $headerValue) {
        $list[] = "{$key}: {$headerValue}";
      }
    }

    return implode("\r\n", $list);
  }
}
