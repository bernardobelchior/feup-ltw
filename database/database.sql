CREATE TABLE Users (
  ID          INTEGER PRIMARY KEY,
  Username    TEXT NOT NULL UNIQUE,
  Password    TEXT NOT NULL,
  Email       TEXT NOT NULL UNIQUE,
  Name        TEXT NOT NULL,
  DateOfBirth DATE,
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
  ID          INTEGER PRIMARY KEY,
  OwnerID     INTEGER NOT NULL REFERENCES Users,
  Name        TEXT    NOT NULL,
  Address     TEXT,
  Description TEXT
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
  Score        TINYINT NOT NULL,
  Comment      TEXT
);

CREATE TABLE Replies (
  ID       INTEGER PRIMARY KEY,
  ReviewID INTEGER NOT NULL REFERENCES Reviews,
  Text     TEXT    NOT NULL
);

/* User Groups */
INSERT INTO UserGroups VALUES (0, 'ANONYMOUS');
INSERT INTO UserGroups VALUES (1, 'ADMIN');
INSERT INTO UserGroups VALUES (2, 'RESTAURANT_OWNER');
INSERT INTO UserGroups VALUES (3, 'REGULAR_USER');

/* Permissions */
INSERT INTO Permissions VALUES (0, 'ADD_RESTAURANT');
INSERT INTO Permissions VALUES (1, 'EDIT_RESTAURANT');
INSERT INTO Permissions VALUES (2, 'REMOVE_RESTAURANT');

INSERT INTO Permissions VALUES (3, 'ADD_REVIEW');
INSERT INTO Permissions VALUES (4, 'EDIT_REVIEW');
INSERT INTO Permissions VALUES (5, 'REMOVE_REVIEW');
INSERT INTO Permissions VALUES (6, 'ADD_REVIEW_TO_OWN_RESTAURANT');

INSERT INTO Permissions VALUES (9, 'ADD_REPLY');
INSERT INTO Permissions VALUES (10, 'EDIT_REPLY');
INSERT INTO Permissions VALUES (11, 'REMOVE_REPLY');

/* Anonymous Basic Permissions */

/* Admin Basic Permissions */
INSERT INTO GroupsPermissions VALUES (NULL, 1, 0);
INSERT INTO GroupsPermissions VALUES (NULL, 1, 1);
INSERT INTO GroupsPermissions VALUES (NULL, 1, 2);
INSERT INTO GroupsPermissions VALUES (NULL, 1, 3);
INSERT INTO GroupsPermissions VALUES (NULL, 1, 4);
INSERT INTO GroupsPermissions VALUES (NULL, 1, 5);
INSERT INTO GroupsPermissions VALUES (NULL, 1, 6);
INSERT INTO GroupsPermissions VALUES (NULL, 1, 7);
INSERT INTO GroupsPermissions VALUES (NULL, 1, 8);
INSERT INTO GroupsPermissions VALUES (NULL, 1, 9);
INSERT INTO GroupsPermissions VALUES (NULL, 1, 10);
INSERT INTO GroupsPermissions VALUES (NULL, 1, 11);

/* Restaurant Owner Basic Permissions */
INSERT INTO GroupsPermissions VALUES (NULL, 2, 0);
INSERT INTO GroupsPermissions VALUES (NULL, 2, 1);
INSERT INTO GroupsPermissions VALUES (NULL, 2, 2);
INSERT INTO GroupsPermissions VALUES (NULL, 2, 3);
INSERT INTO GroupsPermissions VALUES (NULL, 2, 4);
INSERT INTO GroupsPermissions VALUES (NULL, 2, 5);
INSERT INTO GroupsPermissions VALUES (NULL, 2, 9);
INSERT INTO GroupsPermissions VALUES (NULL, 2, 10);
INSERT INTO GroupsPermissions VALUES (NULL, 2, 11);

/* Regular User Basic Permissions */

/*INSERT INTO GroupsPermissions VALUES (NULL, , );
INSERT INTO GroupsPermissions VALUES (NULL, , );
INSERT INTO GroupsPermissions VALUES (NULL, , );
INSERT INTO GroupsPermissions VALUES (NULL, , );
INSERT INTO GroupsPermissions VALUES (NULL, , );
INSERT INTO GroupsPermissions VALUES (NULL, , );
INSERT INTO GroupsPermissions VALUES (NULL, , );
INSERT INTO GroupsPermissions VALUES (NULL, , );
INSERT INTO GroupsPermissions VALUES (NULL, , );
INSERT INTO GroupsPermissions VALUES (NULL, , );
INSERT INTO GroupsPermissions VALUES (NULL, , );
INSERT INTO GroupsPermissions VALUES (NULL, , );
INSERT INTO GroupsPermissions VALUES (NULL, , );
INSERT INTO GroupsPermissions VALUES (NULL, , );
INSERT INTO GroupsPermissions VALUES (NULL, , );
INSERT INTO GroupsPermissions VALUES (NULL, , );
INSERT INTO GroupsPermissions VALUES (NULL, , );
INSERT INTO GroupsPermissions VALUES (NULL, , );
INSERT INTO GroupsPermissions VALUES (NULL, , );
INSERT INTO GroupsPermissions VALUES (NULL, , );
INSERT INTO GroupsPermissions VALUES (NULL, , );
INSERT INTO GroupsPermissions VALUES (NULL, , );
INSERT INTO GroupsPermissions VALUES (NULL, , );
INSERT INTO GroupsPermissions VALUES (NULL, , );
INSERT INTO GroupsPermissions VALUES (NULL, , );
INSERT INTO GroupsPermissions VALUES (NULL, , );
INSERT INTO GroupsPermissions VALUES (NULL, , );
INSERT INTO GroupsPermissions VALUES (NULL, , );
*/
