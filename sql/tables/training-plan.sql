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
    Sunday/Domingo:   S
    Monday/Lunes:     M
    Tuesday/Martes:   T
    Wednesday/Miercoles: W
    Thursday/Jueves:  R
    Friday/Viernes:   F
    Saturday/Sabado:  U
*/

-- foreign keys constraints --

alter table training_plan_activity
    add constraint training_plan_activity_fk
        foreign key (id_training_plan) references training_plan (id)
            on delete cascade;

-- unique constraints --

-- training plan cannot have duplicate names per username --
alter table training_plan
    add constraint training_plan_name_unique
        unique (username, name);

-- the activity cannot have the same name per training plan --
alter table training_plan_activity
    add constraint training_plan_activity_name_unique
        unique (id_training_plan, name);