<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Platforms\AbstractMySQLPlatform;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240214080631 extends AbstractMigration
{

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof AbstractMySQLPlatform,
            'Migration can only be executed safely on \'mysql\'.'
        );

        $sql = <<<SQL

create schema if not exists db_project collate utf8mb4_0900_ai_ci;

create table if not exists teams
(
    id int auto_increment
        primary key,
    name varchar(255) not null,
    date datetime not null
);

create table if not exists tournaments
(
    id int auto_increment
        primary key,
    name varchar(255) not null,
    date datetime null
);

create table if not exists tournaments_teams
(
    id int auto_increment,
    tournaments_id int null,
    teams_id int null,
    teams_id2 int null,
    date datetime null,
    name int null,
    constraint id
        unique (id)
);
SQL;

        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $sql = <<<SQL
    DROP DATABASE db_project;
SQL;
        $this->addSql($sql);

    }
}
