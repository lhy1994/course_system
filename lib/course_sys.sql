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
INSERT INTO `course_detail` VALUES (1,3,1,2,'逸夫楼',101),(1,5,4,2,'逸夫楼',201),(2,2,2,3,'三教',101),(3,4,4,2,'经信',501),(4,3,1,4,'萃文楼',501),(4,5,4,2,'萃文楼',401),(5,3,1,3,'逸夫楼',301),(5,3,3,2,'逸夫楼',105),(6,1,1,4,'计算机楼',101),(6,4,1,4,'逸夫楼',305),(7,4,5,4,'计算机楼',201),(8,5,1,4,'计算机楼',401),(9,5,1,4,'逸夫楼',311),(9,6,1,4,'逸夫楼',211);
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
  `country` varchar(45) default NULL,
  `province` varchar(45) default NULL,
  `city` varchar(45) default NULL,
  `address` varchar(45) default NULL,
  `postcode` varchar(45) default NULL,
  `phone` varchar(45) default NULL,
  PRIMARY KEY  (`Ano`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_admin`
--

LOCK TABLES `t_admin` WRITE;
/*!40000 ALTER TABLE `t_admin` DISABLE KEYS */;
INSERT INTO `t_admin` VALUES (1,'刘昊源','123456','1994-12-12',1,'china','neimeng','wuhai','xinhuajie','130012','18947309161'),(2,'林海','123444','1994-09-09',0,'china','guizhou','test','test','130012','18844540031'),(3,'谢凯翔','123456','1994-11-11',0,'USA','guangdong','shantou','test','100000','18844546677');
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
INSERT INTO `t_choose` VALUES (53130201,1,100,2,1,100),(53130201,2,NULL,1,1,NULL),(53130201,3,80,1,1,100),(53130201,5,NULL,3,2,NULL),(53130201,8,NULL,2,2,NULL),(53130202,1,NULL,0,0,40),(53130202,2,NULL,0,0,60),(53130202,4,NULL,2,1,NULL),(53130202,5,NULL,2,2,NULL),(53130202,7,NULL,2,1,NULL),(53130204,1,NULL,1,1,NULL),(53130204,2,80,1,1,100),(53130204,3,NULL,1,2,NULL),(53130204,4,NULL,1,1,NULL),(53130204,5,NULL,1,2,NULL),(53130204,6,NULL,1,1,NULL),(53130204,7,NULL,1,1,NULL),(53130204,8,NULL,1,2,NULL),(53130204,9,NULL,1,1,NULL),(54130201,1,80,1,2,100),(54130201,2,NULL,2,1,NULL),(54130201,3,NULL,2,1,NULL),(54130201,4,NULL,1,1,NULL),(54130201,5,NULL,1,1,NULL),(54130201,6,NULL,1,1,NULL),(54130201,8,NULL,1,1,NULL),(55130101,1,NULL,1,1,NULL),(55130101,2,NULL,1,2,80),(55130101,3,NULL,1,1,NULL),(55130101,5,NULL,1,0,NULL),(55130101,6,NULL,1,1,NULL),(55130101,7,NULL,1,1,NULL),(55130101,8,NULL,1,1,NULL),(55130101,9,NULL,1,1,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_course`
--

LOCK TABLES `t_course` WRITE;
/*!40000 ALTER TABLE `t_course` DISABLE KEYS */;
INSERT INTO `t_course` VALUES (1,'操作系统',0,69,4,2,15,4000,531301),(2,'网页设计',1,15,2,1,12,300,531302),(3,'心理健康',2,9,1,1,8,220,531303),(4,'就业指导',1,69,4,2,15,400,531302),(5,'软件工程',0,69,4,2,15,400,531302),(6,'编译原理',0,70,3,1,16,400,531303),(7,'设计模式',1,50,2,1,10,200,541301),(8,'javaEE',1,50,2,1,10,200,541301),(9,'大学语文',2,60,3,1,13,250,531301);
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
  `country` varchar(45) default NULL,
  `province` varchar(45) default NULL,
  `city` varchar(45) default NULL,
  `address` varchar(45) default NULL,
  `postcode` varchar(45) default NULL,
  `phone` varchar(45) default NULL,
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
INSERT INTO `t_student` VALUES (53130201,'林海',1,'1994-11-11',53,'123456','china','guizhou','guizhou','xinhuajie','130012','18844540031'),(53130202,'刘昊源',1,'1994-00-00',53,'123456','c','jilin','changchun','jilindaxue','130012','18844544454；，；lm\'你'),(53130203,'小海',1,'1994-11-11',53,'123456','China','jilin','changchun','jilindaxue','130012','18844546678'),(53130204,'谢凯翔',1,'1994-00-00',53,'123456','china','jilin','changchun','jilindaxue','130012','18844544454'),(54130201,'张三',0,'1995-01-01',54,'123456','China','hebei','zhengzhou','test','100222','18123123111'),(55130101,'李四',0,'1995-09-09',55,'123456','China','guangdong','guangzhou','test','130001','13302220332');
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
  `country` varchar(45) default NULL,
  `province` varchar(45) default NULL,
  `city` varchar(45) default NULL,
  `address` varchar(45) default NULL,
  `postcode` varchar(45) default NULL,
  `phone` varchar(45) default NULL,
  PRIMARY KEY  (`Tno`),
  KEY `fk_t_de_idx` (`Dno`),
  CONSTRAINT `fk_t_de` FOREIGN KEY (`Dno`) REFERENCES `t_dept` (`Dno`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=541302 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_teacher`
--

LOCK TABLES `t_teacher` WRITE;
/*!40000 ALTER TABLE `t_teacher` DISABLE KEYS */;
INSERT INTO `t_teacher` VALUES (531301,'Tom',1,2,20000,'1990-08-08',53,'123456',80,3,'china','jilin','changchun','jliindaxue','130012','18844543399'),(531302,'Jack',0,1,2000,'1992-10-11',53,'123456',80,3,'usa','test','test','test','133333','18922288888'),(531303,'curry',1,2,1000,'1989-11-11',53,'111111',100,1,'english','test','test','test','111111','21111111111'),(541301,'rose',0,3,10000,'1988-09-09',54,'123456',0,0,'china','jilin','changchun','jilindaxue','130012','18833430981');
/*!40000 ALTER TABLE `t_teacher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_time`
--

DROP TABLE IF EXISTS `t_time`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_time` (
  `starttime` date NOT NULL,
  `endtime` date NOT NULL,
  PRIMARY KEY  (`starttime`,`endtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_time`
--

LOCK TABLES `t_time` WRITE;
/*!40000 ALTER TABLE `t_time` DISABLE KEYS */;
INSERT INTO `t_time` VALUES ('2016-02-01','2016-12-01');
/*!40000 ALTER TABLE `t_time` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-22 10:55:03
