<?php
//配置信息,数据库名,密码什么的
include('config.php');

#数据库操作封装类
class ConnDB
{
    var $host;
    var $user;
    var $pwd;
    var $dbname;
    var $conn;
    var $result;

    public function getSqlStmt()
    {
        return $this->sqlStmt;
    }

    public function setSqlStmt($sqlStmt)
    {
        $this->sqlStmt = $sqlStmt;
    }

    var $sqlStmt;

    public function __construct($host, $user, $pwd, $dbname)
    {
        $this->host = $host;
        $this->user = $user;
        $this->pwd = $pwd;
        $this->dbname = $dbname;
    }


    function getResult()
    {
        if (!empty($this->sqlStmt)) {
            $this->result = mysql_query($this->sqlStmt, $this->conn);
        }
    }

    function freeResult()
    {
        mysql_free_result($this->result);
    }

    function openConn()
    {
        $this->conn = mysql_connect($this->host, $this->user, $this->pwd) or die("数据库连接错误" . mysql_error());
        mysql_select_db($this->dbname, $this->conn) or die("数据库选择错误" . mysql_error());
        mysql_query("set names utf8");
    }

    function closeConn()
    {
        mysql_close($this->conn);
    }

}

//数据操作的原子性,一致性什么的你考虑

class Human
{
    public $id; //整型, 对学生8位数字,学号即能表明专业年级班级,格式同我们的学号
    //		对教师6位数字,前2位表明专业
    public $name;
    public $birthday; //字符串:yyyy-mm-dd
    public $gender;    //true->男;false->女
    public $country;    //字符串,住址信息,国家
    public $province;    //字符串,省
    public $city;    //字符串,市
    public $address;    //字符串,详细地址
    public $postCode;    //字符串,邮编
    public $phone;    //字符串,联系电话
}

class Student extends Human
{
    public $credit;    //整型,已获得的学分
}

class Teacher extends Human
{
    public $title; //整型,职称,0~3->助教~教授
    public $salary; //整型,薪水
    public $score; //教师评定得分
    public $evaluateNum; //已经评分的学生数
}

class Administrator extends Human
{

}

class CourseDetail
{
    public $day;    //整型0~6,表示星期几
    public $startHour; //整型,表示第几节
    public $hour;    //整型,表示持续几节
    public $building; //字符串,教学楼
    public $room;    //字符串,教室号
}

class Course
{
    public $id; //整型,课程id
    public $teacherId; //整型,任课老师id
    public $name; //字符串,课程名
    public $type; //整型,0->必修;1->选修;2->公选
    public $credit; //整型,学分
    public $hour; //整型,课时数
    public $startWeek; //整型,开始上课的周
    public $endWeek; //你懂的
    public $courseDetail; //CourseDetail类型的数组,表示上课时间和地点

    public $price;#课程的价格
}

class Grade
{
    public $id; //整型,课程id
    public $score; //整型,成绩
}

class ClassRoom
{
    public $building; //字符串,教学楼
    public $room;    //字符串,教室号
}

class TimePeriod
{
    public $startTime;
    public $endTime;
}

/*
验证用户
$type=0->管理员;1->教师;2->学生
$id:整型,管理员、教师、学生的id空间独立,即可以有同样的id而互不干扰,教师为教工号,学生为学号
$password:字符串
返回 true->正确;false->错误
*/
function verify($type, $id, $password)
{
    $db = new ConnDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->openConn();
    switch ($type) {
        case 0:
            $sql = "select password from t_admin where ano=$id";
            break;
        case 1:
            $sql = "select password from t_teacher where tno=$id";
            break;
        case 2:
            $sql = "select password from t_student where sno=$id";
            break;
        default:
            return false;
    }
    $db->setSqlStmt($sql);
    $db->getResult();
    $row = mysql_fetch_array($db->result);
    if ($row == false) {
        $db->closeConn();
        return false;
    } else {
        if ($row[0] == $password) {
            $db->closeConn();
            return true;
        } else {
            $db->closeConn();
            return false;
        }
    }
}

function getAllStudents()
{
	$db = new ConnDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$db->openConn();
	$sql = 'select sno from t_student';
	$db->setSqlStmt($sql);
	$db->getResult();
	$students = array();
	while($row = mysql_fetch_array($db->result))
		array_push($students, $row['sno']);
	return $students;
}

