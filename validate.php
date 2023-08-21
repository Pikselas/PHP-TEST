<?php 

class ProcessException extends Exception
{
    public function __construct($response_code , $message)
    {
        $this->message = $message;
        $this->response_code = $response_code;
    }

    public function getResponseCode()
    {
        return $this->response_code;
    }

    public function getExceptMessage()
    {
        return $this->message;
    }
}

function checkNGet($key)
{
    return isset($_POST[$key]) ? $_POST[$key] : "";
}

function ValidateEmail($email)
{
    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        throw new ProcessException(400 , "Invalid email");
    }
}

function ValidateName($name)
{
    if(!preg_match("/^[a-zA-Z ]*$/",trim($name)))
    {
        throw new ProcessException(400 , "Only letters and white spaces allowed for Name");
    }
}

function ValidateSubject($subject)
{
    if(!preg_match("/^[0-9a-zA-Z ]*$/",trim($subject)))
    {
        throw new ProcessException(400 , "Only letters, white spaces and numbers allowed for Subject");
    }
}

function ValidateMessage($message)
{
    if(trim($message) == "")
    {
        throw new ProcessException(400 , "Message cannot be empty");
    }
}

?>