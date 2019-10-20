<?php  
include('db.php');
include 'navigation.php';

//UPDATING SCHED
if(isset($_POST['ID'])) {
	$code = $_POST['schedCode'];
	$ID = $_POST['ID'];
	$sub = $_POST['Subject'];
	$time = $_POST['TimeFrom']."-".$_POST['TimeTo'];
	$room = $_POST['Room'];
	$ins = $_POST['Instructor'];
	$sems = $_POST['Semester'];
	$term = $_POST['Term'];
	$yr = $_POST['YearFrom']."-".$_POST['YearTo'];
	
	$sql = "update Schedule set Code='$code', Subject='$sub',Time='$time', Room='$room', Instructor='$ins', Semester='$sems', Term='$term', Year='$yr' where ID='$ID'";

	if ($conn->query($sql) === TRUE) {
		header('location: /sched.php?updated=true');
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
		//header('location: /sched.php?updated=false');
	}
	$conn->close();
}

// ADDING SCHED
if(isset($_POST['add'])) {
	$code = $_POST['schedCode'];
	$sub = $_POST['Subject'];
	$time = $_POST['TimeFrom']."-".$_POST['TimeTo'];
	$room = $_POST['Room'];
	$ins = $_POST['Instructor'];
	$sems = $_POST['Semester'];
	$term = $_POST['Term'];
	$yr = $_POST['YearFrom']."-".$_POST['YearTo'];

	$sql = "insert into Schedule (Code, Subject, Time, Room, Instructor, Semester, Term, Year) values ('$code', '$sub','$time','$room','$ins','$sems','$term','$yr')";
	if ($conn->query($sql) === TRUE) {
			header('location: /sched.php?added=true');
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
			header('location: /sched.php?added=false');
		}
	$conn->close();

}
// DELETING SCHED
if(isset($_GET['delete'])) {
	$sql = "delete from Schedule where ID=".$_GET['delete'];
    if ($conn->query($sql) === TRUE) {
        header('location: /sched.php?deleted=true');
    } else {
        //echo "Error: " . $sql . "<br>" . $conn->error;
        header('location: /sched.php?deleted=false');
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
			echo '<div class="msg">Schedule updated!</div>';
		}
	}
	if (isset($_GET['deleted'])) {
		if($_GET['deleted'] == 'true') {
			echo '<div class="msg">Schedule deleted!</div>';
		}
	}
	if (isset($_GET['added'])) {
		if($_GET['added'] == 'true') {
			echo '<div class="msg">Schedule added!</div>';
		}
	}
	
	?>
<body>


<?php 
if($_SESSION['user'][4] == 'admin') {
?>

<?php 

if(isset($_GET['edit'])) { 
	$timee = explode('-', $_GET['Time']);
	$year = explode('-', $_GET['Year']);
	?>
	<form method="post" action="sched.php">
		<div class="form-group">
			<label>Schedule Code</label>
			<input type="text" value="<?php echo $_GET['Code'] ?>" class="form-control" name="schedCode" placeholder="Schedule Code">	
		</div>
		<div class="input-group">
			<label>Subject</label>
			<select class="input-group" name="Subject">
                <?php 
                $sql = "select * from Subject";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
						$subcode = $row['Subject_Code'];
                        ?>
                        <option <?php if ($_GET['Subject'] == $subcode) echo 'selected'; ?>>
                            <?php echo $subcode;?>
                        </option>
                    <?php }} ?>
			</select>
		</div>
		<label>Time </label>
		<div class="input-group">
			<div class="form-row">
				<div class="col">
					<input type="time" name="TimeFrom" value="<?php echo $timee[0] ?>">
				</div>
				<div class="col">
					<input type="time" name="TimeTo" value="<?php echo $timee[1] ?>">
				</div>
			</div>
			
		</div>
        <div class="input-group">
			<label>Room</label>
			<select class="input-group" name="Room" id="exampleFormControlSelect1" value="<?php echo $_POST['gender']?>">
                <?php
                $sql = "select * from Room";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
						$roomname = $row['Room_Name'];
                        ?>
                        <option <?php if ($_GET['Room'] == $roomname) echo 'selected'; ?>>
                            <?php echo $roomname;?>
                        </option>
                    <?php }} ?>
                </select>
		</div>
		<div class="input-group">
			<label>Instructor</label>
			<input type="text" name="Instructor" value="<?php echo @$_GET['Instructor'] ?>">
		</div>
		<div class="input-group">
			<label>Semester</label>
			<select class="input-group" name="Semester" value="<?php echo $_POST['Semester']?>">
				<option  <?php if($_GET['Semester']=='1st Semester') echo 'selected'?>>1</option>
				<option  <?php if($_GET['Semester']=='2nd Semester') echo 'selected'?>>2</option>
            </select>
		</div>
		<div class="input-group">
			<label>Term</label>
			<select class="input-group" name="Term" value="<?php echo $_POST['Term']?>">
				<option  <?php if($_GET['Term']=='1st Term') echo 'selected'?>>1</option>
				<option  <?php if($_GET['Term']=='2nd Term') echo 'selected'?>>2</option>
            </select>
		</div>
		<label>Year</label>
		<div class="input-group">
			<div class="form-row">
				<div class="col">
					<input type="text" name="YearFrom" value="<?php echo $year[0] ?>">
				</div>
				<div class="col">
					<input type="text" name="YearTo" value="<?php echo $year[1] ?>">
				</div>
			</div>
		</div>
		<div class="input-group">
			<input type="text" name="ID" value="<?php echo @$_GET['id'] ?>" hidden>
			<button class="btn" type="submit" name="save">UPDATE</button>
		</div>
	</form>

