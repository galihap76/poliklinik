if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[tbl_soap]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[tbl_soap]
GO

CREATE TABLE [dbo].[tbl_soap] (
	[id] [int] NOT NULL ,
	[norm] [char] (6) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
	[tanggal] [datetime] NOT NULL ,
	[dir_jpg] [varchar] (200) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL 
) ON [PRIMARY]
GO

