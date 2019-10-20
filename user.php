<?php  
include('db.php');
include 'navigation.php';

//UPDATING USER
if(isset($_POST['ID'])) {
	$ID = $_POST['ID'];
    $firstname = $_POST['FirstName'];
    $lastname = $_POST['LastName'];
    $email = $_POST['Email'];
    $password = $_POST['Password'];
	
    $sql = "update users set FirstName='$firstname',  LastName='$lastname', Email='$email', Password='$password' where ID='$ID'";
    if ($conn->query($sql) === TRUE) {
        header('location: /user.php?updated=true');
    } else {
        //echo "Error: " . $sql . "<br>" . $conn->error;
        header('location: /user.php?updated=false');
    }
    $conn->close();
}

// ADDING USER
if(isset($_POST['Email'])) {
    $firstname = $_POST['FirstName'];
    $lastname = $_POST['LastName'];
    $email = $_POST['Email'];
    $password = $_POST['Password'];

    $sql = "insert into users (FirstName, LastName, Email, Password) values ('$firstname', '$lastname', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        header('location: /user.php?success=true');
    } else {
        //echo "Error: " . $sql . "<br>" . $conn->error;
        header('location: /user.php?success=false');
    }
    $conn->close();

}
// DELETING COURSE
if(isset($_GET['delete'])) {
	$sql = "delete from users where ID=".$_GET['delete'];
    if ($conn->query($sql) === TRUE) {
        header('location: /user.php?deleted=true');
    } else {
        //echo "Error: " . $sql . "<br>" . $conn->error;
        header('location: /user.php?deleted=false');
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
	<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
    <link rel="stylesheet" type="text/css" href="style.css">
    </head>
	<?php
    if (isset($_GET['updated'])) {
		if($_GET['updated'] == 'true') {
			echo '<div class="msg">User updated!</div>';
		}
	}
	if (isset($_GET['deleted'])) {
		if($_GET['deleted'] == 'true') {
			echo '<div class="msg">User deleted!</div>';
		}
	}
	if (isset($_GET['added'])) {
		if($_GET['added'] == 'true') {
			echo '<div class="msg">User added!</div>';
		}
	}
	
	?>
<body>

<?php 
	if($_SESSION['user'][4] == 'admin') {
?>
<?php 
if(isset($_GET['edit'])) { ?>
	<form method="post" action="user.php">
		<div class="input-group">
			<label>First Name</label>
			<input type="text" name="FirstName" value="<?php echo @$_GET['FirstName'] ?>">
		</div>
        <div class="input-group">
			<label>Last Name</label>
			<input type="text" name="LastName" value="<?php echo @$_GET['LastName'] ?>">
        </div>
        <div class="input-group">
			<label>Email</label>
			<input type="text" name="Email" value="<?php echo @$_GET['Email'] ?>">
        </div>
        <div class="input-group">
			<label>Password</label>
			<input type="text" name="Password" value="<?php echo @$_GET['Password'] ?>">
		</div>
		<div class="input-group">
			<input type="text" name="ID" value="<?php echo @$_GET['id'] ?>" hidden>
			<button class="btn" type="submit" name="save">UPDATE</button>
		</div>
    </form>
    <?php } ?>
	
	<?php 
			if($_SESSION['user'][4] == 'admin') {
			?>
	
<?php } if(!isset($_GET['edit'])) { ?>
	<form method="post" action="user.php">
		<div class="input-group">
			<label>First Name</label>
			<input type="text" name="FirstName">
		</div>
        <div class="input-group">
			<label>Last Name</label>
			<input type="text" name="LastName">
        </div>
        <div class="input-group">
			<label>Email</label>
			<input type="text" name="Email">
        </div>
        <div class="input-group">
			<label>Password</label>
			<input type="password" name="Password">
		</div>
		<div class="input-group">
			<input type="text" name="add" value="add" hidden>
			<button class="btn" type="submit" name="save">ADD</button>
		</div>
	</form>
	
<?php } ?>
<?php } ?> 

<table>
	<thead>
		<tr>
           
			<th>First Name</th>
           	<th>Last Name</th>
            <th>Email</th>
			<th>Password</th>
			
			<?php 
				if($_SESSION['user'][4] == 'admin') {
			?>
			<th colspan="2">Action</th>
			<?php } ?>
			
		</tr>
	</thead>
	
    <?php 
    $sql = "select * from users";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { ?>
		<tr>
			
			<td><?php echo $row['FirstName']; ?></td>
			<td><?php echo $row['LastName']; ?></td>
            <td><?php echo $row['Email']; ?></td>
            <td><?php echo $row['Password']; ?></td>

			<?php 
			if($_SESSION['user'][4] == 'admin') {
			?>
					
            <td>
                <a href="user.php?edit=true&id=<?php echo $row['ID'] ?>&FirstName=<?php echo $row['FirstName'] ?>&LastName=<?php echo $row['LastName'] ?>&Email=<?php echo $row['Email'] ?>&Password=<?php echo $row['Password'] ?>" class="edit_btn">Edit</a>
			</td>
			<td>
				<a href="user.php?delete=<?php echo $row['ID']; ?>" class="del_btn">Delete</a>
			</td>

			<?php } ?>

		</tr>
    <?php }
    } ?>
</table>
    </body>
</html>