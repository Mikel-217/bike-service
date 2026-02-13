CREATE TABLE Bikes(
    BikeId int NOT NULL AUTO_INCREMENT,
    BikeName varchar(255),
    BikeManufactor varchar(100),
    BikeYear Date,
    BikeHP int,
    BikeKM int,
    UserId int NOT NULL,

    FOREIGN KEY(UserId) REFERENCES User(UserId)
    PRIMARY KEY(BikeId)
);


CREATE TABLE Services(
    ServiceId int NOT NULL AUTO_INCREMENT,
    ServiceName varchar(255),
    ServiceContent varchar(255)
    ServiceKM int NOT NULL,
    BikeId int NOT NULL,

    FOREIGN KEY(BikeId) REFERENCES Bikes(BikeId),
    PRIMARY KEY(ServiceId)
);


CREATE TABLE User(
    UserId int NOT NULL AUTO_INCREMENT,
    UserName varchar(100),
    UserMail varchar(100),
    UserPW varchar(255),

    PRIMARY KEY(UserId)
);


CREATE TABLE ServiceType(
    ServiceId int NOT NULL AUTO_INCREMENT
    ServiceName varchar(255),

    PRIMARY KEY(ServiceId)
);
