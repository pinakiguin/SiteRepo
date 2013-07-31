INSERT INTO `paschimmedinipur`.`Site2014_CP_Personnel`(
`PersSL`, `off_code_cp`, `officer_nm`, `OFF_DESC`, `gender`, `BASICpay`, `mobile`, `STATUS`, `POSTING`, `OFFBLOCK_CODE`, `FORBLOCK_CODE`, `HOMEBLOCK_CODE`, `LastUpdated`, `Deleted`)
SELECT 
`PersSL`, `off_code_cp`, `officer_nm`, `OFF_DESC`, `gender`, `BASICpay`, `mobile`, `STATUS`, `POSTING`, `OFFBLOCK_CODE`, `FORBLOCK_CODE`, `HOMEBLOCK_CODE`, `LastUpdated`, `Deleted` FROM `PE2013_CP_personnel`;


INSERT INTO `paschimmedinipur`.`Site2014_CP_Posting`(`PersSL`, `AssemblyCode`, `Post`)
SELECT `PersSL`, `AssemblyCode`, `Post` FROM `PE2013_CP_Posting`;
