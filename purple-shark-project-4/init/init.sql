CREATE TABLE `practice` (
	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	`date`	TEXT NOT NULL UNIQUE
);

CREATE TABLE `listserve` (
	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	`email`	TEXT NOT NULL UNIQUE
);

CREATE TABLE `member` (
	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	'ext' TEXT NOT NULL,
	`username`	TEXT NOT NULL UNIQUE,
	`password`	TEXT NOT NULL,
	`fname` TEXT NOT NULL,
	`lname` TEXT NOT NULL,
	`netid` TEXT NOT NULL UNIQUE,
	`admin` INTEGER NOT NULL
);

CREATE TABLE `member_practice` (
	`member_id`	INTEGER NOT NULL,
  `practice_id`	INTEGER NOT NULL
);

CREATE TABLE `eboard` (
	`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	`title` TEXT NOT NULL,
	`netid` TEXT NOT NULL
);

/* TODO: initial seed data */
/* These are the members. Their username and password are the netids */
INSERT INTO member (ext, username, password, fname, lname, netid, admin) VALUES ('jpg', 'as2564', '$2y$10$TsuCtdN7i6Ao5MB8OA421OT.6Sb8PdV/zBcKppV1bAqYDa8I9y8HS', 'Aditya', 'Shah', 'as2564', 0);
INSERT INTO member (ext, username, password, fname, lname, netid, admin) VALUES ('jpg', 'avm48', '$2y$10$ns3TgCArUhY.U3MnrvMDSeHidVhOeHYwAIS6Gd4gfJkPhQ4QyHc.6', 'Akhil', 'Mithal', 'avm48', 0);
INSERT INTO member (ext, username, password, fname, lname, netid, admin) VALUES ('jpg', 'aab254', '$2y$10$0sk92SBXfXWrcZC7zcXqbuNDYHtNRqU5Lic8AZ1NDEXi0fLimgp1W', 'Anders', 'Bottger', 'aab254',0 );
INSERT INTO member (ext, username, password, fname, lname, netid, admin) VALUES ('jpg', 'ac2526', '$2y$10$kiHb89OvUZzARGuAebh8DONY65BUsRXR6fK8ba8ST.io1T6z3UwvW', 'Arjun', 'Chaturvedi', 'ac2526', 0);
INSERT INTO member (ext, username, password, fname, lname, netid, admin) VALUES ('jpg', 'dh486', '$2y$10$Kj1uXOqtySJv2ccJlM8h6uO3msHsLAKw5WkJhP8JzBlkgJFNxepTK', 'Dylan', 'Hoang', 'dh486', 0);
INSERT INTO member (ext, username, password, fname, lname, netid, admin) VALUES ('jpg', 'egf26', '$2y$10$iv6tIjhp1BIHVQfXXkAoNuc4/zLislujhIZ8HphFwcxgXTDWDyO6S', 'Eric', 'Fuemmeler', 'egf26', 0);
INSERT INTO member (ext, username, password, fname, lname, netid, admin) VALUES ('jpg', 'jb967', '$2y$10$1gPzjGCCKtPvu/.tmql36en/OcU6/5N/uDeaxol4.reVfWsM6/z36', 'Jack', 'Baker', 'jb967', 0);
INSERT INTO member (ext, username, password, fname, lname, netid, admin) VALUES ('jpg', 'jvw26', '$2y$10$iFLkMOo/TMeBEhygAoBmc.SduyicZc6BGz8pIKDZgH2wuADv.3GMK', 'Jacob', 'Warfield', 'jvw26', 0);
INSERT INTO member (ext, username, password, fname, lname, netid, admin) VALUES ('jpg', 'ki79', '$2y$10$s9Dya6vKo2LIyJk5AjSyLuyI6HNgq2koH12qbNiY6UBKb9tJ2C9oi', 'Keshav', 'Iyer', 'ki79', 0);
INSERT INTO member (ext, username, password, fname, lname, netid, admin) VALUES ('jpg', 'zl247', '$2y$10$gl4BrUhfZiRSxmQZ9Cn/pu8rTcZj9VhPvjzSjbrj6WLCl3xgcGNs.', 'Kevin', 'Li', 'zl247', 0);
INSERT INTO member (ext, username, password, fname, lname, netid, admin) VALUES ('jpg', 'lpb36', '$2y$10$42/rozskJggfuKRYMinnr.G6b5EvjpglAzghJGwK49NKrsK7D59n2', 'Liam', 'Breen', 'lpb36', 0);
INSERT INTO member (ext, username, password, fname, lname, netid, admin) VALUES ('jpg', 'lct62', '$2y$10$j4OML3kBqbp.Y8vs.aSSFOwp6s67z1tBgYyaoBhUdNSrFbNXfpkAi', 'Lynette', 'Tan', 'lct62', 0);
INSERT INTO member (ext, username, password, fname, lname, netid, admin) VALUES ('jpg', 'jo299', '$2y$10$J/I6aCmK4ZbopWBUaBdwteM.o6nZ7iMKipxYNXyOn23JTBH5rjtIu', 'Peter', 'Oh', 'jo299', 0);
INSERT INTO member (ext, username, password, fname, lname, netid, admin) VALUES ('jpg', 'ssk247', '$2y$10$J1Rt4PoT1iTIyAlqcx2L4uat9TGtCGPj/RlxHW1CZakHdHXA2wYVS', 'Sam', 'Kent', 'ssk247', 0);
INSERT INTO member (ext, username, password, fname, lname, netid, admin) VALUES ('jpg', 'vsz3', '$2y$10$AO68udlQ54AYsvrnHXzi6OtKAc3bJBf/RX5cBEPxB5Nk/0UPj0AC6', 'Scott', 'Zelov', 'vsz3', 0);
INSERT INTO member (ext, username, password, fname, lname, netid, admin) VALUES ('jpg', 'sar294', '$2y$10$kdNThrTBc47udGqhoe5hqOhDOV2CReBwjL0ISYB25aXS1nvg11tsO', 'Spencer', 'Rice', 'sar294', 0);
INSERT INTO member (ext, username, password, fname, lname, netid, admin) VALUES ('jpg', 'tm447', '$2y$10$P1GiWboO3Z.94Vfk7BuKAesB0a5c1.3CAkBAIubfQQCalTMXQVwRa', 'Takamasa', 'Matsumura', 'tm447', 0);
INSERT INTO member (ext, username, password, fname, lname, netid, admin) VALUES ('jpg', 'whs222', '$2y$10$4QPG0rMMvyPn9yE9G6L9cOq5XAFliBxScZCFbHCusPtSH0J1YeTVi', 'Woody', 'Shattan', 'whs222', 0);

/* These are admins. Their username and password are their netids*/
INSERT INTO member (ext, username, password, fname, lname, netid, admin) VALUES ('jpg', 'lar294', '$2y$10$pSnGC1CnaCzc7JqaoRk0k.znPVjy4zC5cgEfEYDawCjIvLtnAGMCy', 'Leeds', 'Rising', 'lar294', 1);
INSERT INTO member (ext, username, password, fname, lname, netid, admin) VALUES ('jpg', 'as2568', '$2y$10$HMoQoZO.Ax729fby.l/gVev9jeoWLJc6v/SvaiL/AjTJry5q0A8Uy', 'Akira', 'Shindo', 'as2568', 1);
INSERT INTO member (ext, username, password, fname, lname, netid, admin) VALUES ('jpg', 'mpw72', '$2y$10$UJa0TNimFr4A/2K9Y6uGG.wnXmSexz.ny54lzZiJBLsVpDuXysu76', 'Max', 'Weiss', 'mpw72', 1);

INSERT INTO member (ext, username, password, fname, lname, netid, admin) VALUES ('png', 'ab12', '$2y$10$F2UH4ucgao1b/9Xg4vCqU.FqHphUAI8XypUvzPRxfQYXdi7kp39P2', 'For', 'Demos', 'ab12', 1 );

INSERT INTO practice (id, date) VALUES (1, 'February 4, 2018');
INSERT INTO practice (id, date) VALUES (2, 'February 6, 2018');

INSERT INTO listserve (id, email) VALUES (1, 'js12@cornell.edu');
INSERT INTO listserve (id, email) VALUES (2, 'ms99@cornell.edu');
INSERT INTO listserve (id, email) VALUES (3, 'kek42@cornell.edu');

INSERT INTO member_practice (member_id, practice_id) VALUES (1, 1);
INSERT INTO member_practice (member_id, practice_id) VALUES (1, 2);
INSERT INTO member_practice (member_id, practice_id) VALUES (2, 1);

INSERT INTO eboard (title, netid) VALUES ("President", "lar294");
INSERT INTO eboard (title, netid) VALUES ("Treasurer", "as2568");
INSERT INTO eboard (title, netid) VALUES ("Tournament Coordinator", "mpw72");
