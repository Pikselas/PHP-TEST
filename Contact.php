<?php
include "validate.php";

if($_SERVER["REQUEST_METHOD"] == "POST")
{

    try
    {
        if
        (
            !empty($_POST['name'])
                and
            !empty($_POST['email'])
                and
            !empty($_POST['subject'])
                and
            !empty($_POST['message'])
        )
        {
            ValidateName($_POST['name']);
            ValidateEmail($_POST['email']);
            ValidateSubject($_POST['subject']);
            ValidateMessage($_POST['message']);
        }
        else
        {
            throw new ProcessException(400 , "Fill all the fields");
        }
    }
    catch(ProcessException $e)
    {
        http_response_code($e->getResponseCode());
        echo $e->getExceptMessage();
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel = "stylesheet" href = "style.css">
</head>
<body>
    <form action="" method="POST">
        <input class="input-class" type="text" name="name" placeholder="Name" value="<?php 
        
            echo checkNGet("name");

        ?>" required>
        <input class="input-class" type="email" name="email" placeholder="Email" value="<?php 
        
            echo checkNGet("email");

        ?>" required>
        <input class="input-class" type="text" name="subject" placeholder="Subject" value="<?php

            echo checkNGet("subject");

        ?>" required>
        <textarea class="input-class" name="message" placeholder="Message" required><?php echo checkNGet("message"); ?></textarea>
        <input type="submit" value="Send Message">
    </form>
</body>
</html>