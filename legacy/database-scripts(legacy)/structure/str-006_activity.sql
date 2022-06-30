-- this script is run on the schema prefreferred by DBoilerplate --
-- no need to indicate the schema when the tables are created    --
-- unless you want to use a different schema than the default    --

create table tbactivity
(
    idactivity          int         not null auto_increment,
    idday               int         not null,
    idtrainingplan      int         not null,
    nameactivity        varchar(50) not null,
    repetitionsactivity int         not null,
    breaksactivity      int         not null,
    seriesactivity      int         not null,
    cadenceactivity     int         not null,
    weightactivity      int         not null,
    primary key (idactivity)
);

create table tbday
(
    idday   int         not null    primary key,
    nameday varchar(20) not null
);