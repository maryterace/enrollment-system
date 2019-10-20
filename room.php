<?php  
include('db.php');
include 'navigation.php';

//UPDATING ROOM
if(isset($_POST['ID'])) {
	$ID = $_POST['ID'];
	$roomname = $_POST['Room_Name'];
	$location = $_POST['Location'];
	$capacity = $_POST['Capacity'];
	
	$sql = "update Room set Room_Name='$roomname',Location='$location', Capacity='$capacity' where ID='$ID'";

	if ($conn->query($sql) === TRUE) {
		header('location: /room.php?updated=true');
	} else {
		//echo "Error: " . $sql . "<br>" . $conn->error;
		header('location: /room.php?updated=false');
	}
	$conn->close();
}

// ADDING ROOM
if(isset($_POST['add'])) {
	$roomname = $_POST['Room_Name'];
	$location = $_POST['Location'];
	$capacity = $_POST['Capacity'];

	$sql = "insert into Room (Room_Name, Location, Capacity) values ('$roomname','$location','$capacity')";
	if ($conn->query($sql) === TRUE) {
			header('location: /room.php?added=true');
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
			header('location: /room.php?added=false');
		}
	$conn->close();

}

// DELETING ROOM
if(isset($_GET['delete'])) {
	$sql = "delete from Room where ID=".$_GET['delete'];
    if ($conn->query($sql) === TRUE) {
        header('location: /room.php?deleted=true');
    } else {
        //echo "Error: " . $sql . "<br>" . $conn->error;
        header('location: /room.php?deleted=false');
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
			echo '<div class="msg">Room updated!</div>';
		}
	}
	if (isset($_GET['deleted'])) {
		if($_GET['deleted'] == 'true') {
			echo '<div class="msg">Room deleted!</div>';
		}
	}
	if (isset($_GET['added'])) {
		if($_GET['added'] == 'true') {
			echo '<div class="msg">Room added!</div>';
		}
	}
	
	?>
<body>


<?php 
if($_SESSION['user'][4] == 'admin') {
?>

<?php 
if(isset($_GET['edit'])) { ?>
	<form method="post" action="room.php">
		<div class="input-group">
			<label>Room Name</label>
			<input type="text" name="Room_Name" value="<?php echo @$_GET['Room_Name'] ?>">
		</div>
		<div class="input-group">
			<label>Location</label>
			<input type="text" name="Location" value="<?php echo @$_GET['Location'] ?>">
        </div>
        <div class="input-group">
			<label>Capacity</label>
			<input type="text" name="Capacity" value="<?php echo @$_GET['Capacity'] ?>">
		</div>
		<div class="input-group">
			<input type="text" name="ID" value="<?php echo @$_GET['id'] ?>" hidden>
			<button class="btn" type="submit" name="save">UPDATE</button>
		</div>
	</form>

<?php } if(!isset($_GET['edit'])) { ?>

	<form method="post" action="room.php">
		<div class="input-group">
			<label>Room Name</label>
			<input type="text" name="Room_Name">
		</div>
		<div class="input-group">
			<label>Location</label>
			<input type="text" name="Location">
		</div>
        <div class="input-group">
			<label>Capacity</label>
			<input type="text" name="Capacity">
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
         
			<th>Room Name</th>
			<th>Location</th>
			<th>Capacity</th>

			<?php 
				if($_SESSION['user'][4] == 'admin') {
			?>
			<th colspan="2">Action</th>
				<?php } ?>

		</tr>
	</thead>
	
    <?php 
    $sql = "select * from Room";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { ?>
		<tr>
		
			<td><?php echo $row['Room_Name']; ?></td>
			<td><?php echo $row['Location']; ?></td>
			<td><?php echo $row['Capacity']; ?></td>
					
			<?php 
				if($_SESSION['user'][4] == 'admin') {
			?>
			<td>
                <a href="room.php?edit=true&id=<?php echo $row['ID'] ?>&Room_Name=<?php echo $row['Room_Name'] ?>&Location=<?php echo $row['Location'] ?>&Capacity=<?php echo $row['Capacity'] ?>" class="edit_btn">Edit</a>
			</td>
			<td>
				<a href="room.php?delete=<?php echo $row['ID']; ?>" class="del_btn">Delete</a>
			</td>
			<?php } ?>

		</tr>
    <?php }
    } ?>
</table>
    </body>
</html>