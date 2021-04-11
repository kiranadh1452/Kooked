use kooked;
create table if not exists order_table(
  o_id int not null unique auto_increment,
  o_value varchar(5000) not null,
  total int not null,
  c_id int not null,
  date_of_order timestamp default current_timestamp,
  confirmed tinyint not null,
  delivered tinyint not null,
  primary key (o_id),
  index(c_id),
  foreign key(c_id)
	references customer(c_id)
    ON UPDATE no action ON DELETE cascade
);
