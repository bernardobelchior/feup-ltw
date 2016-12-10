CREATE TABLE Users (
  ID          INTEGER PRIMARY KEY,
  Username    TEXT    NOT NULL UNIQUE,
  Password    TEXT    NOT NULL,
  Email       TEXT    NOT NULL UNIQUE,
  Name        TEXT    NOT NULL,
  GroupID     INTEGER NOT NULL REFERENCES UserGroups,
  DateOfBirth INTEGER, /* Unix timestamp */
  Gender      CHARACTER(1),
  Picture     TEXT
);

CREATE TABLE UserGroups (
  ID   INTEGER PRIMARY KEY,
  Name TEXT NOT NULL
);

CREATE TABLE Permissions (
  ID   INTEGER PRIMARY KEY,
  Name TEXT NOT NULL
);

CREATE TABLE GroupsPermissions (
  ID            INTEGER PRIMARY KEY,
  GroupID       INTEGER NOT NULL REFERENCES UserGroups,
  PermissionsID INTEGER NOT NULL REFERENCES Permissions
);

CREATE TABLE Restaurants (
  ID              INTEGER PRIMARY KEY,
  OwnerID         INTEGER NOT NULL REFERENCES Users,
  Name            TEXT    NOT NULL,
  Address         TEXT    NOT NULL,
  Description     TEXT,
  CostForTwo      INTEGER,
  TelephoneNumber INTEGER
);

CREATE TABLE Categories (
  ID   INTEGER PRIMARY KEY,
  Name TEXT NOT NULL
);

CREATE TABLE RestaurantsCategories (
  ID           INTEGER PRIMARY KEY,
  RestaurantID INTEGER NOT NULL REFERENCES Restaurants,
  CategoryID   INTEGER NOT NULL REFERENCES Categories
);


CREATE TABLE RestaurantPhotos (
  ID           INTEGER PRIMARY KEY,
  RestaurantID INTEGER NOT NULL REFERENCES Restaurants,
  Path         TEXT    NOT NULL
);

CREATE TABLE Reviews (
  ID           INTEGER PRIMARY KEY,
  RestaurantID INTEGER NOT NULL REFERENCES Restaurants,
  ReviewerID   INTEGER NOT NULL REFERENCES Users,
  Title        TEXT    NOT NULL,
  Score        TINYINT NOT NULL,
  Date         INTEGER NOT NULL, /* Unix timestamp */
  Comment      TEXT
);

CREATE TABLE Replies (
  ID        INTEGER PRIMARY KEY,
  ReviewID  INTEGER NOT NULL REFERENCES Reviews,
  ReplierID INTEGER NOT NULL REFERENCES Users,
  Text      TEXT    NOT NULL,
  Date      INTEGER NOT NULL /* Unix timestamp */
);

INSERT INTO Users VALUES
  (NULL, 'admin', '$2y$10$.q./d7RNBpt9ccSQvi9En.d0N4gnZWS5lgD.v76TQaVgn6srGm./6', 'admin@admin.pt', 'Admin', 2, NULL,
   NULL, NULL);

/* User Groups */
INSERT INTO UserGroups VALUES (NULL, 'ANONYMOUS');
INSERT INTO UserGroups VALUES (NULL, 'ADMIN');
INSERT INTO UserGroups VALUES (NULL, 'USER');

/* Permissions */
INSERT INTO Permissions VALUES (NULL, 'ADD_RESTAURANT');
INSERT INTO Permissions VALUES (NULL, 'EDIT_RESTAURANT');
INSERT INTO Permissions VALUES (NULL, 'REMOVE_RESTAURANT');
INSERT INTO Permissions VALUES (NULL, 'ADD_ANY_RESTAURANT');
INSERT INTO Permissions VALUES (NULL, 'EDIT_ANY_RESTAURANT');
INSERT INTO Permissions VALUES (NULL, 'REMOVE_ANY_RESTAURANT');

