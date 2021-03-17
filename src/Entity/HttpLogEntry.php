<?php

namespace App\Entity;

use DateTimeInterface;
use UmaTech\HttpLogBundle\Entity\HttpLogRecordInterface;
use App\Repository\HttpLogEntryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HttpLogEntryRepository::class)
 * @ORM\Table(name="http_log_entry", indexes={
 *   @ORM\Index(name="http_log_entry_ip", columns={"ip"})
 *   })
 */
class HttpLogEntry implements HttpLogRecordInterface
{
  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=15)
   */
  private $ip;

  /**
   * @ORM\Column(type="string", length=255)
   */
  private $uri;

  /**
   * @ORM\Column(type="text")
   */
  private $request;

  /**
   * @ORM\Column(type="text")
   */
  private $response;

  /**
   * @ORM\Column(type="integer")
   */
  private $status;

  /**
   * @ORM\Column(type="datetime")
   * @var DateTimeInterface
   */
  private $query_time;

  public function getId(): int{ return $this->id; }
  public function setId(int $id): void{ $this->id = $id; }
  public function getIp(): string{ return $this->ip; }
  public function setIp(string $ip): void{ $this->ip = $ip; }
  public function getUri(): string{ return $this->uri; }
  public function setUri(string $uri): void{ $this->uri = $uri; }
  public function getRequest(): string{ return $this->request; }
  public function setRequest(string $request): void{ $this->request = $request; }
  public function getResponse(): string{ return $this->response; }
  public function setResponse(string $response): void{ $this->response = $response; }
  public function getStatus(): int{ return $this->status; }
  public function setStatus(int $status): void{ $this->status = $status; }
  public function getQueryTime(): DateTimeInterface{ return $this->query_time; }
  public function setQueryTime(DateTimeInterface $query_time): void{ $this->query_time = $query_time; }
  public function jsonSerialize(): array
  {
    return [
        'id' => $this->id,
        'ip' => $this->ip,
        'uri' => $this->uri,
        'request' => $this->request,
        'response' => $this->response,
        'status' => $this->status,
        'queryTime' => $this->query_time->format('Y-m-d H:i:s'),
    ];
  }
}
