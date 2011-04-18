
PRAGMA ENCODING='UTF-8';

DROP TABLE IF EXISTS [user];
CREATE TABLE [user](
	[userId] INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	[email] varchar(100),
	[username] VARCHAR(50),
	[password] VARCHAR(32),
	[oauth_provider] VARCHAR(50),
    [oauth_uid] VARCHAR(50),
    [oauth_username] VARCHAR(50),
	[firstName] VARCHAR(30),
	[lastName] VARCHAR(30),
	[website] VARCHAR(200),
	[createTime] DATETIME NOT NULL
);
CREATE UNIQUE INDEX [idx_email] ON [user] ( [email] );
CREATE UNIQUE INDEX [idx_username] ON [user] ( [username] );

DROP TABLE IF EXISTS [post];
CREATE TABLE [post] (
  [postId] INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  [authorId] INTEGER CONSTRAINT [fk_authorId_userId] REFERENCES [user]([userId]), 
  [title] VARCHAR(200) NOT NULL,   
  [description] VARCHAR(500),
  [content] TEXT,
  [allowComment] INTEGER, 
  [updateTime] DATETIME, 
  [createTime] DATETIME NOT NULL
);
CREATE INDEX [idx_authorId] ON [post] ([authorId]);

DROP TABLE IF EXISTS [comment];
CREATE TABLE [comment] (
  [commentId] INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  [type] smallint NOT NULL,
  [itemId] INTEGER NOT NULL,
  [replyToId] INTEGER,
  [weight] DOUBLE NOT NULL,
  [title] VARCHAR(200),
  [content] TEXT,
  [authorName] VARCHAR(50),
  [authorEmail] VARCHAR(100),
  [authorURL] VARCHAR(200),
  [authorIP] VARCHAR(40),
  [point] INTEGER,
  [isApproved] INTEGER,
  [updateTime] DATETIME,
  [createTime] DATETIME NOT NULL
);
