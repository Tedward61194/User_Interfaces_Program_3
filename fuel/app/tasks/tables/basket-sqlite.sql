create table basket (
  id integer primary key not null,
  member_id integer not null,
  made_on datetime not null,
  foreign key(member_id) references member(id)
)
