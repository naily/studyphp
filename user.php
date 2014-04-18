<!DOCTYPE html>
<?php
	//global $dbname = "my_study" ;
	function test_dba(){
		$con = mysql_connect("localhost:3306/my_study","root","123456");
	
	if (!$con)
  {
  die('Could not connect: ' . mysql_error());
	}else{
		echo "链接成功"."success" ;
	}
}
	// some code

	//´´½¨˽¾ݿˊ
		function init_DB(){
		if (mysql_query("CREATE DATABASE ".$dbname ,$con))
	  {
	  	echo "Database created";
	  }
		else
	  {
	  	echo "Error creating database: " . mysql_error();
	  }
	}
	

	//mysql_select_db($dbname, $con);
	
function init_table(){
	$sql = "CREATE TABLE Persons 
	(
	FirstName varchar(15),
	LastName varchar(15),
	Age int
	)";
	mysql_query($sql,$con);
}
//保存数据
	function save_data(){
		$con = mysql_connect("localhost:3306/my_study","root","123456");
		mysql_select_db('my_study', $con);
		$sql="INSERT INTO users (name, pass, age)
			VALUES
		('$_POST[name]','$_POST[pass]','$_POST[age]')";
		
		if (!mysql_query($sql,$con))
		  {
		  die('Error: ' . mysql_error());
		  }
		echo "1 record added";
	}
	
	$con = mysql_connect("localhost:3306/my_study","root","123456") or die("数据库连接失败");
	mysql_select_db('my_study', $con);
	//检查插入的名字是否重复
	function check_name($name){
			global $con;
			if($con){
				$result= mysql_query("select * from users where name='".$name."'") or die("查询失败！错误是：".mysql_error());
				if(mysql_num_rows($result) > 0){
					echo("<b >".$name." ,已经存在</b>");
					return false;
				}else{
					return true;
				}
			}
			
			return false;
	}
	
	if(@$_POST["name"] && @$_POST["pass"]){
		if(check_name($_POST["name"]) ){
			save_data() ;
			}
		
	}
	
	//删除一条数据
	function remove_user($uid){
  	$sql="delete from users where id='$uid'";
  	mysql_query($sql) or die("删除失败！错误是：".mysql.error());
  	return;
	}
	
	
	//从表中提取信息的sql语句
 $sql="select * from users ";
 //执行sql查询
 $result= mysql_query($sql) or die("查询失败！错误是：".mysql_error());
 //返回多少条记录
 $count=mysql_num_rows($result); //返回多少条记录
 //mysql_close($con);
 
 $operation = @$_REQUEST["oper"];
 if(("del" == $operation) ){
 		remove_user($_REQUEST["uid"]);
 		echo "<script>location.href='user.php';</script>";
 }
 
?>

<html>
	<head>
	<meta http-equiv="content-type" content="text/html;charset=utf-8"><meta http-equiv="X-UA-Compatible" content="IE=Edge">
	</head>
<body>
<hr/>
<form action="user.php" method="post">
Firstname: <input type="text" name="name" />
password: <input type="text" name="pass" />
Age: <input type="text" name="age" />
<input name="but" type="submit" value="保存"> 
</form>

<hr/>
<h3>查询结果如下</h3>
 <p>
  <table border="1">
   <tr>
    <th>ID</th>
    <th>姓名</th>
    <th>年龄</th>
    <th>操作</th>
   </tr>
   <?php
    while($row=mysql_fetch_array($result)){  //循环出所有的数据
     echo " <tr>
       <td>".$row["id"]."</td>
       <td>".$row["name"]."</td>
       <td>".$row["age"]."</td>
       <td><a href='user.php?oper=del&uid=".$row["id"]." '>删除</a></td> 
      </tr>";
    }
   ?>
 </table>
 </p>
</body>
</html>
