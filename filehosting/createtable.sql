use filehost;

drop table if exists jeeteshm;
drop table if exists users;

CREATE TABLE users(
userid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
username varchar(255) NOT NULL,
password varchar(255) NOT NULL);


insert into users values(0, "jeeteshm", "nothing");

insert into users values(0, "harshitm", "pandey");

CREATE TABLE jeeteshm (
inode INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
name varchar(255) NOT NULL DEFAULT 'Untitled',
filedir char(1),
size BIGINT UNSIGNED DEFAULT 0,
mime varchar(32) DEFAULT "text/plain",
parent INT UNSIGNED NOT NULL,
data MEDIUMBLOB,
uploaded TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
downloaded TIMESTAMP,
downloads INT UNSIGNED NOT NULL,
downloadable char(4));

INSERT INTO jeeteshm VALUES( 0, "home", 'd', 0, NULL, 0, NULL, NOW(), NULL, 0, "NA");
insert into jeeteshm values(0, "sem 1", 'd', 0, NULL, 1, NULL, NOW(), NULL, 0, "NA");
insert into jeeteshm values(0, "sem 2", 'd', 0, NULL, 1, NULL, NOW(), NULL, 0, "NA");
insert into jeeteshm values(0, "sem 3", 'd', 0, NULL, 1, NULL, NOW(), NULL, 0, "NA");
insert into jeeteshm values(0, "sem 4", 'd', 0, NULL, 1, NULL, NOW(), NULL, 0, "NA");
insert into jeeteshm values(0, "sem 5", 'd', 0, NULL, 1, NULL, NOW(), NULL, 0, "NA");
insert into jeeteshm values(0, "sem 6", 'd', 0, NULL, 1, NULL, NOW(), NULL, 0, "NA");
insert into jeeteshm values(0, "sem 7", 'd', 0, NULL, 1, NULL, NOW(), NULL, 0, "NA");
insert into jeeteshm values(0, "cs425", 'd', 0, NULL, 6, NULL, NOW(), NULL, 0, "NA");
insert into jeeteshm values(0, "cs302", 'd', 0, NULL, 6, NULL, NOW(), NULL, 0, "NA");
insert into jeeteshm values(0, "cs330", 'd', 0, NULL, 6, NULL, NOW(), NULL, 0, "NA");
insert into jeeteshm values(0, "cs340", 'd', 0, NULL, 6, NULL, NOW(), NULL, 0, "NA");
insert into jeeteshm values(0, "cs350", 'd', 0, NULL, 6, NULL, NOW(), NULL, 0, "NA");
insert into jeeteshm values(0, "phi455", 'd', 0, NULL, 6, NULL, NOW(), NULL, 0, "NA");
INSERT INTO jeeteshm VALUES( 0, "home", 'd', 0, NULL, 0, NULL, NOW(), NULL, 0, "NA");
insert into jeeteshm values(0, "sem 1", 'd', 0, NULL, 1, NULL, NOW(), NULL, 0, "NA");
insert into jeeteshm values(0, "sem 2", 'd', 0, NULL, 1, NULL, NOW(), NULL, 0, "NA");
insert into jeeteshm values(0, "sem 3", 'd', 0, NULL, 1, NULL, NOW(), NULL, 0, "NA");
insert into jeeteshm values(0, "sem 4", 'd', 0, NULL, 1, NULL, NOW(), NULL, 0, "NA");
insert into jeeteshm values(0, "sem 5", 'd', 0, NULL, 1, NULL, NOW(), NULL, 0, "NA");
insert into jeeteshm values(0, "sem 6", 'd', 0, NULL, 1, NULL, NOW(), NULL, 0, "NA");
insert into jeeteshm values(0, "sem 7", 'd', 0, NULL, 1, NULL, NOW(), NULL, 0, "NA");
insert into jeeteshm values(0, "cs425", 'd', 0, NULL, 6, NULL, NOW(), NULL, 0, "NA");
insert into jeeteshm values(0, "cs302", 'd', 0, NULL, 6, NULL, NOW(), NULL, 0, "NA");
insert into jeeteshm values(0, "cs330", 'd', 0, NULL, 6, NULL, NOW(), NULL, 0, "NA");
insert into jeeteshm values(0, "cs340", 'd', 0, NULL, 6, NULL, NOW(), NULL, 0, "NA");
insert into jeeteshm values(0, "cs350", 'd', 0, NULL, 6, NULL, NOW(), NULL, 0, "NA");
insert into jeeteshm values(0, "phi455", 'd', 0, NULL, 6, NULL, NOW(), NULL, 0, "NA");
insert into jeeteshm values(0, "filehost project", 'f', 0, NULL, 9, NULL, NOW(), NULL, 0, "yes");
insert into jeeteshm values(0, "network design project", 'f', 0, NULL, 9, NULL, NOW(), NULL, 0, "yes");