function getAllTeachers()
{
	$db = new ConnDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$db->openConn();
	$sql = 'select tno from t_teacher';
	$db->setSqlStmt($sql);
	$db->getResult();
	$teachers = array();
	while($row = mysql_fetch_array($db->result))
		array_push($teachers, $row['tno']);
	return $teachers;
}

function getAllAdmins()
{
	$db = new ConnDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$db->openConn();
	$sql = 'select ano from t_admin';
	$db->setSqlStmt($sql);
	$db->getResult();
	$admins = array();
	while($row = mysql_fetch_array($db->result))
		array_push($admins, $row['ano']);
	return $admins;
}

//根据id返回Student类,下面2个同理
function getStudentInf($id)
{
    $db = new ConnDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->openConn();
    $sql = "select * from t_student where sno=$id";
    $db->setSqlStmt($sql);
    $db->getResult();
    $row = mysql_fetch_array($db->result);
    if ($row == false) {
        $db->closeConn();
        return false;
    } else {
        $student = new Student();
        $student->id = $row["Sno"];
        $student->name = $row["Sname"];
        $student->birthday = $row["Birth"];
        $student->gender = $row["Sex"];
        $student->country = $row['country'];
        $student->province = $row['province'];
        $student->city = $row['city'];
        $student->address = $row['address'];
        $student->postCode = $row['postcode'];
        $student->phone = $row['phone'];

        $db->setSqlStmt("select sum(credit) from t_choose,t_course WHERE sno=$id and t_choose.cno=t_course.cno and score is not null");
        $db->getResult();
        $row2 = mysql_fetch_array($db->result);
        if ($row2 == false || $db->result == false) {
            $student->credit = 0;
        } else {
            if (is_null($row2[0])) {
                $student->credit = 0;
            } else {
                $student->credit = $row2[0];
            }
        }
        $db->closeConn();
        return $student;
    }
}

function getTeacherInf($id)
{
    $db = new ConnDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->openConn();
    $db->setSqlStmt("select * from t_teacher where tno=$id");
    $db->getResult();
    $row = mysql_fetch_array($db->result);
    if ($row == false) {
        $db->freeResult();
        $db->closeConn();
        return false;
    } else {
        $teacher = new Teacher();
        $teacher->id = $row["Tno"];
        $teacher->name = $row["Tname"];
        $teacher->birthday = $row["Birth"];
        $teacher->gender = $row["Sex"];
        $teacher->salary = $row["Sal"];
        $teacher->title = $row["Prof"];
        $teacher->evaluateNum = $row["Evaluatenum"];
        $teacher->score = $row["Score"];

        $teacher->country = $row['country'];
        $teacher->province = $row['province'];
        $teacher->city = $row['city'];
        $teacher->address = $row['address'];
        $teacher->postCode = $row['postcode'];
        $teacher->phone = $row['phone'];
        $db->freeResult();
        $db->closeConn();
        return $teacher;
    }
}

function getAdminInf($id)
{
    $db = new ConnDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->openConn();
    $db->setSqlStmt("select * from t_admin where ano=$id");
    $db->getResult();
    $row = mysql_fetch_array($db->result);
    if ($row == false) {
        $db->freeResult();
        $db->closeConn();
        return false;
    } else {
        $admnin = new Administrator();
        $admnin->gender = $row["Sex"];
        $admnin->birthday = $row["Birth"];
        $admnin->id = $row["Ano"];
        $admnin->name = $row["Aname"];

        $admnin->country = $row['country'];
        $admnin->province = $row['province'];
        $admnin->city = $row['city'];
        $admnin->address = $row['address'];
        $admnin->postCode = $row['postcode'];
        $admnin->phone = $row['phone'];
        $db->freeResult();
        $db->closeConn();
        return $admnin;
    }
}

//添加或更改学生信息,$student是Student类,把其信息写入$id对应的数据表中即可,下同
function setStudentInf($id, $student)
{
    $sno = $student->id;
    $name = $student->name;
    $sex = $student->gender;
    $birthday = str_replace('-', ',', $student->birthday);

    $coutry = $student->country;
    $province = $student->province;
    $city = $student->city;
    $address = $student->address;
    $postcode = $student->postCode;
    $phone = $student->phone;

    $db = new ConnDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->openConn();

    $db->setSqlStmt("select count(*) from t_student where sno=$id");
    $db->getResult();
    $row = mysql_fetch_array($db->result);
    if (!empty($row[0])) {
        $db->setSqlStmt("update t_student set sno=$sno,Sname='$name',sex=$sex,birth='$birthday',country='$coutry',province='$province',city='$city',address='$address',postcode='$postcode',phone='$phone' where sno=$id");
        $db->getResult();
        if (!$db->result) {
            $db->closeConn();
            return false;
        }
    } else {
        $db->setSqlStmt("insert into t_student(sno,sname,sex,birth,country,province,city,address,postcode,phone) values($sno,'$name',$sex,'$birthday','$coutry','$province','$city','$address','$postcode','$phone')");
        $db->getResult();
        if (!$db->result) {
            $db->closeConn();
            return false;
        }
    }
    $db->closeConn();
}