INSERT INTO Permissions VALUES (NULL, 'ADD_REVIEW');
INSERT INTO Permissions VALUES (NULL, 'EDIT_REVIEW');
INSERT INTO Permissions VALUES (NULL, 'REMOVE_REVIEW');
INSERT INTO Permissions VALUES (NULL, 'ADD_REVIEW_TO_OWN_RESTAURANT');
INSERT INTO Permissions VALUES (NULL, 'EDIT_ANY_REVIEW');
INSERT INTO Permissions VALUES (NULL, 'REMOVE_ANY_REVIEW');

INSERT INTO Permissions VALUES (NULL, 'ADD_REPLY');
INSERT INTO Permissions VALUES (NULL, 'EDIT_REPLY');
INSERT INTO Permissions VALUES (NULL, 'REMOVE_REPLY');
INSERT INTO Permissions VALUES (NULL, 'EDIT_ANY_REPLY');
INSERT INTO Permissions VALUES (NULL, 'REMOVE_ANY_REPLY');

INSERT INTO Permissions VALUES (NULL, 'EDIT_ANY_PROFILE');

/* Anonymous Basic Permissions */
INSERT INTO GroupsPermissions VALUES (NULL, 1, 6);

/* Admin Basic Permissions */
INSERT INTO GroupsPermissions VALUES (NULL, 2, 1);
INSERT INTO GroupsPermissions VALUES (NULL, 2, 2);
INSERT INTO GroupsPermissions VALUES (NULL, 2, 3);
INSERT INTO GroupsPermissions VALUES (NULL, 2, 4);
INSERT INTO GroupsPermissions VALUES (NULL, 2, 5);
INSERT INTO GroupsPermissions VALUES (NULL, 2, 6);
INSERT INTO GroupsPermissions VALUES (NULL, 2, 7);
INSERT INTO GroupsPermissions VALUES (NULL, 2, 8);
INSERT INTO GroupsPermissions VALUES (NULL, 2, 9);
INSERT INTO GroupsPermissions VALUES (NULL, 2, 10);
INSERT INTO GroupsPermissions VALUES (NULL, 2, 12);
INSERT INTO GroupsPermissions VALUES (NULL, 2, 13);
INSERT INTO GroupsPermissions VALUES (NULL, 2, 14);
INSERT INTO GroupsPermissions VALUES (NULL, 2, 15);
INSERT INTO GroupsPermissions VALUES (NULL, 2, 16);
INSERT INTO GroupsPermissions VALUES (NULL, 2, 17);
INSERT INTO GroupsPermissions VALUES (NULL, 2, 18);

/* User Basic Permissions */
INSERT INTO GroupsPermissions VALUES (NULL, 3, 1);
INSERT INTO GroupsPermissions VALUES (NULL, 3, 2);
INSERT INTO GroupsPermissions VALUES (NULL, 3, 3);
INSERT INTO GroupsPermissions VALUES (NULL, 3, 7);
INSERT INTO GroupsPermissions VALUES (NULL, 3, 8);
INSERT INTO GroupsPermissions VALUES (NULL, 3, 9);
INSERT INTO GroupsPermissions VALUES (NULL, 3, 13);
INSERT INTO GroupsPermissions VALUES (NULL, 3, 14);
INSERT INTO GroupsPermissions VALUES (NULL, 3, 15);

/* Categories */
INSERT INTO Categories VALUES (NULL, 'Sushi');
INSERT INTO Categories VALUES (NULL, 'Mediterranean');
INSERT INTO Categories VALUES (NULL, 'Chinese');
INSERT INTO Categories VALUES (NULL, 'Indian');
INSERT INTO Categories VALUES (NULL, 'Native American');
INSERT INTO Categories VALUES (NULL, 'Greek');
INSERT INTO Categories VALUES (NULL, 'Portuguese');
INSERT INTO Categories VALUES (NULL, 'Indonesian');

