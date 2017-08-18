<?php 

include('../config/config.php');

$sql = "SELECT * FROM users WHERE role = '0'";
$r = mysql_query($sql);
$users = array();
while ($row  = mysql_fetch_assoc($r)){
	$users[] = $row["username"];
}

//print_r($users);



//type
$sql  ="SELECT * FROM answer_type";
$r  = mysql_query($sql);

$arr = array();
$i = 0;
while ($type = mysql_fetch_assoc($r)){
	$arr[$i]['name'] = trim($type['type']);
	$arr[$i]['type'] = 'line';
	$arr[$i]['data'] = "";

	foreach( $users as $value){

		
		$sql = "SELECT score FROM answer_results WHERE respondents = '$value' AND answer_type = '".$arr[$i]['name'] ."' ORDER BY id desc LIMIT 1";
		$r2 = mysql_query($sql);
		$score = mysql_fetch_assoc($r2);	
		$score = $score['score']?$score['score']:0;
		$score = 1*($score);
			
		$arr[$i]['data'][] = $score;

	}
	
	//人
	//$sql ="SELECT distinct `respondents` FROM results WHERE type = '".$type['type']."' ORDER BY id DESC";
	//$sql = "SELECT id,respondents,sorce FROM results WHERE id IN(SELECT MAX(id) FROM results GROUP BY respondents) order by id desc";
	//多个字段不重复

	// $r = mysql_query($sql);
	// while($people = mysql_fetch_assoc($r)){
	// 	$sql  = "";
	// }




	
	$i++;
}

// print_r($arr);
echo json_encode($arr);








//
/*$sql = "SELECT `score` FROM results WHERE";



$row = mysql_query($sql);
$array =array();
while($r =mysql_fetch_assoc($row)){
	$array[] = $r;
}
*/
// echo json_encode($array);


   // {
   //          name:'PS',
   //          ata:'line',
   //          data:[0,0,0,0,0,0,0,0,0,0,0,90]
   // //      },
   //    {
   //          name:'HTML',
   //          type:'line',
   //          data:[20, 30]
   //      },
   //         {
   //          name:'CSS',
   //          type:'line',
   //          data:[100]
   //      },

 		// {
   //          name:'PHP',
   //          type:'line',
   //          data:[]
   //      },
   //      {
   //          name:'HTML5',
   //          type:'line',
   //          data:[]
   //      },
   //      {
   //          name:'CSS3',
   //          type:'line',
   //          data:[]
   //      }