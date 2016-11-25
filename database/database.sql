CREATE TABLE Users (
  ID          INTEGER PRIMARY KEY,
  Username    TEXT NOT NULL,
  Password    TEXT NOT NULL,
  Email       TEXT NOT NULL,
  Name        TEXT NOT NULL,
  DateOfBirth DATE,
  Gender      CHARACTER(1),
  Picture     TEXT
);

CREATE TABLE UserGroups (
  ID INTEGER PRIMARY KEY

);

CREATE TABLE Restaurants (
  ID          INTEGER PRIMARY KEY,
  OwnerID     INTEGER NOT NULL REFERENCES Users,
  Name        TEXT NOT NULL,
  Address     TEXT,
  Description TEXT
);

CREATE TABLE RestaurantPhotos (
  ID           INTEGER PRIMARY KEY,
  RestaurantID INTEGER NOT NULL REFERENCES Restaurants,
  Path         TEXT NOT NULL
);

CREATE TABLE Reviews (
  ID           INTEGER PRIMARY KEY,
  RestaurantID INTEGER NOT NULL REFERENCES Restaurants,
  ReviewerID   INTEGER NOT NULL REFERENCES Users,
  Score        TINYINT NOT NULL,
  Comment      TEXT
);

CREATE TABLE Replies (
  ID       INTEGER PRIMARY KEY,
  ReviewID INTEGER NOT NULL REFERENCES Reviews,
  Text     TEXT
);
