create table flower (
  id int auto_increment primary key not null,
  name varchar(255) unique not null,
  price real,
  description text,
  imagefile varchar(255),
  instock int not null
)