function setTeacherInf($id, $teacher)
{
    $tno = $teacher->id;
    $name = $teacher->name;
    $gender = $teacher->gender;
    $birthday = str_replace('-', ',', $teacher->birthday);
    $salary = $teacher->salary;
    $title = $teacher->title;
    $evaluateNum = $teacher->evaluateNum;
    $score = $teacher->score;

    $coutry = $teacher->country;
    $province = $teacher->province;
    $city = $teacher->city;
    $address = $teacher->address;
    $postcode = $teacher->postCode;
    $phone = $teacher->phone;

    $db = new ConnDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->openConn();

    $db->setSqlStmt("select count(*) from t_teacher where tno=$id");
    $db->getResult();
    $row = mysql_fetch_array($db->result);
    if (!empty($row[0])) {
        $db->setSqlStmt("update t_teacher set tno=$tno,tname='$name',sex=$gender,birth='$birthday',sal=$salary,prof=$title,evaluatenum=$evaluateNum,score=$score,country='$coutry',province='$province',city='$city',address='$address',postcode='$postcode',phone='$phone' where tno=$id");
        $db->getResult();
        if ($db->result == false) {
            $db->closeConn();
            return false;
        }
    } else {
        $db->setSqlStmt("insert into t_teacher(tno,tname,sex,birth,sal,prof,evaluatenum,score,country,province,city,address,postcode,phone) values($tno,'$name',$gender,'$birthday',$salary,$title,$evaluateNum,$score,'$coutry','$province','$city','$address','$postcode','$phone') ");
        $db->getResult();
        if (!$db->result) {
            $db->closeConn();
            return false;
        }
    }
    $db->closeConn();
}

function setAdminInf($id, $admin)
{
    $ano = $admin->id;
    $name = $admin->name;
    $gender = $admin->gender;
    $birthday = str_replace('-', ',', $admin->birthday);

    $coutry = $admin->country;
    $province = $admin->province;
    $city = $admin->city;
    $address = $admin->address;
    $postcode = $admin->postCode;
    $phone = $admin->phone;

    $db = new ConnDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->openConn();

    $db->setSqlStmt("select count(*) from t_admin where ano=$id");
    $db->getResult();
    $row = mysql_fetch_array($db->result);
    echo $row[0];
    if (!empty($row[0])) {
        $db->setSqlStmt("update t_admin set ano=$ano,aname='$name',sex=$gender,birth='$birthday',country='$coutry',province='$province',city='$city',address='$address',postcode='$postcode',phone='$phone' where ano=$id");
        $db->getResult();
        if (!$db->result) {
            $db->closeConn();
            return false;
        }
    } else {
        $db->setSqlStmt("insert into t_admin(ano,aname,sex,birth,country,province,city,address,postcode,phone) values($ano,'$name',$gender,'$birthday','$coutry','$province','$city','$address','$postcode','$phone')");
        $db->getResult();
        if (!$db->result) {
            $db->closeConn();
            return false;
        }
    }
    $db->closeConn();
}

//根据id删除学生信息,下面2个同理
function deleteStudentInf($id)
{
    $db = new ConnDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->openConn();
    $db->setSqlStmt("delete from t_student where sno=$id");
    $db->getResult();
    $db = new ConnDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->openConn();
    $db->setSqlStmt("delete from t_admin where ano=$id");
    $db->getResult();
    if ($db->result) {
        return true;
    } else {
        return false;
    }
}

function deleteTeacherInf($id)
{
    $db = new ConnDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->openConn();
    $db->setSqlStmt("delete from t_teacher where tno=$id");
    $db->getResult();
    $db = new ConnDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->openConn();
    $db->setSqlStmt("delete from t_admin where ano=$id");
    $db->getResult();
    if ($db->result) {
        return true;
    } else {
        return false;
    }
}

