drop table if exists tasks;
create table tasks (
	id int unsigned primary key auto_increment,
	task varchar(128) not null
)Engine=InnoDb;