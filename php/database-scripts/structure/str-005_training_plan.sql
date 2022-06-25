-- this script is run on the schema prefreferred by DBoilerplate --
-- no need to indicate the schema when the tables are created    --
-- unless you want to use a different schema than the default    --

create table tbtrainingplan
(
    idtrainingplan     int          not null    primary key,
    username           varchar(50)  not null,
    nametrainingplan   varchar(50)  not null,
    qrcodetrainingplan varchar(300) not null
);

create table tbfavoriteplan
(
    idfavoriteplan int not null     primary key,
    idplan         int not null,
    iduser         int not null,
    typeplan       int not null
);