function deleteAdminInf($id)
{
    $db = new ConnDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->openConn();
    $db->setSqlStmt("delete from t_admin where ano=$id");
    $db->getResult();
    if ($db->result) {
        return true;
    } else {
        return false;
    }
}

//根据id返回Course类
function getCourseInf($id)
{
    $db = new ConnDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->openConn();
    $db->setSqlStmt("select * from t_course where cno=$id");
    $db->getResult();
    $row = mysql_fetch_array($db->result);
    if (!$row) {
        $db->closeConn();
        return false;
    } else {
        $course = new Course();
        $course->id = $row['Cno'];
        $course->name = $row['Cname'];
        $course->credit = $row['Credit'];
        $course->type = $row['Ctype'];
        $course->hour = $row['Chour'];
        $course->startWeek = $row['Coursestart'];
        $course->endWeek = $row['Courseend'];
        $course->price = $row['Price'];
        $course->teacherId = $row['tno'];

        $course->courseDetail = array();
        $db->setSqlStmt("select * from course_detail where cno=$id");
        $db->getResult();
        $row = mysql_fetch_array($db->result);
        if ($row) {
            do {
                $detail = new CourseDetail();
                $detail->hour = $row['hours'];
                $detail->startHour = $row['starthour'];
                $detail->day = $row['days'];
                $detail->building = $row['building'];
                $detail->room = $row['room'];
                array_push($course->courseDetail, $detail);
            } while ($row = mysql_fetch_array($db->result));
        }
        return $course;
    }
}

//添加或更改课程信息,$course是Course类,把其信息写入$id对应的数据表中即可
function setCourseInf($id, $course)
{
    $cno = $course->id;
    $teacherId = $course->teacherId;
    $name = $course->name;
    $type = $course->type;
    $credit = $course->credit;
    $hour = $course->hour;
    $startWeek = $course->startWeek;
    $endWeek = $course->endWeek;
    $price = $course->price;
    $courseDetail = $course->courseDetail;

    $db = new ConnDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->openConn();

    $db->setSqlStmt("select count(*) from t_course where cno=$id");
    $db->getResult();
    $row = mysql_fetch_array($db->result);
    //echo $row[0];
    if (!empty($row[0])) {
        $db->setSqlStmt("update t_course set cno=$cno,cname='$name',tno=$teacherId,ctype=$type,credit=$credit,chour=$hour,coursestart=$startWeek,courseend=$endWeek,price=$price where cno=$id");
        $db->getResult();
        if (!$db->result) {
            $db->closeConn();
            return false;
        }

        $db->setSqlStmt("delete from course_detail where cno=$id");
        $db->getResult();
        if (!$db->result) {
            $db->closeConn();
            return false;
        } else {
            foreach ($courseDetail as $item) {
                $db->setSqlStmt("insert into course_detail(cno,days,starthour,hours,building,room) values($cno,$item->day,$item->startHour,$item->hour,'$item->building',$item->room)");
                $db->getResult();
            }
        }
    } else {
        $db->setSqlStmt("insert into t_course(cno,cname,tno,ctype,credit,chour,coursestart,courseend,price) values($cno,'$name',$teacherId,$type,$credit,$hour,$startWeek,$endWeek,$price)");
        $db->getResult();
        if (!$db->result) {
            $db->closeConn();
            return false;
        }
        foreach ($courseDetail as $item) {
            $db->setSqlStmt("insert into course_detail(cno,days,starthour,hours,building,room) values($cno,$item->day,$item->startHour,$item->hour,'$item->building',$item->room)");
            $db->getResult();
        }
    }
    $db->closeConn();
}

//根据id删除课程信息
function deleteCourseInf($id)
{
    $db = new ConnDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->openConn();

    $db->setSqlStmt("delete from course_detail where cno=$id");
    $db->getResult();
    if (!$db->result) {
        $db->closeConn();
        return false;
    } else {
        $db->setSqlStmt("delete from t_course where cno=$id");
        $db->getResult();
        if (!$db->result) {
            $db->closeConn();
            return false;
        }
    }
}

//根据学生id返回Grade类型的数组,表示已上的全部课程及成绩
function getStudentFinishedCourses($id)
{
    $db = new ConnDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->openConn();

    $db->setSqlStmt("select cno,score from t_choose where sno=$id and score is not null");
    $db->getResult();
    $row = mysql_fetch_array($db->result);
    $gradeList = array();
    if ($row) {
        do {
            $grade = new Grade();
            $grade->id = $row['cno'];
            $grade->score = $row['score'];
            array_push($gradeList, $grade);
        } while ($row = mysql_fetch_array($db->result));

    }
    $db->closeConn();
    return $gradeList;
}

