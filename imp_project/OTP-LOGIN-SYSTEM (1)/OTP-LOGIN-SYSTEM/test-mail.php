<?php

require 'config/mail.php';

$otp = rand(100000,999999);

if(sendOTP("yourtestemail@gmail.com",$otp,"Testing"))
{
    echo "Email Sent Successfully";
}
else
{
    echo "Email Failed";
}