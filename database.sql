CREATE TABLE Users (
  ID          AS INTEGER PRIMARY KEY,
  Username    AS TEXT NOT NULL,
  Password    AS TEXT NOT NULL,
  Email       AS TEXT NOT NULL,
  Name        AS TEXT NOT NULL,
  DateOfBirth AS DATE,
  Gender      AS CHARACTER(1),
  Picture     AS TEXT
);

CREATE TABLE UserGroups (
  ID AS INTEGER PRIMARY KEY

);

CREATE TABLE Restaurants (
  ID      AS INTEGER PRIMARY KEY,
  FOREIGN KEY (OwnerID) REFERENCES Users (ID) ,
  Name AS TEXT NOT NULL,
  Address AS TEXT,
  Description AS TEXT
);

CREATE TABLE RestaurantPhotos (
  ID AS INTEGER PRIMARY KEY,
  FOREIGN KEY (RestaurantID) REFERENCES Restaurants(ID),
  Path AS TEXT NOT NULL
);

CREATE TABLE Reviews (
  ID AS INTEGER PRIMARY KEY,
  FOREIGN KEY (RestaurantID) REFERENCES Restaurants(ID),
  FOREIGN KEY (ReviewerID) REFERENCES Users(ID),
  Score AS TINYINT NOT NULL,
  Comment AS TEXT
);

CREATE TABLE Replies(
  ID AS INTEGER PRIMARY KEY,
  FOREIGN KEY (ReviewID) REFERENCES Reviews(ID),
  Text AS TEXT
);