//根据学生id返回整型数组,表示本学期正在上的全部课程的id
function getStudentCurrentCourses($id)
{
    $db = new ConnDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->openConn();

    $db->setSqlStmt("select cno from t_choose where sno=$id and score is null");
    //$db->setSqlStmt("select cno from t_choose where sno=$id");

    $db->getResult();
    $courseList = array();
    $row = mysql_fetch_array($db->result);
    if ($row) {
        do {
            array_push($courseList, $row[0]);
        } while ($row = mysql_fetch_array($db->result));
    }
    $db->closeConn();
    return $courseList;
}

//参数均为整型,返回整数,表示学生id为$studentId的学生的课程id为$courseId的课程的分数
function getStudentScore($studentId, $courseId)
{
    $db = new ConnDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->openConn();

    $db->setSqlStmt("select score from t_choose where sno=$studentId and cno=$courseId");
    $db->getResult();
    $row = mysql_fetch_array($db->result);
    if (!empty($row)) {
        return $row[0];
    } else {
        return 0;
    }
}

//参数均为整型,无返回值,给学生id为$studentId的学生的课程id为$courseId的课程打$grade分,此课程对此学生来说变成已上课程
function setStudentScore($studentId, $courseId, $score)
{
    $db = new ConnDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->openConn();

    $db->setSqlStmt("update t_choose set score=$score where sno=$studentId and cno=$courseId");
    $db->getResult();
    if (!$db->result) {
    }
    $db->closeConn();
}

//参数均为整型,返回整数,表示学生id为$studentId的学生给课程id为$courseId的课程打的分数
function getTeacherScore($studentId, $courseId)
{
    $db = new ConnDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->openConn();

    $db->setSqlStmt("select teacher_score from t_choose where sno=$studentId and cno=$courseId");
    $db->getResult();
    $row = mysql_fetch_array($db->result);
    if (!empty($row)) {
        return $row[0];
    } else {
        return 0;
    }
}

/*
参数均为整型,无返回值
注意:每个学生只能给某教师针对某课程打一次分,但针对另一课程可再打一次分
给教师计算分数时这样算:
$teacher->score=($teacher->score*$teacher->evaluateNum+$score)/(++($teacher->evaluateNum))
*/
function setTeacherScore($studentId, $courseId, $score)
{
    $db = new ConnDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->openConn();

    $db->setSqlStmt("update t_choose set teacher_score=$score where teacher_score is null and sno=$studentId and cno=$courseId");
    $db->getResult();
    if ($db->result) {
        $num = mysql_affected_rows($db->conn);
        if ($num == 0) {
            $db->closeConn();
            return false;
        }
    } else {
        return false;
    }


    $db->setSqlStmt("select tno from t_course where cno=$courseId");
    $db->getResult();
    $row = mysql_fetch_array($db->result);
    $teacherId = $row[0];

    $db->setSqlStmt("select score,evaluatenum from t_teacher where tno=$teacherId");
    $db->getResult();
    $row = mysql_fetch_array($db->result);
    if (!$row) {
        $db->closeConn();
        return false;
    }
    $teacherscore = $row['score'];
    $evaluateNum = $row['evaluatenum'];
    $count = ($teacherscore * $evaluateNum + $score) / ($evaluateNum + 1);
    $evaluateNum++;

    $db->setSqlStmt("update t_teacher set score=$count,evaluatenum=$evaluateNum where tno=$teacherId");
    $db->getResult();
    if (!$db->result) {
        $db->closeConn();
        return false;
    }
}

//根据学生id返回整型数组,表示本学期正在上的但还未给教师打分的全部课程的id
function getNotEvaluateCourse($id)
{
    $db = new ConnDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->openConn();

    $db->setSqlStmt("select cno from t_choose where sno=$id and teacher_score is null");
    $db->getResult();
    $courseList = array();
    $row = mysql_fetch_array($db->result);
    if ($row) {
        do {
            array_push($courseList, $row[0]);
        } while ($row = mysql_fetch_array($db->result));
    }
    $db->closeConn();
    return $courseList;
}

