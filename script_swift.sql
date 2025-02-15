


	alter table swift_packagemaster add  [pm_stages] [varchar](255) NULL;
	alter table swift_packagemaster add  [lt_flag] [int] NULL;
	alter table swift_packagemaster add  [hold_on] [int] NULL;
    alter table swift_packagemaster add  [pm_wfid] [int] NULL;

CREATE TABLE [dbo].[swift_workflow_CurrentStage](
	[cs_packid] [int] NULL,
	[cs_projid] [int] NULL,
	[from_stage_id] [int] NULL,
	[to_stage_id] [int] NULL,
	[from_uid] [int] NULL,
	[to_uid] [int] NULL,
	[cs_active] [int] NULL,
	[from_remark] [varchar](500) NULL,
	[to_remark] [varchar](500) NULL,
	[cs_created_date] [datetime] NULL,
	[cs_userid] [int] NULL,
	[cs_expdate] [datetime] NULL,
	[cs_actual] [datetime] NULL
) ON [PRIMARY]
GO


CREATE TABLE [dbo].[swift_repository](
	[rsid] [int] NULL,
	[rs_packid] [int] NULL,
	[rs_projid] [int] NULL,
	[rs_from_stage] [int] NULL,
	[rs_to_stage] [int] NULL,
	[rs_from_uid] [int] NULL,
	[rs_to_uid] [int] NULL,
	[rs_active] [int] NULL,
	[rs_from_remark] [varchar](500) NULL,
	[rs_to_remark] [varchar](500) NULL,
	[rs_created_date] [datetime] NULL,
	[rs_userid] [int] NULL,
	[rs_expdate] [datetime] NULL,
	[rs_actual] [datetime] NULL
) ON [PRIMARY]
GO


CREATE TABLE [dbo].[Swift_Mail_Details](
	[md_id] [int] NULL,
	[md_packid] [int] NULL,
	[md_projid] [int] NULL,
	[md_date] [datetime] NULL,
	[contact_name] [varchar](max) NULL,
	[mobile_no] [varchar](max) NULL,
	[email_id] [varchar](max) NULL,
	[flag] [int] NULL,
	[deal_path] [int] NULL,
	[remark] [varchar](max) NULL,
	[send_back] [int] NULL,
	[approved_on] [datetime] NULL,
	[buyer_app] [int] NULL,
	[buyer_app_on] [datetime] NULL,
	[oem_flag] [varchar](255) NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[swift_OandM]    Script Date: 6/15/2023 2:39:58 PM ******/
SET ANSI_NULLS ON
GO

CREATE TABLE [dbo].[Swift_po_wo_Details](
	[pw_id] [int] NULL,
	[pw_packid] [int] NULL,
	[pw_projid] [int] NULL,
	[pw_date] [datetime] NULL,
	[loi_number] [varchar](max) NULL,
	[loi_date] [datetime] NULL,
	[po_no] [varchar](max) NULL,
	[po_value] [varchar](max) NULL,
	[po_date] [datetime] NULL,
	[wo_no] [varchar](max) NULL,
	[wo_date] [datetime] NULL,
	[po_wo_status] [int] NULL,
	[flag] [int] NULL,
	[po_complete] [int] NULL,
	[wo_complete] [int] NULL,
	[emr_flag] [int] NULL,
	[po_created_on] [datetime] NULL,
	[po_approved_on] [datetime] NULL,
	[wo_created_on] [datetime] NULL,
	[wo_approved_on] [datetime] NULL,
	[wo_flag] [int] NULL,
	[order_app] [int] NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO

CREATE TABLE [dbo].[swift_poentryhistory](
	[swhid] [int] NULL,
	[swh_qte] [int] NULL,
	[swh_uid] [int] NULL,
	[actions] [varchar](20) NULL,
	[h_qty] [numeric](12, 2) NULL,
	[e_date] [datetime] NULL,
	[disorder] [int] NULL
) ON [PRIMARY]
GO


CREATE TABLE [dbo].[swift_comman_uploads](
	[upid] [int] NULL,
	[up_projid] [int] NULL,
	[up_packid] [int] NULL,
	[up_uid] [int] NULL,
	[up_update] [datetime] NULL,
	[up_filename] [varchar](50) NULL,
	[up_filepath] [varchar](300) NULL,
	[upactive] [int] NULL,
	[rev] [varchar](50) NULL,
	[tclid] [int] NULL,
	[up_stage] [int] NULL,
	[key_flag] [int] NULL
) ON [PRIMARY]
GO

CREATE TABLE [dbo].[Swift_Disributor_log](
	[dl_id] [int] NULL,
	[md_id] [int] NULL,
	[dl_packid] [int] NULL,
	[dl_projid] [int] NULL,
	[dl_date] [datetime] NULL,
	[contact_name] [varchar](max) NULL,
	[mobile_no] [varchar](max) NULL,
	[email_id] [varchar](max) NULL,
	[dl_flag] [int] NULL,
	[send_back] [int] NULL,
	[remark] [varchar](max) NULL,
	[to_md_id] [int] NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO

CREATE TABLE [dbo].[Swift_Disributor_status](
	[ds_id] [int] NULL,
	[from_dist] [int] NULL,
	[to_dist] [int] NULL,
	[ds_packid] [int] NULL,
	[ds_projid] [int] NULL,
	[approved_date] [datetime] NULL,
	[ds_flag] [int] NULL,
	[remark] [varchar](max) NULL,
	[cur_md_id] [int] NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO


CREATE TABLE [dbo].[swift_distributor_files](
	[df_id] [int] NULL,
	[df_projid] [int] NULL,
	[df_packid] [int] NULL,
	[df_uid] [int] NULL,
	[df_update] [datetime] NULL,
	[df_filename] [varchar](50) NULL,
	[df_filepath] [varchar](300) NULL,
	[df_active] [int] NULL,
	[df_mail_disid] [int] NULL,
	[send_back] [int] NULL
) ON [PRIMARY]
GO


CREATE TABLE [dbo].[swift_workflow_details](
	[Did] [int] IDENTITY(1,1) NOT NULL,
	[mst_id] [int] NULL,
	[stage_id] [int] NULL,
	[active] [int] NULL,
	[created_date] [datetime] NULL,
	[userid] [int] NULL,
	[target_day] [varchar](255) NULL,
PRIMARY KEY CLUSTERED 
(
	[Did] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO


CREATE TABLE [dbo].[swift_workflow_master](
	[Id] [int] IDENTITY(1,1) NOT NULL,
	[workflow_Master] [varchar](50) NULL,
	[active] [int] NULL,
	[created_date] [datetime] NULL,
	[userid] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[Id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO