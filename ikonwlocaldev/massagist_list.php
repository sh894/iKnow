<?php
/**
 * Created by PhpStorm.
 * User: yudu
 * Date: 10/27/15
 * Time: 11:07 PM
 */

require_once "db_func.php";

if(isset($_POST["action"])&&$_POST["action"]!=null&&isset($_POST["massaid"])&&$_POST["massaid"]!=null){
    switch ($_POST["action"]){
        case 'get_order_list':{
            if (isset($_POST["timearray"]))
                getmassagistorderlist($_POST['massaid'],$_POST["timearray"],$_POST["pagenum"]);
            else
                echo "Error: didn't give timearray attribute!";
            break;
        }

        case 'get_service_list':
            getmassagistservicelist($_POST['massaid']);
            break;
        case 'get_comment_list':
            getmassagistcommentlist($_POST['massaid'],$_POST["pagenum"]);
            break;
    }
}
else echo "Error: action or massaid is not set!";

function getmassagistorderlist($massaid,$timearray,$pagenum=null){
    $con = DBconnect();
    //$query = DBformquery_select("Order",array("orderid"),array("massaid"=>$massaid));
    //$joinquery = DBformquery_select("massagist_appt",array("starttime"))

    $perpagenum_orders=10;


    switch($timearray){
        case 'today':{
                $result = DBfetchall2($con,"massagist_appt",array("orderid","start","end","serviceid"),array("massaid"=>$massaid),null," and  to_days(start) = to_days(now())");
            break;
        }
        case 'future':{
            if($pagenum!=null){
                //每页10条
                $startpos = ($pagenum-1)*$perpagenum_orders;
                $result = DBfetchall2($con,"massagist_appt",array("orderid","start","end","serviceid"),array("massaid"=>$massaid),null," and  to_days(start) > to_days(now()) order by start desc limit $startpos , $perpagenum_orders ");
            }
            else
                $result = DBfetchall2($con,"massagist_appt",array("orderid","start","end","serviceid"),array("massaid"=>$massaid),null," and  to_days(start) > to_days(now())");
            break;
        }
        case 'history':{
            if($pagenum!=null){
                //每页10条
                $startpos = ($pagenum-1)*$perpagenum_orders;
                $result = DBfetchall2($con,"massagist_appt",array("orderid","start","end","serviceid"),array("massaid"=>$massaid),null," and  to_days(start) < to_days(now()) order by start asc limit $startpos , $perpagenum_orders ");
            }
            else
            $result = DBfetchall2($con,"massagist_appt",array("orderid","start","end","serviceid"),array("massaid"=>$massaid),null," and  to_days(start) < to_days(now())");
            break;
        }
    }
    $return = array();
    foreach($result as $row){
        //seperate the datetime to date and time
        $starttime = strtotime($row["start"]);
        $endtime = strtotime($row["end"]);
        $startdate = date('m/d/y',$starttime);
        $enddate = date('m/d/y',$endtime);
        if($startdate==$enddate)
        {
            $row['date']=$startdate;
            $row['start']=date('H:i:s',$starttime);
            $row['end']=date('H:i:s',$endtime);
        }
        else echo "Order ".$row['orderid']." have different appointment start date and end date, please check the datebase, and appointment function.";

        //get service name
        $service = DBfetchone2($con,"Service",array("name"),array("serviceid"=>$row["serviceid"]));
        $row["servicename"] = $service['name'];
        unset($row['serviceid']);

        //push into "return" list
        array_push($return, $row);
    }
    echo json_encode($return);
}

function getmassagistservicelist($massaid, $pagenum=null){


}

function getmassagistcommentlist($massaid,$pagenum=null){
    $con = DBconnect();
    $perpagenum_comments=10;

    if($pagenum!=null){
        $startpos = ($pagenum-1)*$perpagenum_comments;
        $comments = DBfetchall2($con,"Comment",array("customerid","date","stars","content","orderid"),array("massaid"=>$massaid),null,"order by date desc limit $startpos , $perpagenum_comments");
        //echo "hehe";
    }
    else $comments = DBfetchall2($con,"Comment",array("customerid","date","stars","content","orderid"),array("massaid"=>$massaid),null,"order by date desc");

    $result = array();
    foreach($comments as $comment){
        $servicename = DBfetchone2($con,"Order",array("servicename"),array("orderid"=>$comment["orderid"]));
        $comment["servicename"] = $servicename["servicename"];
        unset($comment["orderid"]);
        array_push($result,$comment);
    }

    echo json_encode($result);

}