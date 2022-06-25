-- this script is run on the schema prefreferred by DBoilerplate --
-- no need to indicate the schema when the tables are created    --
-- unless you want to use a different schema than the default    --

-- create schema examen;
-- use examen;

-- 

create table training_plan
(
    id       int auto_increment,
    username varchar(100) not null,
    name     varchar(150) not null,
    constraint training_plan_pk
        primary key (id)
);

create table training_plan_activity
(
    id               int auto_increment,
    id_training_plan int         not null,
    day              enum ('S', 'M', 'T', 'W', 'R', 'F', 'U')
                                 not null,
    name             varchar(50) not null,
    repetitions      int         not null,
    breaks           int         not null,
    series           int         not null,
    cadence          int         not null,
    weight           int         not null,
    constraint training_plan_activity_pk
        primary key (id)
);

/*
    Sunday/Lunes:   S
    Monday/Martes:  M
    Tuesday/Miercoles: T
    Wednesday/Jueves: W
    Thursday/Viernes: R
    Friday/Sabado:  F
    Saturday/Domingo: U
*/

-- foreign keys constraints --

alter table training_plan_activity
    add constraint training_plan_activity_fk
        foreign key (id) references training_plan (id)
            on delete cascade;

