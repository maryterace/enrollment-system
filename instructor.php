<?php  
include('db.php');
include 'navigation.php';

//UPDATING ROOM
if(isset($_POST['ID'])) {
	$ID = $_POST['ID'];
	$insname = $_POST['InstructorName'];
	
	
	$sql = "update instructor set InstructorName='$insname' where ID='$ID'";

	if ($conn->query($sql) === TRUE) {
		header('location: /instructor.php?updated=true');
	} else {
		//echo "Error: " . $sql . "<br>" . $conn->error;
		header('location: /instructor.php?updated=false');
	}
	$conn->close();
}

// ADDING ROOM
if(isset($_POST['add'])) {
	$insname = $_POST['InstructorName'];
	
	$sql = "insert into instructor (InstructorName) values ('$insname')";
	if ($conn->query($sql) === TRUE) {
			header('location: /instructor.php?added=true');
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
			header('location: /instructor.php?added=false');
		}
	$conn->close();

}

// DELETING ROOM
if(isset($_GET['delete'])) {
	$sql = "delete from instructor where ID=".$_GET['delete'];
    if ($conn->query($sql) === TRUE) {
        header('location: /instructor.php?deleted=true');
    } else {
        //echo "Error: " . $sql . "<br>" . $conn->error;
        header('location: /instructor.php?deleted=false');
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
			echo '<div class="msg">Instructor updated!</div>';
		}
	}
	if (isset($_GET['deleted'])) {
		if($_GET['deleted'] == 'true') {
			echo '<div class="msg">Instructor deleted!</div>';
		}
	}
	if (isset($_GET['added'])) {
		if($_GET['added'] == 'true') {
			echo '<div class="msg">Instructor added!</div>';
		}
	}
	
	?>
<body>


<?php 
if($_SESSION['user'][4] == 'admin') {
?>

<?php 
if(isset($_GET['edit'])) { ?>
	<form method="post" action="instructor.php">
		<div class="input-group">
			<label>Instructor Name</label>
			<input type="text" name="InstructorName" value="<?php echo @$_GET['InstructorName'] ?>">
		</div>
		<div class="input-group">
			<input type="text" name="ID" value="<?php echo @$_GET['id'] ?>" hidden>
			<button class="btn" type="submit" name="save">UPDATE</button>
		</div>
	</form>

<?php } if(!isset($_GET['edit'])) { ?>

	<form method="post" action="instructor.php">
		<div class="input-group">
			<label>Instructor Name</label>
			<input type="text" name="InstructorName">
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
            <th>ID</th>
			<th>Instructor Name</th>
			

			<?php 
				if($_SESSION['user'][4] == 'admin') {
			?>
			<th colspan="2">Action</th>
				<?php } ?>

		</tr>
	</thead>
	
    <?php 
    $sql = "select * from instructor";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { ?>
		<tr>
			<td><?php echo $row['ID']; ?></td>
			<td><?php echo $row['InstructorName']; ?></td>
							
			<?php 
				if($_SESSION['user'][4] == 'admin') {
			?>
			<td>
                <a href="instructor.php?edit=true&id=<?php echo $row['ID'] ?>&InstructorName=<?php echo $row['InstructorName'] ?>" class="edit_btn">Edit</a>
			</td>
			<td>
				<a href="instructor.php?delete=<?php echo $row['ID']; ?>" class="del_btn">Delete</a>
			</td>
			<?php } ?>

		</tr>
    <?php }
    } ?>
</table>
    </body>
</html>