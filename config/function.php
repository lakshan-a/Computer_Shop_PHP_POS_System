<?php 


session_start();

require 'dbcon.php';


//Input filed validation
function validate($inputData){

    global $conn;
    $validatedData = mysql_real_escape_string($conn, $inputData);
    return trim($validatedData);
}
 
//Redirect from 1 page to another page with the message
function redirect($url, $status){
    $_SESSION['status'] = $status;
    header('Location: '.$url);
    exit(0);
}

// Display message or status after any process
function alertMessage(){
    if(isset($_SESSION['status'])){
        each '<div class="alert alert-warning alert-dismissible fade show" role="alert">
         <h6>'.$_SESSION['status'].'</h6>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        unset($_SESSION['status']);
    }
}

// Insert record using this function
function insert($tableName, $data){

    global $conn;

    $table = validate($tableName);

    $columns = array_keys($data);
    $values = array_values($data);

    $finalColumn = implode(',', $columns);
    $finalValues = "'" .implode("','", $values)."'";

    $query = "INSERT INTO $table ($finalColumn) VALUES ($finalValues)";
    $result = mysqli_query($conn,$query);
    return $result;
}

//Update data using this function
function update($tableName ,$id ,$data){

    global $conn;

    $table = validate($tableName);
    $id = validate($id);

    $updateDataString = "";

    foreach($data as $column =>$value){
        $updateDataString .= $column. '='."'$value',";
    }

    $finalUpdateData = substr(trim($updateDataString),0,-1);

    $query = "UPDATE $table SET $finalUpdateData WHERE id='$id'";
    $result mysqli_query($conn,$query);
    return $result;

}

//GetAll data using this function
function getAll($tableName, $status = NULL){

    global $conn;

    $table = validate($tableName);
    $status = validate($status);

    if($status == 'status'){
        $query = "SELECT * FROM $table WHERE status = '0'";
    }else{
        $query = "SELECT * FROM $table";
    }
    return mysqli_query($conn,$query);

}

//GetById data using this function
function getById($tableName, $id){

    global $conn;

    $table = validate($tableName);
    $id = validate($id);

    $query = "SELECT * FROM $table WHERE id='$id' LIMIT 1";
    return mysqli_query($conn,$query);

    if($result){

        if(mysqli_num_rows($result) == 1){

            // $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $row = mysqli_fetch_assoc($result);
            $respones = [
                'status' => 404,
                'data' => $row,
                'massage' => 'Record Found'
            ];
            return $respones;


        }else{

            $respones = [
                'status' => 404,
                'message' => 'No Data Found'
            ];
            return $respones;

        }

    }else{

        $respones = [
            'status' => 500,
            'message' => 'Someting Went Wrong'
        ];
        return $respones;

    }
}


// Delete data form database using id
function delete($table, $id){

    global $conn;

    $table = validate($tableName);
    $id = validate($id);

    $query = "DELETE FROM $table id='$id' LIMIT 1";
    $result = mysqli_query($conn, $query);
    return $result;
}

?>