create table servers (
	servers_id mediumint not null auto_increment,
	name char(5) not null,
	primary key (servers_id)
) engine=InnoDB default charset=latin1;

create table coord_info (
	ci_id integer not null auto_increment,
	servers_id mediumint not null,
	x int not null,
	y int not null,
	city_name varchar(15) not null,
	lord_name varchar(15) not null,
	alliance varchar(10) not null,
	status int not null,
	flag varchar(10) not null,
	honor varchar(15) not null,
	prestige varchar(15) not null,
	disposition int not null,
	primary key (ci_id),
	foreign key (servers_id) references servers(servers_id) on delete cascade
) engine=InnoDB default charset=latin1;

create unique index coord_info_idx1 on coord_info(servers_id, x, y);
create index coord_info_idx2 on coord_info(lord_name);
create index coord_info_idx3 on coord_info(alliance);
create index coord_info_idx4 on coord_info(flag);
create index coord_info_idx5 on coord_info(city_name);

create view everything as
 select servers.name, coord_info.* 
   from servers, coord_info
  where servers.servers_id = coord_info.servers_id; 

create table users ( 
	username varchar(20) NOT NULL default '', 
	password varchar(32) NOT NULL default '',
	email varchar(50) NOT NULL default ''
);
