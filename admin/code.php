<?php 

include('../config/function.php');

if(isset($_POST['saveAdmin'])){
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $phone = validate($_POST['phone']);
    $is_ban = isset($_POST['is_ban']) == true ? 1:0;


    if($name != '' && $email != '' && $password != ''){
        $emailCheck = mysqli_query($conn, "SELECT * FORM admin WHERE email='$email'");
        if($emailCheck){
            if(mysqli_num_rows($emailCheck) > 0){
                redirect('admins-create.php','Email Already used by another user.');
            }
        }

        $bcrypt_password = password_hash($password, PASSWORD_BCRYPT);

        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $bcrypt_password,
            'phone' => $phone,
            'is_ban' => $is_ban
        ];
        $result = insert('admins',$data);


        if($result){
            redirect('admins.php','Admin Created Successfully!');
        }else{
            redirect('admin-create.php','Something Went Wrong!');
        }

    }else{
        redirect('admin-create.php','Please fill required fields.');
    }

}

if(isset($_POST['updateAdmin'])){

    $adminId = validate($_POST['adminId']);

    $adminData = getById('admins' ,$adminId);
    if($adminData['status'] != 200){
        redirect('admins-edit.php?id='.$adminId, 'Plese fill required fields.');
    }

    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $phone = validate($_POST['phone']);
    $is_ban = isset($_POST['is_ban']) == true ? 1:0;


    // $EmailCheckQuery = "SELECT * FROM admins WHERE email='$email' id!='$adminId'";
    // $chheckResult = mysqli_query($conn, $EmailCheckQuery);
    // if($chheckResult){
    //     if(mysqli_num_rows($chheckResult) > 0){
    //         redirect('admins-edit.php?id='.$adminId,'Email Already used by another user');
    //     }
    // }

    if($password != ''){
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    }else{
        $hashedPassword = $adminData['data']['password'];
    }


    if($name != '' && $email != ''){
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword,
            'phone' => $phone,
            'is_ban' => $is_ban
        ];
        $result = update('admins', $adminId, $data);


        if($result){
            redirect('admins-edit.php?='.$adminId,'Admin Update Successfully!');
        }else{
            redirect('admins-edit.php?='.$adminId,'Something Went Wrong!');
        }

    }else{
        redirect('admin-create.php','Please fill required fields.');
    }
}



if(isset($_POST['saveCategory'])){

    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) == true ? 1:0;

    $data = [
        'name' => $name,
        'description' => $description,
        'status' => $status
    ];
    $result = insert('categories',$data);


    if($result){
        redirect('categories.php','Category Created Successfully!');
    }else{
        redirect('categories-create.php','Something Went Wrong!');
    }

}

?>