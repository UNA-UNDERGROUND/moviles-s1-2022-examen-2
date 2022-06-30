-- this script is run on the schema prefreferred by DBoilerplate --
-- no need to indicate the schema when the tables are created    --
-- unless you want to use a different schema than the default    --

create table tbproduct
(
    idproduct     int         auto_increment primary key,
    idsubcategory int         not null,
    name          varchar(45) not null,
    description   varchar(45) not null,
    price         double      not null,
    stock         int         not null,
    image         varchar(45) not null,
    legalDocument int         null,
);