<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="style/style.css">
</head>
<body>
	<?php 
		include_once '../top.php';
		$user_new = new user();
		$user_all = $user_new->getUsers();
		if(isset($_SESSION['user'])){
			$user = $user_new->getUser($_SESSION['id']);
		}
	?>

	<section class="skillstree">
		<svg id="skills" width="75%" height="100%">
            <g id="overall">
                <g id="line"></g>
            </g>
        </svg>
        <div class="oper">
            <div class="padd">
                <select class="user_list">
                    <?php foreach($user_all as $v){
                        if( $_SESSION['id'] == $v['id']){
                            echo "<option value='$v[id]' selected>$v[username]</option>";
                        }else{
                            echo "<option value='$v[id]'>$v[username]</option>";
                        }
                    }?>
                </select>
            </div>
            
		<?php if (isset($user) && $user['role'] > 0) {?>
        
            <div class="padd">
                <div class="list">
                    <table width="100%">
                        <tr></tr>
                    </table>
                </div>
            </div>
            <div class="padd">
                <h3 class="h3 rad_5 blue">Insert Label</h3>
                <div class="enter padd">
                    <div id="label" class="block rad_5 input" contenteditable="true">Title</div>
                    <textarea id="content" class="block rad_5 input" contenteditable="true">Content</textarea>
                    <button class="add rad_5 block btn yellow">Insert</button>
                </div>
            </div>
            <div class="padd">
                <h3 class="h3 rad_5 blue">Update Label</h3>
                <div class="enter padd">
                    <div id="label2" class="block rad_5 input" contenteditable="true">Title</div>
                    <textarea id="content2" class="block rad_5 input" contenteditable="true">Content</textarea>
                    <button class="edit rad_5 block btn yellow">Update</button>
                </div>
            </div>
            <div class="padd">
                <div class="enter">
                    <button class="del rad_5 block btn red">Delete</button>
                </div>
            </div>
            
		<?php }elseif (isset($user) && $user['role'] == 0) {?>
        
            <div class="padd">
                <div class="enter">
                    <button class="request rad_5 block btn yellow">申请通过</button>
                </div>
            </div>
            <div class="padd">
                <div class="content"></div>
            </div>
            
		<?php }else{?>
        
            <div class="padd">
                <div class="content"></div>
            </div>
            
        <?php }?>
        </div>
	</section>


<script src="script/jquery-1.11.3.min.js"></script>
<script src="script/tree.js"></script>

</body>
</html>