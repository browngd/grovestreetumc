<?php

/*
 * class for holding and validating data captured from the contact form
*/

class cff_Contact
{
    var $Name;
    var $Email;
    var $ConfirmEmail;
    var $Message;
    var $ErrorMessage;
    var $RecaptchaPublicKey;
    var $RecaptchaPrivateKey;
    var $Errors;
    
    function __construct() 
    {
        $this->Errors = array();
        
        if (cff_PluginSettings::UseRecaptcha()) 
        {
            $this->RecaptchaPublicKey = cff_PluginSettings::PublicKey();
            $this->RecaptchaPrivateKey = cff_PluginSettings::PrivateKey();
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') 
        {
            $this->Name = filter_var($_POST['cf-Name'], FILTER_SANITIZE_STRING);
            unset($_POST['cf-Name']);
            $this->Email = filter_var($_POST['cf-Email'], FILTER_SANITIZE_EMAIL);
            unset($_POST['cf-Email']);
            $this->ConfirmEmail = filter_var($_POST['cfconfirm-email'], FILTER_SANITIZE_EMAIL);
            unset($_POST['cfconfirm-email']);
            $this->Message = filter_var($_POST['cf-Message'], FILTER_SANITIZE_STRING);
            unset($_POST['cf-Message']);
        }
    }
    
    function IsValid() 
    {
        $this->Errors = array();
        
        if ($_SERVER['REQUEST_METHOD'] != 'POST') 
        return false;

        //check nonce
        
        if (!wp_verify_nonce($_POST['cff_nonce'], 'cff_contact')) 
        return false;

        // email and confirm email are the same
        
        if ($this->Email != $this->ConfirmEmail) $this->Errors['Confirm-Email'] = __('Sorry the email addresses do not match.','cleanandsimple');

        //email
        
        if (strlen($this->Email) == 0) $this->Errors['Email'] = __('Please give your email address.','cleanandsimple');

        //confirm email
        
        if (strlen($this->ConfirmEmail) == 0) $this->Errors['Confirm-Email'] = __('Please confirm your email address.','cleanandsimple');

        //name
        
        if (strlen($this->Name) == 0) $this->Errors['Name'] = __('Please give your name.','cleanandsimple');

        //message
        
        if (strlen($this->Message) == 0) $this->Errors['Message'] = __('Please enter a message.','cleanandsimple');

        //email invalid address
        
        if (strlen($this->Email) > 0 && !filter_var($this->Email, FILTER_VALIDATE_EMAIL)) $this->Errors['Email'] = __('Please enter a valid email address.','cleanandsimple');

        //check recaptcha but only if we have keys
        
        if ($this->RecaptchaPublicKey <> '' && $this->RecaptchaPrivateKey <> '') 
        {
            $resp = recaptcha_check_answer($this->RecaptchaPrivateKey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
            
            if (!$resp->is_valid) $this->Errors['recaptcha'] = __('Sorry the code wasn\'t entered correctly please try again.','cleanandsimple');
        }
        
        return count($this->Errors) == 0;
    }
}

