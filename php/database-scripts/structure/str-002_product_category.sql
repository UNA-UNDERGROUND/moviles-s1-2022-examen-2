-- this script is run on the schema prefreferred by DBoilerplate --
-- no need to indicate the schema when the tables are created    --
-- unless you want to use a different schema than the default    --

create table tbproductcategory (
    idproductcategory                   int(11) not null auto_increment,
    nameproductcategory                 varchar(45) not null,
    descriptionproductcategory          varchar(45) not null,
    primary key (idproductcategory)
);