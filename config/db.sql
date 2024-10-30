create user gaetano password 'tirocinio';

drop table if exists reparto cascade;
drop table if exists utente cascade;
drop table if exists events cascade;


create table utente(
	matricola numeric primary key,
	username varchar(100) not null,
	password varchar(255) not null,
	reparto numeric not null references reparto(codice),
	ore_libere numeric default 6
);
/*
create table utente(
	matricola varchar(100) primary key,
	username varchar(100) not null,
	password varchar(255) not null
);*/
/*per utenti*/
create table attività(
	id int not null references events(id),
    title varchar(255) not null,
    start_event timestamp  not null,
    end_event timestamp  not null,
	dipendente numeric references utente(matricola) not null,
	ore_libere numeric not null default 6,
	primary key (id,dipendente)
);

create table reparto(
    codice numeric primary key,
	nome_reparto varchar(100) not null,
    num_dipendenti int not null
);/*
create table events(
    id int primary key,
    title varchar(255) not null,
    start_event date  not null,
    end_event date  not null,
	reparto numeric references reparto(codice) not null
);*/

create table events(
    id int primary key,
    title varchar(255) not null,
    start_event timestamp  not null,
    end_event timestamp  not null,
	reparto numeric references reparto(codice) not null
);



grant all privileges on all tables in schema public to gaetano;
grant all privileges on all sequences in schema public to gaetano;