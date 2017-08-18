<?php
	session_start();
	include_once('inc/db.php');
	
	if(!isset($_SESSION['role']) ||  ($_SESSION['role'] != 2 && $_SESSION['role'] != 1)){ //判断登录权限。
		echo "无权限";
		exit();
	}
	
	$id = $_GET['id'];
	$db = new db;
	$plan = $db->select_one('mark_plan',array('id'=>$id));
	
	if($plan['user_id'] != $_SESSION['id'] && $_SESSION['role'] != 2){ //项目如果不是本人，并且不是教师访问，跳回index。
		echo "不是自己是项目不允许修改";
		exit();
	}
	
	if($plan['is_teacher'] == 1 && $_SESSION['role'] != 2){ //判断是否为教师指派任务，如果是则不允许本人修改。
		echo "教师指定的项目不允许学生修改";
		exit();
	}
	
	if(!empty($_POST)){
		$data['start_date'] = $_POST['start_date'];
		$data['end_date'] = $_POST['end_date'];
		$data['content'] = $_POST['content'];
		$data['event'] = $_POST['eve'];
		$data['user_id'] = isset($_POST['user_id']) ? $_POST['user_id'] : $_SESSION['id'];
		
		$db = new db;
		$db->update('mark_plan',$data,array('id'=>$id));
		exit();
	}
?>

<label>
    <span>任务内容</span>：
    <input name="content" id="edit_content" type="text" value="<?= $plan['content']; ?>">
</label>

<?php if($_SESSION['role']==2){ ?>
<label>
    <span>指派给</span>：
    <select name="user_id" id="edit_user_id">
        <?php
            $db = new db;
            $users = $db->select('users',array('role'=>1));
			echo "<option value='".$_SESSION['id']."'>".$_SESSION['user']."</option>";
            foreach($users as $v){
				if($v['id'] == $plan['user_id']){
                	echo "<option value='".$v['id']."' selected='selected'>".$v['username']."</option>";
				}else{
					echo "<option value='".$v['id']."'>".$v['username']."</option>";
				}
            }
        ?>
    </select>
</label>
<?php } ?>

<label>
    <span>任务状态</span>：
    <select name="edit_event" id="edit_event">
        <option value="0" <?php if($plan['event']==0){echo "selected='selected'";} ?>>进程中</option>
        <option value="1" <?php if($plan['event']==1){echo "selected='selected'";} ?>>已完成</option>
        <option value="2" <?php if($plan['event']==2){echo "selected='selected'";} ?>>未完成</option>
    </select>
</label>

<label>
    <span>起始日期</span>：
    <input type="text" readonly="readonly" name="start_date" id="edit_start" value="<?= $plan['start_date'] ?>">
</label>

<label>
    <span>结束日期</span>：
    <input type="text" readonly="readonly" name="end_date" id="edit_end" value="<?= $plan['end_date'] ?>">
</label>

<input type="hidden" id="edit_id" value="<?= $plan['id']; ?>" />