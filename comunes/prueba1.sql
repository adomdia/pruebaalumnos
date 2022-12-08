DROP TABLE IF EXISTS alumnos CASCADE;

CREATE TABLE alumnos (
    id           bigserial    PRIMARY KEY,
    codigo       numeric(2)   NOT NULL UNIQUE,
    denominacion varchar(255) NOT NULL
);

DROP TABLE IF EXISTS ccee CASCADE;

CREATE TABLE ccee (
    id           bigserial    PRIMARY KEY,
    codigo       numeric(2)   NOT NULL UNIQUE,
    descripcion  varchar(255) NOT NULL
);

DROP TABLE IF EXISTS notas CASCADE;

CREATE TABLE notas (
    id              bigserial     PRIMARY KEY,
    alumno_id       bigint        NOT NULL UNIQUE REFERENCES alumnos (id),
    ccee_id         bigint        NOT NULL UNIQUE REFERENCES ccee (id)
);