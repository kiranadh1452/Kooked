use kooked;
create table if not exists product(
  p_id int not null unique auto_increment,
  p_name varchar(50) not null,
  price int not null,
  total_orders int default 0,
  ratings int default 0,
  date_created timestamp default current_timestamp,
  avl tinyint not null default 1,
  primary key (p_id)
);

alter table product add unique (p_name);