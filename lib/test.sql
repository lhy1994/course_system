-- MySQL dump 10.13  Distrib 5.7.9, for Win64 (x86_64)
--
-- Host: localhost    Database: course_sys
-- ------------------------------------------------------
-- Server version	5.0.51b-community-nt-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Not dumping tablespaces as no INFORMATION_SCHEMA.FILES table on this server
--

--
-- Table structure for table `course_detail`
--

DROP TABLE IF EXISTS `course_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_detail` (
  `cno` int(11) NOT NULL,
  `days` int(11) NOT NULL,
  `starthour` int(11) NOT NULL,
  `hours` int(11) default NULL,
  `building` varchar(10) character set gb2312 default NULL,
  `room` int(11) default NULL,
  PRIMARY KEY  (`cno`,`days`,`starthour`),
  CONSTRAINT `fk_cde_c` FOREIGN KEY (`cno`) REFERENCES `t_course` (`Cno`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_detail`
--

LOCK TABLES `course_detail` WRITE;
/*!40000 ALTER TABLE `course_detail` DISABLE KEYS */;
INSERT INTO `course_detail` VALUES (1,3,1,3,'atest',555),(1,5,4,5,'btest',444),(2,2,2,2,'三教',204),(3,4,4,4,'经信',511),(4,3,1,3,'atest',555),(4,5,4,5,'btest',444),(5,3,1,3,'test',555),(5,3,3,5,'btest',444);
/*!40000 ALTER TABLE `course_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_admin`
--

DROP TABLE IF EXISTS `t_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_admin` (
  `Ano` int(11) NOT NULL auto_increment COMMENT '管理员号',
  `Aname` varchar(20) character set gb2312 NOT NULL COMMENT '管理员姓名',
  `Password` varchar(50) character set gb2312 default NULL COMMENT '密码',
  `Birth` date default NULL,
  `Sex` tinyint(4) default NULL,
  PRIMARY KEY  (`Ano`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_admin`
--

LOCK TABLES `t_admin` WRITE;
/*!40000 ALTER TABLE `t_admin` DISABLE KEYS */;
INSERT INTO `t_admin` VALUES (1,'刘昊源','123456','1994-12-12',1),(2,'linha','123444','1994-09-09',0),(3,'林海',NULL,'1994-11-11',0),(4,'林海',NULL,'1994-11-11',0);
/*!40000 ALTER TABLE `t_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_choose`
--

DROP TABLE IF EXISTS `t_choose`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_choose` (
  `Sno` int(8) NOT NULL COMMENT '学号',
  `Cno` int(20) NOT NULL COMMENT '课程号',
  `Score` int(11) default NULL COMMENT '成绩',
  `select_year` int(11) NOT NULL COMMENT '选课学年',
  `select_semester` int(11) NOT NULL COMMENT '选课学期',
  `teacher_score` int(11) default NULL COMMENT '教师评分',
  PRIMARY KEY  (`Sno`,`Cno`),
  KEY `Cno` (`Cno`),
  CONSTRAINT `fk_cho_c` FOREIGN KEY (`Cno`) REFERENCES `t_course` (`Cno`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cho_stu` FOREIGN KEY (`Sno`) REFERENCES `t_student` (`Sno`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_choose`
--

LOCK TABLES `t_choose` WRITE;
/*!40000 ALTER TABLE `t_choose` DISABLE KEYS */;
INSERT INTO `t_choose` VALUES (53130201,1,100,2,1,100),(53130201,3,100,1,1,NULL),(53130201,4,NULL,0,0,NULL),(53130202,1,20,2,2,NULL),(53130203,1,NULL,0,0,NULL);
/*!40000 ALTER TABLE `t_choose` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_course`
--

DROP TABLE IF EXISTS `t_course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_course` (
  `Cno` int(11) NOT NULL auto_increment COMMENT '课程号',
  `Cname` varchar(20) character set gb2312 NOT NULL COMMENT '课程名',
  `Ctype` int(11) default NULL COMMENT '课程类型',
  `Chour` int(11) default NULL COMMENT '课时',
  `Credit` int(11) default NULL COMMENT '学分',
  `Coursestart` int(11) default NULL COMMENT '开课时间',
  `Courseend` int(11) default NULL COMMENT '结课时间',
  `Price` double default NULL COMMENT '价格',
  `tno` int(11) default NULL COMMENT '任课教师',
  PRIMARY KEY  (`Cno`),
  KEY `fk_c_t_idx` (`tno`),
  CONSTRAINT `fk_c_t` FOREIGN KEY (`tno`) REFERENCES `t_teacher` (`Tno`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_course`
--

LOCK TABLES `t_course` WRITE;
/*!40000 ALTER TABLE `t_course` DISABLE KEYS */;
INSERT INTO `t_course` VALUES (1,'caozuoxitong',1,69,4,2,15,4000,531301),(2,'网页设计',1,15,2,1,12,300,531302),(3,'心理健康',2,9,1,1,8,220,531303),(4,'caozuoxitong',1,69,4,2,15,4000,531302),(5,'test',1,69,4,2,15,4000,531302);
/*!40000 ALTER TABLE `t_course` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_dept`
--

DROP TABLE IF EXISTS `t_dept`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_dept` (
  `Dno` int(11) NOT NULL auto_increment COMMENT '专业号',
  `Dept` varchar(20) character set gb2312 NOT NULL COMMENT '专业名',
  PRIMARY KEY  (`Dno`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_dept`
--

LOCK TABLES `t_dept` WRITE;
/*!40000 ALTER TABLE `t_dept` DISABLE KEYS */;
INSERT INTO `t_dept` VALUES (53,'计算机'),(54,'物联网'),(55,'软件');
/*!40000 ALTER TABLE `t_dept` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_student`
--

DROP TABLE IF EXISTS `t_student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_student` (
  `Sno` int(8) NOT NULL auto_increment COMMENT '学号',
  `Sname` varchar(20) character set gb2312 NOT NULL COMMENT '学生姓名',
  `Sex` tinyint(1) default '1' COMMENT '性别(0男1女)',
  `Birth` date default NULL COMMENT '生日',
  `Dno` int(11) default NULL COMMENT '专业号',
  `Password` varchar(50) character set gb2312 default NULL COMMENT '密码',
  PRIMARY KEY  (`Sno`),
  KEY `fk_stu_dp_idx` (`Dno`),
  CONSTRAINT `fk_stu_dp` FOREIGN KEY (`Dno`) REFERENCES `t_dept` (`Dno`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=55130102 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_student`
--

LOCK TABLES `t_student` WRITE;
/*!40000 ALTER TABLE `t_student` DISABLE KEYS */;
INSERT INTO `t_student` VALUES (53130201,'linhai',1,'1994-11-11',53,'123456'),(53130202,'刘昊源',1,'1994-12-12',53,'123456'),(53130203,'linhai',1,'1994-11-11',NULL,NULL),(53130210,'test',1,'1994-00-00',NULL,NULL),(54130201,'小海',1,'1995-01-01',54,'123456'),(55130101,'谢凯翔',1,'1995-09-09',55,'123456');
/*!40000 ALTER TABLE `t_student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_teacher`
--

DROP TABLE IF EXISTS `t_teacher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_teacher` (
  `Tno` int(6) NOT NULL auto_increment COMMENT '教师号',
  `Tname` varchar(20) character set gb2312 NOT NULL COMMENT '教师名',
  `Sex` tinyint(1) default '1' COMMENT '性别(1男0女)',
  `Prof` int(11) default NULL COMMENT '职称',
  `Sal` int(11) default NULL COMMENT '工资',
  `Birth` date default NULL COMMENT '生日',
  `Dno` int(11) default NULL COMMENT '专业号',
  `Password` varchar(50) character set gb2312 default NULL COMMENT '密码',
  `Score` int(11) default '0',
  `Evaluatenum` int(11) default '0',
  PRIMARY KEY  (`Tno`),
  KEY `fk_t_de_idx` (`Dno`),
  CONSTRAINT `fk_t_de` FOREIGN KEY (`Dno`) REFERENCES `t_dept` (`Dno`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=531307 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_teacher`
--

LOCK TABLES `t_teacher` WRITE;
/*!40000 ALTER TABLE `t_teacher` DISABLE KEYS */;
INSERT INTO `t_teacher` VALUES (531301,'teat',1,2,20000,'1990-08-08',53,'123456',100,1),(531302,'tom',0,1,2000,'1992-10-11',53,'123456',0,0),(531303,'curry',1,2,1000,'1989-11-11',53,'111111',0,0),(531304,'test',1,2,20000,'1990-08-08',NULL,NULL,0,0),(531306,'teat',1,2,20000,'1990-08-08',NULL,NULL,0,0);
/*!40000 ALTER TABLE `t_teacher` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-15 14:43:46
