create table flower (
  id integer primary key not null,
  name text unique not null collate nocase,
  price real,
  description text,
  imagefile text,
  instock integer not null
)

