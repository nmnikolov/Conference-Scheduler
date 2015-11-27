DROP DATABASE IF EXISTS `Conference_Scheduler`;

-- Task 1
CREATE DATABASE IF NOT EXISTS `Conference_Scheduler`  
CHARACTER SET utf8 
COLLATE utf8_general_ci;

SHOW databases like "Conference_Scheduler";

USE `Conference_Scheduler`;

CREATE TABLE `users` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username NVARCHAR(255) NOT NULL UNIQUE,
    password NVARCHAR(255) NOT NULL);    
    
CREATE TABLE `roles` (
	id INT AUTO_INCREMENT PRIMARY KEY,
    rolename NVARCHAR(255) NOT NULL UNIQUE);
    
CREATE TABLE `user_roles` (
    user_id INT NOT NULL,
    role_id int NOT NULL,
    PRIMARY KEY (user_id, role_id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (role_id) REFERENCES roles(id));    
    
select * from users;
select * from roles;
select * from user_roles;

USE `Conference_Scheduler`;
describe users;
describe roles;
describe user_roles;

drop table user_roles;
drop table users;
drop table roles;

delete from users;
delete from roles;

show tables;

select 
	u.id
from userRoles as ur
join users as u
	on ur.user_id = u.id
join roles as r
	on ur.role_id = r.id
where r.rolename = 'admin' AND u.id = 2;

select id from users
where username = 'admin';
    
select id from roles
where rolename = 'User';

show tables like 'users';

