use kooked;
create table if not exists customer(
  c_id int not null unique auto_increment,
  c_name varchar(50) not null,
  c_email varchar(60) unique not null,
  c_pwd varchar(100) not null, 
  c_phn bigint not null,
  c_strt_name varchar(100) not null,
  c_strt_num int not null,
  c_act tinyint not null,
  date_created timestamp default current_timestamp,
  last_modified timestamp default current_timestamp,
  primary key (c_email)
);