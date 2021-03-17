<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210317053124 extends AbstractMigration
{
  protected const SQL_CREATE_TABLE = <<<'SQL'
CREATE TABLE http_log_entry (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
    ip VARCHAR(15) NOT NULL, 
    uri VARCHAR(255) NOT NULL, 
    request CLOB NOT NULL, 
    response CLOB NOT NULL, 
    status INTEGER NOT NULL, 
    query_time DATETIME NOT NULL
)
SQL;

  public function getDescription(): string
  {
    return 'Add table for http_log_entry';
  }

  public function up(Schema $schema): void
  {
    $this->addSql(self::SQL_CREATE_TABLE);
    $this->addSql('CREATE INDEX http_log_entry_ip ON http_log_entry (ip)');
  }

  public function down(Schema $schema): void
  {
    $this->addSql('DROP TABLE http_log_entry');
  }
}