<?php } if(!isset($_GET['edit'])) { ?>

	<form method="post" action="sched.php">
		<div class="form-group">
			<label>Schedule Code</label>
			<input type="text" class="form-control" name="schedCode" placeholder="Schedule Code">	
		</div>
		<div class="input-group">
			<label>Subject</label>
			<select class="input-group" name="Subject">
                <?php
                $sql = "select * from Subject";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
						$subcode = $row['Subject_Code'];
                        ?>
                        <option>
                            <?php echo $subcode;?>
                        </option>
                    <?php }} ?>
			</select>
		</div>
		<label>Time </label>
		<div class="input-group">
			<div class="form-row">
				<div class="col">
					<input type="time" name="TimeFrom">
				</div>
				<div class="col">
					<input type="time" name="TimeTo">
				</div>
			</div>
		</div>
        <div class="input-group">
			<label>Room</label>
			<select class="input-group" name="Room" value="<?php echo $_POST['Room']?>">
                <?php
                $sql = "select * from Room";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $roomname = $row['Room_Name'];
                        ?>
                        <option>
                            <?php echo $roomname; ?>
                        </option>
                    <?php }} ?>
                </select>
		</div>
		<div class="input-group">
			<label>Instructor</label>
			<select class="input-group" name="Instructor" value="<?php echo $_POST['Instructor']?>">
                <?php
                $sql = "select * from instructor";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $instructor = $row['InstructorName'];
                        ?>
                        <option>
                            <?php echo $instructor; ?>
                        </option>
                    <?php }} ?>
                </select>
		</div>
		<div class="input-group">
			<label>Semester</label>
			<select class="input-group" name="Semester" value="<?php echo $_POST['Semester']?>">
				<option>1</option>
				<option>2</option>
            </select>
		</div>
		<div class="input-group">
			<label>Term</label>
			<select class="input-group" name="Term" value="<?php echo $_POST['Term']?>">
				<option>1</option>
				<option>2</option>
            </select>
		</div>
		<label>Year</label>
		<div class="input-group">
			<div class="form-row">
				<div class="col">
					<input type="number" name="YearFrom" placeholder="2019">
				</div>
				<div class="col">
					<input type="number" name="YearTo" placeholder="2020">
				</div>
			</div>
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
          
			<th>Code</th>
			<th>Subject</th>
			<th>Time</th>
			<th>Room</th>
			<th>Instructor</th>
			<th>Semester</th>
			<th>Term</th>
			<th>Year</th>

			<?php 
				if($_SESSION['user'][4] == 'admin') {
			?>
			<th colspan="2">Action</th>
			<?php } ?>

		</tr>
	</thead>
	
    <?php 
    $sql = "select * from Schedule";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { ?>
		<tr>
			
			<td><?php echo $row['Code']; ?></td>
			<td><?php echo $row['Subject']; ?></td>
			<td><?php echo $row['Time']; ?></td>
			<td><?php echo $row['Room']; ?></td>
			<td><?php echo $row['Instructor']; ?></td>
			<td><?php echo $row['Semester']; ?></td>
			<td><?php echo $row['Term']; ?></td>
			<td><?php echo $row['Year']; ?></td>
				
			<?php 
				if($_SESSION['user'][4] == 'admin') {
			?>
			<td>
                <a href="sched.php?edit=true&id=<?php echo $row['ID'] ?>&Code=<?php echo $row['Code'] ?>&Subject=<?php echo $row['Subject'] ?>&Time=<?php echo $row['Time'] ?>&Room=<?php echo $row['Room'] ?>&Instructor=<?php echo $row['Instructor'] ?>&Semester=<?php echo $row['Semester'] ?>&Term=<?php echo $row['Term'] ?>&Year=<?php echo $row['Year'] ?>" class="edit_btn">Edit</a>
			</td>
			<td>
				<a href="sched.php?delete=<?php echo $row['ID']; ?>" class="del_btn">Delete</a>
			</td>
				<?php } ?>

		</tr>
    <?php }
    } ?>
</table>
    </body>
</html>