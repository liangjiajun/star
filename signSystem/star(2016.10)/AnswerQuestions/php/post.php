<?php 
/*
	xls表上传页面
*/
include_once('../config/config.php');
include_once'../config/excel_reader2.php';// 引用样式文件


if(isset($_FILES["file"]["name"])){
	$name = explode('.',$_FILES["file"]["name"]);
	// print_r($name);
	$gs = $name[count($name)-1];
	$name = time().'.'.$gs;
	print_r($name);
	if($gs == 'xls' or $gs == 'docx'){
		//将上传的文件移动到upload_file，并以时间戳命名
		if(move_uploaded_file($_FILES["file"]["tmp_name"],"../upload_file/" . $name)){
			mysql_query($sql="INSERT INTO answer_file (`file_name`) VALUES ('$name')");//存入file表
			$data = new Spreadsheet_Excel_Reader();//exl类的对象
			$data->setOutputEncoding('UTF-8');//文本编码  
			$data->read("../upload_file/".$name);//读取excel
			$numRows = ($data->sheets[0]['numRows']); // 行数
			$numCols = $data->sheets[0]['numCols'];   //一行几列 x为文档中的表序号， y是以下的某个参数
			$arr =$data->sheets[0]['cells']; 
			// var_dump($numRows);
			for($i=2;$i<=$numRows;$i++){
				$issueContent[] = $arr[$i][1];
				$issue1[] = $arr[$i][2];
				$issue2[] = $arr[$i][3];
				$issue3[] = $arr[$i][4];
				$issue4[] = $arr[$i][5];
				$rightIssue[] = $arr[$i][6];
				$askType[] = $arr[$i][7];
			}
			for($j=0;$j<$numRows-1;$j++){
				$issue[$j][] = $issue1[$j];
				$issue[$j][] = $issue2[$j];
				$issue[$j][] = $issue3[$j];
				$issue[$j][] = $issue4[$j];
				shuffle($issue[$j]);
				$select_issueContent="SELECT * FROM answer_question WHERE issueContent = '$issueContent[$j]' AND askType = '$askType[$j]'";
				$result=mysql_query($select_issueContent);
				$row[$j] =mysql_num_rows($result);

				$insert_questions ="INSERT INTO answer_question (`issueContent`,`issue1`,`issue2`,`issue3`,`issue4`,`rightIssue`,`askType`)VALUES(
				 	'".htmlspecialchars($issueContent[$j])."',  
				 	'".htmlspecialchars($issue[$j][0])."',
				 	'".htmlspecialchars($issue[$j][1])."',
				 	'".htmlspecialchars($issue[$j][2])."',
				 	'".htmlspecialchars($issue[$j][3])."', 
				 	'".htmlspecialchars($rightIssue[$j])."',
				 	'$askType[$j]')";
				$result=mysql_query($insert_questions);
				print_r($result);

				 header('Location:../view/addquestion.php');
			}
		}else{
				echo 'small';
				 header('Location:../view/addquestion.php');

			}
		}else{
			echo 'big';
			  header('Location:../view/addquestion.php');
		}
}
?>