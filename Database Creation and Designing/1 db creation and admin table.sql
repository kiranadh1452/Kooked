create database if not exists kooked ;
use kooked;
create table if not exists admin (
  a_id int not null auto_increment,
  adm_email varchar(60) not null unique,
  adm_pwd varchar(100) not null,
  primary key (a_id) );