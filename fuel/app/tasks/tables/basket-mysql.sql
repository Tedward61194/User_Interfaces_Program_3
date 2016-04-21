create table basket (
  id integer auto_increment primary key not null,
  member_id int not null,
  made_on datetime not null,
  foreign key(member_id) references member(id)
)
