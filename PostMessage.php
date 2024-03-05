<!-- Chapter 6 Exercise -->
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Post A Message</title>
</head>
<body>
	<?php
		if(isset($_POST["submit"])) {
			$Subject = stripslashes($_POST["subject"]);
			$Name = stripslashes($_POST["name"]);
			$Message = stripslashes($_POST["message"]);
			$Subject = str_replace("~", "-", $Subject);
			$Name = str_replace("~", "-", $Name);
			$Message = str_replace("~", "-", $Message);
			$ExistingSubjects = array();
			if((file_exists("messages.txt")) === true && (filesize("messages.txt") > 0)) {
				$MessageArray = file("messages.txt");
				$count = count($MessagesArray);
				for($i = 0; $i < $count; ++$i) {
					$CurrMsg = explode("~", $MessageArray[$i]);
					$ExistingSubjects[] = $CurrMsg[0];
				}
			}
			if(in_array($Subject, $ExistingSubjects) === true) {
				echo "<p>The subject you entered already exists!<br/>Please enter a new subject and try again.</p>";
				echo "<p>Your message was not saved!</p>";
				$Subject = "";
			} else {
				$MessageRecord = "$Subject~$Name~$Message\n";
				$MessageFile = fopen("messages.txt", "a");
				if($MessageFile === FALSE) {
					echo "<p>There was an error saving your message!</p>";
				} else {
					fwrite($MessageFile, $MessageRecord);
					fclose($MessageFile);
					echo "<p>Your message has been saved!</p>";
					$Subject = "";
					$Message = "";
					$Name = "";
				}
			}
		}
	?>
	<h1>Post New Message</h1>
	<hr/>
	<form action="PostMessage.php" method="post">
		<label style="font-weight: bold;" for="subject">Subject:</label>
		<input type="text" name="subject" id="subject" value="<?php echo $Subject ?>">
		<label style="font-weight: bold;" for="name">Name:</label>
		<input type="text" name="name" id="name" value="<?php echo $Name ?>">
		<textarea name="message" rows="6" cols="80"><?php echo $Message ?></textarea>
		<br/>
		<input type="submit" name="submit" value="Post Message">
		<input type="reset" name="reset" value="Reset Form">
	</form>
	<hr/>
	<p><a href="MessageBoard.php">View Messages</a></p>
</body>
</html>