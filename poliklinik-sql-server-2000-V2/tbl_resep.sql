if exists (select * from dbo.sysobjects where id = object_id(N'[dbo].[tbl_resep]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[tbl_resep]
GO

CREATE TABLE [dbo].[tbl_resep] (
	[id] [int] NOT NULL ,
	[norm] [char] (6) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
	[tanggal] [datetime] NOT NULL ,
	[file_resep] [varchar] (200) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL 
) ON [PRIMARY]
GO

