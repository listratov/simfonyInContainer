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
create table teams
(
    id   int auto_increment
        primary key,
    name varchar(255) not null,
    date datetime     null
);

create table tournaments
(
    id   int auto_increment
        primary key,
    name varchar(255) not null,
    slug varchar(255) not null,
    date datetime     null
);

create table tournaments_teams
(
    id   int auto_increment
        primary key,
    tournaments_id int      null,
    teams_id       int      null,
    teams_id2      int      null,
    date           datetime null,
    constraint tournamentsId_tems___t
        foreign key (tournaments_id) references tournaments (id) ON DELETE CASCADE,
    constraint tournamentsId_tems___fk1
        foreign key (teams_id) references teams (id),
    constraint tournamentsId_tems___fk2
        foreign key (teams_id2) references teams (id)
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
