use kooked;
create table if not exists employee(
  emp_id int not null unique,
  emp_name varchar(50) not null,
  emp_email varchar(60) unique not null,
  emp_pwd varchar(100) not null, 
  emp_phn bigint not null,
  emp_act tinyint not null,
  date_created timestamp default current_timestamp,
  last_modified timestamp default current_timestamp,
  primary key (emp_email)
);