//返回整型数组,表示本学期全部课程的id
function getCurrentCourses()
{
    $db = new ConnDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->openConn();

    $db->setSqlStmt("select cno from t_course");
    $db->getResult();
    $courseList = array();
    $row = mysql_fetch_array($db->result);
    if ($row) {
        do {
            array_push($courseList, $row[0]);
        } while ($row = mysql_fetch_array($db->result));
    }

    $db->closeConn();
    return $courseList;
}

//根据教师id返回整型数组,表示本学期教师教授的全部课程的id
function getTeacherCurrentCourse($id)
{
    $db = new ConnDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->openConn();

    $db->setSqlStmt("select cno from t_course where tno=$id");
    $db->getResult();
    $courseList = array();
    $row = mysql_fetch_array($db->result);
    if ($row) {
        do {
            array_push($courseList, $row[0]);
        } while ($row = mysql_fetch_array($db->result));
    }
    $db->closeConn();
    return $courseList;
}

//根据课程id返回整型数组,表示本学期上此课程的全部学生的id
function getCourseStudent($id)
{
    $db = new ConnDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->openConn();

    $db->setSqlStmt("select sno from t_choose where cno=$id");
    $db->getResult();

    $studentList = array();
    $row = mysql_fetch_array($db->result);
    if ($row) {
        do {
            array_push($studentList, $row[0]);
        } while ($row = mysql_fetch_array($db->result));
    }
    $db->closeConn();
    return $studentList;
}

//根据课程id返回整型数组,表示本学期上此课程但未上分的全部学生的id
function getCourseNotEvaluateStudent($id)
{
    $db = new ConnDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->openConn();

    $db->setSqlStmt("select sno from t_choose where cno=$id and score is null");
    $db->getResult();

    $studentList = array();
    $row = mysql_fetch_array($db->result);
    if ($row) {
        do {
            array_push($studentList, $row[0]);
        } while ($row = mysql_fetch_array($db->result));
    }
    $db->closeConn();
    return $studentList;
}

//无返回值,id为$studentId的学生选id为$courseId的课
function studentAddCourse($studentId, $courseId)
{
    $db = new ConnDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->openConn();

    $db->setSqlStmt("insert into t_choose(sno,cno) values($studentId,$courseId)");
    $db->getResult();
    $db->closeConn();
}

//无返回值,id为$studentId的学生退id为$courseId的课
function studentDeleteCourse($studentId, $courseId)
{
    $db = new ConnDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->openConn();

    $db->setSqlStmt("delete from t_choose where sno=$studentId and cno=$courseId");
    $db->getResult();
    $db->closeConn();
}

//返回ClassRoom类型的数组,表示第$week周,星期$day,从第$startHour节课开始,持续$hours节都没课的空教室,字符串$building为可选参数,若为空表示任意教室,否则表示特定教学楼
function getEmptyClassRoom($week, $day, $startHour, $hours, $building)
{
    $db = new ConnDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->openConn();

    $sql="select building,room from t_course,course_detail where t_course.cno=course_detail.cno and ($week not BETWEEN coursestart and courseend or $day<>days or $startHour+$hours-1<`starthour` or $startHour>hours)";
    if ($building == '') {
        $db->setSqlStmt($sql);
    } else {
        $db->setSqlStmt($sql." and building='$building'");
    }
    $db->getResult();
    //echo $db->getSqlStmt();
    if ($db->result) {
        $row = mysql_fetch_array($db->result);
        $classRoomList = array();
        do {
            $room = new ClassRoom();
            $room->building = $row['building'];
            $room->room = $row['room'];
            array_push($classRoomList, $room);
        } while ($row = mysql_fetch_array($db->result));
        $db->closeConn();
        return $classRoomList;
    }
}

function getTime()
{
    $db = new ConnDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->openConn();

    $db->setSqlStmt("select * from t_time");
    $db->getResult();

    if ($db->result) {
        $row = mysql_fetch_array($db->result);
        if ($row) {
            $time = new TimePeriod();
            $time->startTime = $row['starttime'];
            $time->endTime = $row['endtime'];
            $db->closeConn();
            return $time;
        }
    }
    $db->closeConn();
}

function setTime($time)
{
    $db = new ConnDB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->openConn();

    $startTime = str_replace('-', ',', $time->startTime);
    $endTime = str_replace('-', ',', $time->endTime);;
    $db->setSqlStmt("update t_time set starttime='$startTime',endtime='$endTime'");
    $db->getResult();
    if (!$db->result) {
        $db->closeConn();
        return false;
    }
    $db->closeConn();
}

?>