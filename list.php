<?php
function userlist(){
	
	$con = mysql_connect("localhost:3306/my_study","root","123456") or die("数据库连接失败");
	mysql_select_db('my_study', $con);
	$sql="select * from users ";
	 //执行sql查询
	 $result= mysql_query($sql) or die("查询失败！错误是：".mysql_error());
	 
	 // iterate over every row
    while ($row = mysql_fetch_assoc($result)) {
        // for every field in the result..
        for ($i=0; $i < mysql_num_fields($result); $i++) {
            $info = mysql_fetch_field($result, $i);
            $type = $info->type;

            // cast for real
            //echo "<p>$type  , ".$row[$info->name];
            if ($type == 'string')
                $row[$info->name] = strval($row[$info->name]);
            // cast for int
            if ($type == 'int')
                $row[$info->name] = intval($row[$info->name]);
        }

        $rows[] = $row;
    }

	 $jsonstr = json_encode($rows) or die(json_last_error());
	 echo $jsonstr;
	 return $jsonstr;
	}
userlist();
?>
