<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240312050029 extends AbstractMigration
{

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
ALTER TABLE teams ADD description varchar(255) null;
SQL;

        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $sql = <<<SQL
    ALTER TABLE teams DROP COLUMN description;
SQL;
        $this->addSql($sql);

    }
}
