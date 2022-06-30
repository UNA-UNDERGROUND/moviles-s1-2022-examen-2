-- this script is run on the schema prefreferred by DBoilerplate --
-- no need to indicate the schema when the tables are created    --
-- unless you want to use a different schema than the default    --

create table tbnutritionplan
(
    idnutritionplan         int          not null   primary key,
    name                    varchar(30)  not null,
    imagecodeqr             varchar(300) not null
);

create table tbnutritionplandetails
(
    idnutritionplandetails int          auto_increment   primary key,
    idnutritionplan        int          not null,
    foodday                varchar(15)  not null,
    foodtime               varchar(15)  not null,
    description            varchar(300) not null
);