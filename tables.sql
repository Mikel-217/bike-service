CREATE DATABASE IF NOT EXISTS BikeService;
USE BikeService;


CREATE TABLE ServiceType (
    ServiceTypeId int NOT NULL AUTO_INCREMENT,
    ServiceName varchar(255),
    PRIMARY KEY (ServiceTypeId)
);


CREATE TABLE Bikes (
    BikeId int NOT NULL AUTO_INCREMENT,
    BikeName varchar(255),
    BikeManufactor varchar(100),
    BikeYear Date,
    BikeHP int,
    BikeKM int,
    PRIMARY KEY (BikeId)
);


CREATE TABLE Services (
    ServiceId int NOT NULL AUTO_INCREMENT,
    ServiceName varchar(255),
    ServiceContent varchar(255),
    ServiceKM int NOT NULL,
    BikeId int NOT NULL,
    PRIMARY KEY (ServiceId),
    FOREIGN KEY (BikeId) REFERENCES Bikes(BikeId) ON DELETE CASCADE
);



INSERT INTO ServiceType VALUES
('DEFAULT', 'Saison start'),
('DEFAULT', 'Einwintern'),
('DEFAULT', 'Ölwechsel'),
('DEFAULT', 'Reifenwechsel'),
('DEFAULT', 'Wartung der Bremse'),
('DEFAULT', 'Wartung der Kette'),
('DEFAULT', '');