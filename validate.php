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


//-------------------------------------------------------------------------------------

function CreateMessage($name , $email , $subject , $message)
{
    include_once("database_details.php");
    $conn = mysqli_connect(DB_HOST , DB_USER , DB_PASS , DB_NAME);
    if(!$conn)
    {
        throw new ProcessException(500 , "Database Connection Error");
    }
    $query = sprintf(
                     "INSERT INTO CONTACT_FORM ( NAME , EMAIL , SUB , MSG , IP , CREATED_AT ) VALUES ('%s' , '%s' , '%s' , '%s' ,'%s' , '%s')", 
                     $name , $email , $subject , $message , $_SERVER['REMOTE_ADDR'] , date("Y-m-d H:i:s")
                    );
    $result = mysqli_query($conn , $query);
    if(!$result)
    {
        mysqli_close($conn);
        throw new ProcessException(500 , "Database Query Error");
    }
    mysqli_close($conn);
}

function InformOwner()
{
    include_once("site_details.php");
    if(!mail(OWNER_MAIL , "Contact Form" , "You have a new message from your website"))
    {
        throw new ProcessException(500 , "Mail Error");
    }
}

//-------------------------------------------------------------------------------------

const MSG_BOX_SUCCESS = "success";
const MSG_BOX_ERROR = "error";

function GenerateMessageBox($message , $type)
{
    return sprintf('<div class="server-msg %s">%s</div>' , $type , $message);
}

?>