<?php
require("connection/connectdb.php");

// delete data 
if (isset($_POST['program'])) {
    $program = $_POST['program'];
    $program = stripslashes($program);
    $uniqid = sha1(uniqid(rand(), true), false);
    if ($program == "delete_data") {
        $id = $_POST['id'];
        $sqldelete = "DELETE FROM `student` WHERE `student_codeid` = '$id'";
        $query_sql = $connectdb->query($sqldelete);
        if ($query_sql) {
            echo "ok";
        } else {
            echo "not ok";
        }
    }

    // insert data 
    else if ($program == "insert_data") {
        $uname = $_POST['uname'];
        $tel = $_POST['tel'];
        $email = $_POST['email'];
        $sqlinsertdata = "INSERT INTO `student`(
                `student_codeid`,
                `student_name`,
                `student_tel`,
                `student_email`
            )
            VALUES('$uniqid','$uname','$tel','$email')";
        $query_sql = $connectdb->query($sqlinsertdata);
        if ($query_sql) {
            echo "ok";
        } else {
            echo "not ok";
        }
    }
    // edit data 
    else if ($program == "edit_data") {
        $encodeid = $_POST['encodeid'];
        $sqlieditdata = "SELECT
            `student_codeid`,
            `student_name`,
            `student_tel`,
            `student_email`
        FROM
            `student`
        WHERE
            `student_codeid` = '$encodeid'";
        $query_sql = $connectdb->query($sqlieditdata);
        $rowsql = mysqli_fetch_assoc($query_sql);
        if ($query_sql) {
            $result_arr[] = array(
                "student_name" => $rowsql['student_name'], "student_tel" => $rowsql['student_tel'], "student_email" => $rowsql['student_email'],
                "student_codeid" => $rowsql['student_codeid']
            );
            echo json_encode($result_arr);
        } else {
            echo "not ok";
        }
    }
    // Update data 
    else if ($program == "save_edit_data") {
        $id_data = $_POST['id_data'];
        $uname = $_POST['uname'];
        $tel = $_POST['tel'];
        $email = $_POST['email'];
        $sqlieditdata = "UPDATE
        `student`
    SET
    
        `student_name` = '$uname',
        `student_tel` = '$tel',
        `student_email` = '$email'
    
    WHERE
        `student_codeid` = '$id_data'";
        $query_sql = $connectdb->query($sqlieditdata);
        if ($query_sql) {
            echo "ok";
        } else {
            echo "not ok";
        }
    } else {
    }
}
