
pragma encoding='UTF-8';

Drop TABLE if exists [user];

Create  TABLE [user](
	[userId] integer PRIMARY KEY AUTOINCREMENT NOT NULL
	,[email] varchar(100)
	,[username] varchar(50)
	,[password] varchar(32)
	,[oauth_provider] varchar(50)
    ,[oauth_uid] varchar(50)
    ,[oauth_username] varchar(50)
	,[firstName] varchar(30)
	,[lastName] varchar(30)
	,[website] varchar(100)
	,[createdTime] datetime NOT NULL   
);
CREATE UNIQUE INDEX [idx_email] On [user] ( [email] );
CREATE UNIQUE INDEX [idx_username] On [user] ( [username] );
