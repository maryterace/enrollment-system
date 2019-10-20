<?php
session_start();
include_once('db.php');

$email = $_POST['email'];
$pass = $_POST['password'];

$sql = "SELECT * FROM users WHERE email='$email' AND password='$pass'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $_SESSION['user'] = [$row['ID'], $row['FirstName'], $row['LastName'], $row['Email'], $row['Role']];
        header('location: /');
    }
} else {
    $sql = "SELECT * FROM student WHERE email='$email' AND password='$pass'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $_SESSION['user'] = [$row['ID'], $row['FirstName'], $row['LastName'], $row['Email'], $row['Role']];
            header('location: /');
        }
    } else {
        header('location: /login.php?wrongpassword=yes');
    }
    
}
$conn->close();

// initialize variables
$firstname = "";
$middlename = "";
$lastname = "";
$address = "";
$id = 0;
$update = false;

if (isset($_POST['save'])) {
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];

    mysqli_query($db, "INSERT INTO info (name, address) VALUES ('$firstname', '$middlename', '$lastname''$address')"); 
    $_SESSION['message'] = "Address saved"; 
    header('location: index.php');
}



// if (isset($_POST['password']) && isset($_POST['email'])) {
//     if ($_POST['password'] != "" && $_POST['email'] != "") {
//         session_start();
//         function login($email, $pass)
//         {
//             include_once '../db.php';
//             $sql = "SELECT * FROM users WHERE email='$email' AND password='$pass'";

//             $result = $conn->query($sql);

//             if ($result->num_rows > 0) {
//                 // output data of each row
//                 while ($row = $result->fetch_assoc()) {
//                     $_SESSION['user'] = [$row['idusers'], $row['firstname'], $row['lastname'], $row['email']];
//                     header('location: /');
//                 }
//             } else {
//                 header('location: /login.php?invalid=true');
//             }
//             $conn->close();
//         }
//         login($_POST['email'], $_POST['password']);
//     } else {
//         header('location: /login.php?blank=true');
//     }
// }

?>