<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>客户查询结果</title>
	<link href="../1210/css/style.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="../1210/js/jquery.js"></script>

	<script type="text/javascript">
		$(document).ready(function(){
			$(".click").click(function(){
				$(".tip").fadeIn(200);
			});
			$(".tiptop a").click(function(){
				$(".tip").fadeOut(200);
			});
			$(".sure").click(function(){
				$(".tip").fadeOut(100);
			});
			$(".cancel").click(function(){
				$(".tip").fadeOut(100);
			});
		});
	</script>


<body>
	<div class="place">
		<span>位置：</span>
		<ul class="placeul">
			<li><a href="../1210/index.html">首页</a></li>
			<li><a href="javascript:history.back()">返回</a></li>
			<li><a href="#">客户查询结果</a> </li>
		</ul>
	</div>

	<div class="rightinfo">
		<div class="formtitle1"><span>客户详情</span></div>
		<table class="tablelist">
			<thead>
			<tr>
				<th>注册ID</th>
				<th>注册日期</th>
				<th>国籍</th>
				<th>历史订单</th>
			</tr>
			</thead>

			<tbody>
			<?php
			require_once '../db_func.php';
			session_start();
			$_SESSION['customer_phone'] = $_POST['ad_select_customer'];
			$con = DBconnect();
			$sql= "SELECT * FROM Customer WHERE phone = " .$_POST['ad_select_customer'] .";";
			$result = mysql_query( $sql, $con );
			while ($row = mysql_fetch_assoc($result)){
				echo "<tr>";
				echo "<td>";
				echo $row['phone'] ;
				echo "</td>" ."<td>";
				echo $row['signupdate'] ;
				echo "</td>" . "<td>" ;
				echo $row['Country'];
//				echo "</td>" ."<td>";
//				echo $row['stars'];
				echo "</td>" ;
				echo "<td>";
				?>
				<a href="ad_select_custom_order.php">订单详情</a>
			<?php
				echo "</th>" ."</tr>";
			}
			?>

			</tbody>
			</table>
		</div>
	</body>
<!---->
<?php
//require_once 'db_func.php';
//session_start();
//$_SESSION['customer_phone'] = $_POST['ad_select_customer'];
//$con = DBconnect();
//
//if ( isset( $_POST['ad_select_customer'] ) && $_POST['ad_select_customer'] != null ) {
//	get_customer_by_phone( $con, $_POST['ad_select_customer'] );
//}
//
//function get_customer_by_phone( $con, $phone ){
//	$sql= "SELECT * FROM Customer WHERE phone = '$phone'";
//	$result = mysql_query( $sql, $con );
//	echo "<center>";
//	echo "<TR>客户详情</TR>";
//	echo "<table border='1'>";
//	echo "<tr><td>PHONE</td><td>SIGNUPDATE</td><td>COUNTRY</td><td>ACTION</td><td>ODRERID</td></tr>";
//	while ( $row = mysql_fetch_assoc( $result ) ){
//	echo "<tr><td>";
//	echo $row['phone'];
//	echo "</td><td>";
//	echo $row['signupdate'];
//	echo "</td><td>";
//	echo $row['Country'];
//	echo "</td><td>";
//	?>
<!--		<a href="ad_select_custom_delete.php">删除 </a>-->
<!---->
<!--		<td>-->
<!--			<a href="ad_select_custom_order.php">订单详情</a>-->
<!--		</td>-->
<?php
//		}
//echo "</table>";
//}
//?>
<!---->
<!--<center><a href="ad_select_custm.php">返回</a> </center>-->