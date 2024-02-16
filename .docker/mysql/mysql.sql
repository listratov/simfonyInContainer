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

