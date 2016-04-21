create table item (
  id integer primary key not null,
  flower_id integer not null,
  basket_id integer not null,
  quantity integer not null default 0,
  price real not null default 0,
  foreign key(flower_id) references flower(id),
  foreign key(basket_id) references basket(id),
  unique(basket_id,flower_id)
)
