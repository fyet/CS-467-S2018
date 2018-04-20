-- Drop tables if they exist
DROP TABLE IF EXISTS `award`;
DROP TABLE IF EXISTS `user`;
DROP TABLE IF EXISTS `recipient`;
DROP TABLE IF EXISTS `branch`;
DROP TABLE IF EXISTS `manager`;

-- Create a table called user with the following properties:
-- user_id - an auto incrementing integer which is the primary key
-- f_name - a varchar with a maximum length of 255 characters
-- l_name - a varchar with a maximum length of 255 characters
-- email - a varchar with a maximum length of 255 characters
-- psword - a varchar with a maximum length of 255 characters
-- creation_date - a date type (http://dev.mysql.com/doc/refman/5.0/en/datetime.html)
-- signature - a BLOB type 
-- account_type - a varchar with a maximum length of 255 characters
-- last_change - a date type
CREATE TABLE user (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  f_name VARCHAR(255),
  l_name VARCHAR(255),
  email VARCHAR(255),
  psword VARCHAR(255),  
  creation_date DATE,
  signature BLOB, 
  account_type VARCHAR(255),
  last_change DATE,
  PRIMARY KEY  (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create a table called branch with the following properties:
-- id - an auto incrementing integer which is the primary key
-- name - a varchar with a maximum length of 255 characters
-- state_location - a varchar with a maximum length of 255 characters
CREATE TABLE branch (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT, 
  name VARCHAR(255),
  state_location VARCHAR(255),   
  PRIMARY KEY  (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create a table called manager with the following properties:
-- id - an auto incrementing integer which is the primary key
-- f_name - a varchar with a maximum length of 255 characters
-- l_name - a varchar with a maximum length of 255 characters
-- department_name - a varchar with a maximum length of 255 characters
CREATE TABLE manager (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT, 
  f_name VARCHAR(255),
  l_name VARCHAR(255),
  department_name VARCHAR(255),   
  PRIMARY KEY  (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create a table called recipient with the following properties:
-- id - an auto incrementing integer which is the primary key
-- email - a varchar with a maximum length of 255 characters
-- f_name - a varchar with a maximum length of 255 characters
-- l_name - a varchar with a maximum length of 255 characters
-- branch_id - an integer which is a foreign key reference to the branch table
-- manager_id - an integer which is a foreign key reference to the manager table
-- job_title - a varchar with a maximum length of 255 characters
-- salary - an integer
-- hire_date - a date type
-- the email should be unique in this table
CREATE TABLE recipient (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  email VARCHAR(255),  
  f_name VARCHAR(255),
  l_name VARCHAR(255),
  branch_id INT UNSIGNED NOT NULL,
  manager_id INT UNSIGNED NOT NULL,
  job_title VARCHAR(255), 
  salary INT UNSIGNED,  
  hire_date DATE,    
  PRIMARY KEY  (id),
  CONSTRAINT `uq_recipient` UNIQUE(email),
  CONSTRAINT `fk_recipient_branch_id` FOREIGN KEY (branch_id) REFERENCES branch (id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_recipient_manager_id` FOREIGN KEY (manager_id) REFERENCES manager (id) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create a table called award with the following properties:
-- id - an auto incrementing integer which is the primary key
-- accolade_date - a date type
-- accolade_type - a varchar with a maximum length of 255 characters
-- user_id - an integer which is a foreign key reference to the user table
-- certificate - a BLOB type 
-- recipient_id - a foreign key to the recipient table 
CREATE TABLE award (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  accolade_date DATE,
  accolade_type VARCHAR(255),
  user_id INT UNSIGNED NOT NULL,
  certificate BLOB, 
  recipient_id INT UNSIGNED NOT NULL,
  PRIMARY KEY  (id),
  CONSTRAINT `fk_award_user_id` FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_award_recipient_id` FOREIGN KEY (recipient_id) REFERENCES recipient (id) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- insert test data into our tables:

-- users table test data --
INSERT INTO user (f_name, l_name, email, psword,creation_date,account_type)
VALUES ('Michael','Scott','mscott@dundermifflin.com','worldsbestboss','2012-01-02','standard');

INSERT INTO user (f_name, l_name, email, psword,creation_date,account_type)
VALUES ('Dwight','Schrute','dschrute@dundermifflin.com','assistant2themanager','2012-03-02','standard');

INSERT INTO user (f_name, l_name, email, psword,creation_date,account_type)
VALUES ('Jim','Halpert','jhalpert@dundermifflin.com','1234','2012-03-02','standard');

INSERT INTO user (f_name, l_name, email, psword,creation_date,account_type)
VALUES ('Angela','Martin','amartin@dundermifflin.com','cats','2012-01-02','standard');

INSERT INTO user (email, psword,creation_date,account_type)
VALUES ('tflenderson@dundermifflin.com','humanResources','2012-01-02','admin');

-- branch table test data --
INSERT INTO branch (name,state_location)
VALUES ('Scranton Branch','PA');

-- manager table test data --
INSERT INTO manager (f_name, l_name, department_name)
VALUES ('Michael','Scott','Sales');

-- recipient table test data --
INSERT INTO recipient (email, f_name, l_name, branch_id, manager_id, job_title, salary, hire_date)
SELECT 
'shudson@dunermifflin.com' as email,
'Stanley' as f_name,
'Hudson' as l_name,
(SELECT id FROM branch WHERE name='Scranton Branch') as branch_id,
(SELECT id FROM manager WHERE f_name='Michael' AND l_name='Scott') as manager_id,
'Sales representative' as job_title, 
'50000' as salary, 
'2018-01-02' as hire_date;

INSERT INTO recipient (email, f_name, l_name, branch_id, manager_id, job_title, salary, hire_date)
SELECT 
'abernard@dunermifflin.com' as email,
'Andy' as f_name,
'Bernard' as l_name,
(SELECT id FROM branch WHERE name='Scranton Branch') as branch_id,
(SELECT id FROM manager WHERE f_name='Michael' AND l_name='Scott') as manager_id,
'Sales representative' as job_title, 
'50000' as salary, 
'2018-01-02' as hire_date;

INSERT INTO recipient (email, f_name, l_name, branch_id, manager_id, job_title, salary, hire_date)
SELECT 
'pbeesly@dunermifflin.com' as email,
'Pam' as f_name,
'Beesly' as l_name,
(SELECT id FROM branch WHERE name='Scranton Branch') as branch_id,
(SELECT id FROM manager WHERE f_name='Michael' AND l_name='Scott') as manager_id,
'Receptionist' as job_title, 
'45000' as salary, 
'2018-01-02' as hire_date;

-- award table test data --
INSERT INTO award (accolade_date, accolade_type, user_id, recipient_id)
SELECT 
'2018-01-02' as accolade_date,
'Employee of the Month' as accolade_type,
(SELECT id FROM user WHERE email='jhalpert@dundermifflin.com') as user_id,
(SELECT id FROM recipient WHERE email='pbeesly@dunermifflin.com') as recipient_id;

INSERT INTO award (accolade_date, accolade_type, user_id, recipient_id)
SELECT 
'2018-02-02' as accolade_date,
'Employee of the Month' as accolade_type,
(SELECT id FROM user WHERE email='mscott@dundermifflin.com') as user_id,
(SELECT id FROM recipient WHERE email='abernard@dunermifflin.com') as recipient_id;

INSERT INTO award (accolade_date, accolade_type, user_id, recipient_id)
SELECT 
'2018-03-02' as accolade_date,
'Employee of the Month' as accolade_type,
(SELECT id FROM user WHERE email='amartin@dundermifflin.com') as user_id,
(SELECT id FROM recipient WHERE email='shudson@dunermifflin.com') as recipient_id;