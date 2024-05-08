<?php 

require '../config/function.php';

$paraRestultId = checkParamId('id');
if(is_numeric($paraRestultId)){

    $adminId = validate($paraRestultId);

    $admin = getById('admins', $adminId);
    if($admin['status'] == 200){

        $adminDeleteRes = delete('admins', $adminId);
        if($adminDeleteRes){
            redirect('admins.php','Admin Deleted Successfully.');
        }else{
            redirect('admins.php','Something Went Worng.');
        }

    }else{
        redirect('admins.php',$admin['message']);
    }
}else{
    redirect('admins.php','Something Went Worng.');
}

?>