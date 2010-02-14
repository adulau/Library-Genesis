-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.0.51a-community-nt


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema bookwarrior
--

CREATE DATABASE IF NOT EXISTS bookwarrior;
USE bookwarrior;

--
-- Definition of table `moderated`
--

DROP TABLE IF EXISTS `moderated`;
CREATE TABLE `moderated` (
  `ID` int(15) unsigned NOT NULL auto_increment,
  `Title` varchar(1000) NOT NULL default '',
  `Author` varchar(300) NOT NULL default '',
  `VolumeInfo` varchar(100) NOT NULL default '',
  `Year` int(4) unsigned default NULL,
  `Edition` varchar(50) NOT NULL default '',
  `Publisher` varchar(100) NOT NULL default '',
  `Pages` varchar(100) default NULL,
  `Identifier` varchar(100) NOT NULL default '',
  `Language` varchar(150) NOT NULL,
  `Extension` varchar(50) NOT NULL default '',
  `Filesize` bigint(20) unsigned NOT NULL default '0',
  `Library` varchar(50) NOT NULL default '',
  `Issue` varchar(100) default NULL,
  `Topic` varchar(500) NOT NULL default '',
  `Generic` char(32) NOT NULL default '',
  `Exemplar` tinyint(3) unsigned NOT NULL default '1',
  `TimeAdded` timestamp NULL default NULL,
  `TimeLastModified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `Filename` char(50) NOT NULL default '',
  `Locator` varchar(333) NOT NULL default '',
  `Commentary` varchar(500) NOT NULL default '',
  `DPI` int(6) unsigned default NULL,
  `Orientation` varchar(50) NOT NULL default '',
  `Cleaned` varchar(50) NOT NULL default '',
  `Color` varchar(50) NOT NULL default '',
  `CRC32` char(8) NOT NULL default '',
  `MD2` char(32) NOT NULL default '',
  `MD4` char(32) NOT NULL default '',
  `MD5` char(32) NOT NULL,
  `eDonkey` char(32) NOT NULL default '',
  `AICH` char(32) NOT NULL default '',
  `SHA1` char(40) NOT NULL default '',
  `TTH` char(39) NOT NULL default '',
  `TIGER` char(48) NOT NULL default '',
  `Series` varchar(300) NOT NULL,
  PRIMARY KEY  (`ID`),
  UNIQUE KEY `MD5` (`MD5`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `moderated`
--

/*!40000 ALTER TABLE `moderated` DISABLE KEYS */;
INSERT INTO `moderated` (`ID`,`Title`,`Author`,`VolumeInfo`,`Year`,`Edition`,`Publisher`,`Pages`,`Identifier`,`Language`,`Extension`,`Filesize`,`Library`,`Issue`,`Topic`,`Generic`,`Exemplar`,`TimeAdded`,`TimeLastModified`,`Filename`,`Locator`,`Commentary`,`DPI`,`Orientation`,`Cleaned`,`Color`,`CRC32`,`MD2`,`MD4`,`MD5`,`eDonkey`,`AICH`,`SHA1`,`TTH`,`TIGER`,`Series`) VALUES 
 (1,'Handbook of Clinical Drug Data','','',0,'10','','1163','','English','pdf',3627486,'kolxoz','17','Biology','',1,'2009-07-20 00:45:11','2009-08-20 00:48:54','0/7b2a4d53fde834e801c26a2bab7e0240','B_Biology/Handbook of Clinical Drug Data (10th Edition)(1163s).pdf','',0,'','','','95cf2057','46e95bedb478780a39fc3be85b9261fb','8dccdac68ddd0981211c465ffcc4147e','7b2a4d53fde834e801c26a2bab7e0240','8dccdac68ddd0981211c465ffcc4147e','oqi6aind3r3ns4mox64jjdatdur4lyys','LQSVPZR6X2SYKLMTY7P5LFKBAN54CMGU','U7YPXQ3FGXNTJGGN2WGCHYYSYC3DL7FHWMCPBLY','206b53ffa0e0f19944cb8b207e0fc19d6502f6cefdf64476',''),
 (2,'Handbook of Herbs and Spices','','Volume 1',2001,'','','332','0849312175','English','pdf',1552793,'kolxoz','17','Biology','',1,'2009-07-20 00:45:11','2009-08-20 00:48:54','0/048ea0496db0444f873139cd705a07af','B_Biology/Handbook of Herbs and Spices, Volume 1 (2001)(ISBN 0849312175)(332s).pdf','',0,'','','','9a5b09ad','58917afc30be4e51760d1f7762a37e3c','c3392636e8fc3cd64d0a1225bf1a6b56','048ea0496db0444f873139cd705a07af','c3392636e8fc3cd64d0a1225bf1a6b56','dmpt7zrbpmpiqen4k5geqroge6hyzykl','GTNTUQE2EV2247FCK5V7TEJY7L3Q3N6Z','MBCITXKJGO46C64YU2IKDWQC4WN6V4RQJ4CGJ2Q','7da06d6c0e358e6e6f0bcff01a8ea229f591b81c9aa2c843',''),
 (3,'Handbook of Herbs and Spices','','Volume 2',2001,'','','374','0849325358','English','pdf',2298559,'kolxoz','17','Biology','',1,'2009-07-20 00:45:11','2009-08-20 00:48:54','0/411b9300a2f2094800e0e30d439c30fd','B_Biology/Handbook of Herbs and Spices, Volume 2 (2001)(ISBN 0849325358)(374s).pdf','',0,'','','','b0248b73','af9f7f95164417265399fd5068f24f0a','77cc1ed5df3b12a3bd7a517d68ee020a','411b9300a2f2094800e0e30d439c30fd','77cc1ed5df3b12a3bd7a517d68ee020a','ys2ztzqqikxbytmkttrs6eejy3cuh324','O3PVKPFV5O7BNREBHGOPP4E2V25COQX2','WNC4UDFJZEBVOIWQGBG2SCHTRMZE3GAKIJUXCVQ','86ec81514c0200f17bd64dd8c2f22997f02acb4748db7489',''),
 (4,'Medical terminology, an illustrated guide','Cohen B.J.','',2003,'4','','744','','English','djvu',12287946,'kolxoz','7','Biology','',1,'2009-07-20 00:45:11','2009-08-20 00:48:54','0/372e34d136fbf39dce00460d9e8f1f52','B_Biology/Medical terminology, an illustrated guide (4ed)(T)(C)(744s).djvu','',300,'','','color','88b55450','93f801a5c11770150800b32d45f00b2b','4ffc0089292da891e0edb24234cfbff1','372e34d136fbf39dce00460d9e8f1f52','6c0a25c34f2e0d61f59b40eb52298fbe','5y5qtcpj526ad7xwastpconlin67ur2k','6JWBW5SQMJACLQGKB23LNL6VLSPCGV6J','4OU7QDFU4L63266MJG5463M5ZAUELPE4RWS4ZWA','eae634f56dacef5225b325748d132cfd94c9227a172e792a',''),
 (5,'Parisiana nomina anatomica (lat,ru)','Михайлов С.С. (ред.)','',1980,'','','240','','English','djvu',4553726,'kolxoz','7','Biology','',1,'2009-07-20 00:45:11','2009-08-20 00:48:54','0/1753c32af92fa2f8de5a62fbc3805d95','B_Biology/Parisiana nomina anatomica (lat,ru)(T)(240s)_B_.djvu','',300,'','','','45e291d9','aa4ff8e47890f9a59b1022f456c6a0e8','c3c030b13b328fa68e321650a9157fae','1753c32af92fa2f8de5a62fbc3805d95','c3c030b13b328fa68e321650a9157fae','ylhn2omn2gavg3futnrqrt7hgex3bsg7','TUSMMJK5UY7MYK23QA7MLETHIPFHA44M','Z4F27JR422JMCUIDBOJNAZBHDUKFA7ET5ZJF2OY','50016b33cffa6b3148caece9b7b22353e8f57e167fecc114',''),
 (6,'Patterson\'s Allergic Diseases','','',2002,'6','','509','','English','pdf',13319483,'kolxoz','21','Biology','',1,'2009-07-20 00:45:11','2009-08-20 00:48:54','0/c086e2244ad712fe683c37c0e677b79b','B_Biology/Patterson#s Allergic Diseases (6ed, 2002)(509s).pdf','',0,'','','','08985c56','15993c93be77582ba5e9390c73353ccf','93a0647a11f4e34337bbda5ce08f5762','c086e2244ad712fe683c37c0e677b79b','2b606c96cd12ec3d2edac90abb0245ec','2a7sjyoap75jbhcv4626vtrsvwfkyb2e','B3OEBKZNIY3SOBQSI2APNCCECQ2YAD2P','D2JQG6IUIPPREEQCZ7BAUXUPPWMEIJY2OTULCVY','71f51b6113ac0dfd1128907785da1461af09d8e14ff47e9d',''),
 (7,'Poucher\'s Perfumes, Cosmetics and Soaps','','',0,'10','','820','0751404799','English','djvu',5373090,'kolxoz','17','Biology','',1,'2009-07-20 00:45:11','2009-08-20 00:48:54','0/d0d1b36d6561f74cae2a359e8bc24777','B_Biology/Poucher#s Perfumes, Cosmetics and Soaps (10th Edition)(T)(ISBN 0751404799)(820s)_B_.djvu','',300,'','','','8320e229','81229fce32d4eaf15d9e172a6d8fc968','2bfeb1d7155c8c5e996b6a2d47919cf4','d0d1b36d6561f74cae2a359e8bc24777','2bfeb1d7155c8c5e996b6a2d47919cf4','4g3eyvm6ovdgreewdmxg2tcqlvewdbjq','GAOLJLDVGEKZULWZTPHFY3TBEVUWXWIH','QVR7Q7UTGTVO3TYU6STRVRDDI23GGGRO3LWNKXA','f0825c7caf06ee2f76fdc1585b8beb56f21f79c3e182cc9f',''),
 (8,'Schaum\'s Immunology','Pinchuk G.','',2002,'','MGH','329','','English','djvu',4077170,'kolxoz','13','Biology','',1,'2009-07-20 00:45:11','2009-08-20 00:48:54','0/5f94ea5f1ebcbf82d9e46ae72bcfaa08','B_Biology/Schaum#s Immunology (MGH, 2002)(T)(C)(329s)_B_.djvu','',300,'','','color','95701411','3cdfb56fb5ad4dfe6eded76fb1dc7366','cedc7babef2c6122637ef0e42eddaeec','5f94ea5f1ebcbf82d9e46ae72bcfaa08','cedc7babef2c6122637ef0e42eddaeec','kff4k7ugvu4pldzudckhspzcuqyditz7','TB5EFQ4ERD44Q2IIBGYXP5NISVQLSITQ','FZJC4EGHNDPIJRTOP2BP6DF3WQADPADIITOMQHA','815a0615cdf57cabdc5b58fe93044537f1e14806127d2716',''),
 (9,'Survival and austere medicine: an introduction','','',2005,'2, web version','','213','','English','pdf',1940553,'kolxoz','17','Biology','',1,'2009-07-20 00:45:11','2009-08-20 00:48:54','0/eb252d785b9d104ec533cf5326d89def','B_Biology/Survival and austere medicine.. an introduction (2ed., free web version, 2005)(213s)_B_.pdf','',0,'','','','d51298fc','217d69d83d91448f76165df0bcbdce66','424f9ab00b82cab79093cff66e2fdc68','eb252d785b9d104ec533cf5326d89def','424f9ab00b82cab79093cff66e2fdc68','szytkg4wu36hdsrx6vmtfic346jwhyv4','ONY6LBSL3ZZHUPDTQ6GUERNT6MCZMA6V','SPXJLJB6LKT4WFGUBPDCFOMTBV4OPIF6X5RBYYY','7fac0c7fb030db86c36cf487e6de4b31cbfabd1db5538b3c',''),
 (10,'Чтобы спина не болела','','',1995,'','','130','','Russian','djvu',1437438,'kolxoz','17','Biology','',1,'2009-07-20 00:45:11','2009-08-20 00:48:54','0/8fcb740b8c13f202e89e05c4937c09ac','B_Biology/Chtoby spina ne bolela (1995)(ru)(T)(130s)_B_.djvu','',300,'','','','2c9abc64','e55599b4006458cf4979959537d1d815','21c0178cb281fc03b5f48d7417a23486','8fcb740b8c13f202e89e05c4937c09ac','21c0178cb281fc03b5f48d7417a23486','5e57c6sg764vvj4hxs6vxgkhnc74v3ic','SJC2XXNOSXTLLYIOU3PLVLQH6AKK4EZT','NFCR6W26E7N6Q7MNE3GV2JMZXPITYSWUNTEBSFI','3e55df4e5f4660b25b899dc520de9757d28b8f16f1b0f2df',''),
 (11,'Basic Immunology. Functions and Disorders of the Immune System','Abbas A.K., Lichtman A.H.','',2004,'2','Elsevier','323','','English','djvu',8604339,'kolxoz','13','Biology','',1,'2009-07-20 00:45:11','2009-08-20 00:48:54','0/2407ec2648233acf283de1dc726fc519','B_Biology/Abbas, Lichtman. Basic immunology (2ed., Elsevier, 2004)(T)(C)(323s)_B_.djvu','',300,'','','color','3104d600','2042ca65aca5ce8c8103d3429180e465','349e9cebdf8be9c221ce0c2b9a160b4e','2407ec2648233acf283de1dc726fc519','349e9cebdf8be9c221ce0c2b9a160b4e','dhdv7tnuff7itcogp3ecbio77ih4fw7a','X754BBUH2P7KU4UC2UZRLNEWUTPJLQPM','ERISK2GGJEZNWSZA6H6M2ZDUB6UDSDUBDRIGCPQ','baf1d65992f9bcdd2a449248471ef7a1476bbe6cf72c1aef',''),
 (12,'Textbook of Anaesthesia','Aitkenhead, et al. (eds.)','',2001,'','','821','0443063818','English','djvu',17886765,'kolxoz','21','Biology','',1,'2009-07-20 00:45:11','2009-08-20 00:48:54','0/c1bfb1e9ddcc292c605bfdc87b823b6b','B_Biology/Aitkenhead, et al. (eds.) Textbook of Anaesthesia (2001)(ISBN 0443063818)(T)(821s)_B_.djvu','',300,'','','','554159ad','edb3d9a6db5eb3a9d3a8505836a49ee5','34d3ca3e81420a0528871994c39781e7','c1bfb1e9ddcc292c605bfdc87b823b6b','20639c46cca918b5e5b08fa1ac978423','2pz3pmgm2ucqlw4p5njelim7vg2fzexp','RSNKF76AEEOGJ5ML2PABSUISQ3ATOL2I','4FTVNCYFFNZPLC4T25MNNBTA2QXQAQX3EG6WIDQ','bb681ebf7f665189479a3d97c1901a253445e04bb6255f32',''),
 (13,'Mathematical models in biology. An introduction','Allman E., Rhodes J.','',2004,'','CUP','385','','English','pdf',1341232,'kolxoz','17','Biology','',1,'2009-07-20 00:45:11','2009-08-20 00:48:54','0/d13dccac55e0f9b17c9d7ac267a96d4f','B_Biology/Allman E., Rhodes J. Mathematical models in biology. An introduction (CUP, 2004)(385s)_B_.pdf','',0,'','','','8f841a04','bd02a1be1caff863b7781426dd2d51aa','7c1d5ad12167be7674dec41494b07ec0','d13dccac55e0f9b17c9d7ac267a96d4f','7c1d5ad12167be7674dec41494b07ec0','ukymkuftc74tdeyulybuuzi5qhnvwoby','EHVA56MHMYLCELAPRQIEOAIDRBCZ7KTY','LHPY6LABOT4GRPPOLPEYTIOM5KXOCDYZ5KHHCKY','a4dc6ae9c7461b1dce8a38cab6d089b46d125f64e801d852',''),
 (14,'Mathematical models in biology: solution manual','Allman E.S., Rhodes J.A.','',2003,'draft','','81','','English','pdf',461441,'kolxoz','21','Biology','',1,'2009-07-20 00:45:11','2009-08-20 00:48:54','0/59f98a1ffbff47448335da76c11b7f51','B_Biology/Allman E.S., Rhodes J.A. Mathematical models in biology.. solution manual (draft, 2003)(81s)_B_.pdf','',0,'','','','dea38e2e','7c26e6adca034d4b282791cb7697f97d','8130a9aeb00dc1fa595a594afecb6bcc','59f98a1ffbff47448335da76c11b7f51','8130a9aeb00dc1fa595a594afecb6bcc','7qsvmkkloa7asidcfyljk7k4ifvnijwp','X6OKW5GA4SGQKGJJCGLOLJ2NXLAOUQET','XNXUTTDO6KRHQIH3CDD6TX5554FS2HMQQW2P7FQ','4cc12bec6bb77fc00b76cf8d5e0beb5858dd678f731ba3f6',''),
 (15,'Cambridge handbook of psychology, health and medicine','Ayers S., et al.','',2007,'2, book draft','CUP','968','','English','pdf',9621644,'kolxoz','17','Biology','',1,'2009-07-20 00:45:11','2009-08-20 00:48:54','0/7567387b83ff1b90fdfcda30e21dfac4','B_Biology/Ayers S., et al. Cambridge handbook of psychology, health and medicine (2ed., book draft, CUP, 2007)(968s).pdf','',0,'','','','e7b29003','f4b1dd18ad2741a766d3b9e42a406c66','f6ea14be3ea2ce0261abbf66a341fe07','7567387b83ff1b90fdfcda30e21dfac4','f6ea14be3ea2ce0261abbf66a341fe07','y3mbeqy4j6l4sfvg76etbxgd7o35xpb5','BYDEOMSODDUZAI4KJRLQV5PVIVVSJNS5','VOEJXVJNZZQIPXUWLDHL7IEMHTNYP4ZUVHULEXA','3fa93fe7c6e0b105b22139ca85973e5dc6ac31d62dd79a1c',''),
 (16,'The organic codes: an introduction to semantic biology','Barbieri M.','',2003,'','CUP','316','0521531004','English','pdf',2304145,'kolxoz','21','Biology','',1,'2009-07-20 00:45:11','2009-08-20 00:48:54','0/c60f9db2cc956af8b59b4dbbcb311b32','B_Biology/Barbieri M. The organic codes.. an introduction to semantic biology (CUP, 2003)(ISBN 0521531004)(316s)_B_.pdf','',0,'','','','3ebc743d','d6f3ca952a0dc1dab72777189558aed2','b1919377c90e5bbbcb85b032784642ab','c60f9db2cc956af8b59b4dbbcb311b32','b1919377c90e5bbbcb85b032784642ab','kplizvu6pjgqvh6jsviypu6h4sd7cx56','FKJ4HNN37PYDR2E2EYAATUDEXPZECJW2','HLXL7U3RUKBHPVQ3J4DEFJITHSRV3WNIWWHEGLA','230c86da085bb34e469250699574cd55c1491b300956d378',''),
 (17,'Comprehensive Clinical Psychology','Bellack A.S., Hersen M. (eds.)','Volume 1',2000,'','Elsevier','496','','English','pdf',6031119,'kolxoz','21','Biology','',1,'2009-07-20 00:45:11','2009-08-20 00:48:54','0/fb5d926e1b6b7ac264cb8fb11325b945','B_Biology/Bellack A.S., Hersen M. (eds.) Comprehensive Clinical Psychology. Volume 1 (Elsevier, 2000)(496s).pdf','',0,'','','','441ed15e','1c1b6b0bba48cba836f95a4209e1fc03','7bae835c547bebef00c578942137ede0','fb5d926e1b6b7ac264cb8fb11325b945','7bae835c547bebef00c578942137ede0','gsh3xzh37duudzebcec6pp6sfqzfwugy','NY2Q4SWTHKNJ57M2B3NIXVZEAS3TW7ZW','OQM4REF3UVLILFABX7PYC3WL2W3NL6DLUHIKJ5Q','da16776514a58462e29255b946928b7f2e3e487b5954b58b',''),
 (18,'Comprehensive Clinical Psychology','Bellack A.S., Hersen M. (eds.)','Volume 10',2000,'','Elsevier','364','','English','pdf',5266517,'kolxoz','21','Biology','',1,'2009-07-20 00:45:11','2009-08-20 00:48:54','0/21037dfaccccfa032bae7a257992f37b','B_Biology/Bellack A.S., Hersen M. (eds.) Comprehensive Clinical Psychology. Volume 10 (Elsevier, 2000)(364s).pdf','',0,'','','','9beae865','872db0b27caf3e8368d62a151becebf3','2218b9468fa3bf3d176e59872472069a','21037dfaccccfa032bae7a257992f37b','2218b9468fa3bf3d176e59872472069a','66lqafr66dh2hmffhcv34gjgv5whbm3h','O3UEVWYD4MES5UAIWZCB2SLUFN4TH2ZD','QCO5CJ6JDR7RGKDOB5GRCNZ6UKZVOMXRWEW7FCA','ddfe776b8836157c71743fdf4ab07ed111d27db78cccf19f',''),
 (19,'Comprehensive Clinical Psychology','Bellack A.S., Hersen M. (eds.)','Volume 3',2000,'','Elsevier','368','','English','pdf',5492255,'kolxoz','21','Biology','',1,'2009-07-20 00:45:11','2009-08-20 00:48:54','0/8d6d3a29a42a00336f8df0ff32496e10','B_Biology/Bellack A.S., Hersen M. (eds.) Comprehensive Clinical Psychology. Volume 3 (Elsevier, 2000)(368s).pdf','',0,'','','','a8449fb1','6b395f095919580f469584e409fc707b','2c6f56256d21892a40e81d0dffe99a3c','8d6d3a29a42a00336f8df0ff32496e10','2c6f56256d21892a40e81d0dffe99a3c','omus5sjznlqn4ux5rv37nthnedipy2f4','PFQJTMYRN5BBT4SEAQI5R2MS7ZHJAZFA','QI3F2RARKJZKP7PNVGUKCUECYQ3VUON3KEXLSPY','8ffd84c690a358a64d882db19351e7101412bbb545da971b',''),
 (20,'Comprehensive Clinical Psychology','Bellack A.S., Hersen M. (eds.)','Volume 4',2000,'','Elsevier','599','','English','pdf',7272758,'kolxoz','21','Biology','',1,'2009-07-20 00:45:11','2009-08-20 00:48:54','0/6a55404956bf0abbd6ae5b6bcd4f942b','B_Biology/Bellack A.S., Hersen M. (eds.) Comprehensive Clinical Psychology. Volume 4 (Elsevier, 2000)(599s).pdf','',0,'','','','f1a5c162','9317782c16d1bcccf7b816bb965093fa','6df4709dabf02f0046190cf05d4c3c9d','6a55404956bf0abbd6ae5b6bcd4f942b','6df4709dabf02f0046190cf05d4c3c9d','ejgqd2pawanbdmrtu55icogw4rrvz36x','QM6F2LS2KGQJFKUMTWRSJ46TFIRKYLDA','DV3A35LOLYYKYZNBZSU7NB7EMHFML5AVWQT54LI','974fadf5ddafc62350587c25de88dfb8a74d2b4af6bbd58d','');
/*!40000 ALTER TABLE `moderated` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
