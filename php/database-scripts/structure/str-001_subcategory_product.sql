-- this script is run on the schema prefreferred by DBoilerplate --
-- no need to indicate the schema when the tables are created    --
-- unless you want to use a different schema than the default    --

create table tbsubcategoryproduct (
    idsubcategoryproduct                int(11) not null auto_increment,
    idcategoryproduct                   int(11) not null,
    namesubcategoryproduct              varchar(45) not null,
    descriptionsubcategoryproduct       varchar(45) not null,
    primary key (idsubcategoryproduct)
);
