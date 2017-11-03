<?php
class Component_Mailer{
	
	/////////////////////////////////////////////////
    // PROPERTIES, PRIVATE AND PROTECTED
    /////////////////////////////////////////////////
    
	private   $smtp              = NULL;
	private   $to            	 = array();
 	private   $cc            	 = array();
	private   $bcc           	 = array();
	private   $sign_cert_file 	 = "";
  	private   $sign_key_file  	 = "";
    private   $sign_key_pass 	 = "";
    private   $error_count  	 = 0;
    private   $attachment  		 = array();
	private   $message_type 	 = '';
	private   $boundary      	 = array();
    private   $exceptions   	 = false;
	private   $all_recipients	 = array();
	private   $ReplyTo       	 = array();
	
	/////////////////////////////////////////////////
    // PROPERTIES, PUBLIC
    /////////////////////////////////////////////////
  
    public    $ContentType    = 'text/plain';	 //Sets the Content-type of the message.
	public    $LE             = "\n";		//Provides the ability to change the line ending
	public    $From           = 'root@localhost';	//Sets the From email address for the message
	public 	  $FromName       = 'Root User';	//Sets the From name of the message
	public    $Sender         = '';		//Sets the Sender email (Return-Path) of the message
	public    $Mailer         = 'mail';	//Method to send mail: ("mail", "sendmail", or "smtp")
	public    $CharSet        = 'iso-8859-1';	//Sets the CharSet of the message
	public    $AltBody        = '';		//Sets the text-only body of the message
	public    $Body           = '';		//Sets the Body of the message
	public	  $SMTPKeepAlive  = false;	//Prevents the SMTP connection from being closed after each mail sending
	public    $MessageID      = '';		//Sets the message ID to be used in the Message-Id header
	public    $Hostname       = '';		//ets the hostname to use in Message-Id and Received headers and as default HELO string
	
	public 	  $WordWrap          = 0;	//Sets word wrapping on the body of the message to a given number of characters.
	public    $Priority          = 3;	//Email priority (1 = High, 3 = Normal, 5 = low)
	public    $Version           = '5.0.2';		//Sets the PHPMailer Version number
	public    $ConfirmReadingTo  = '';	//Sets the email address that a reading confirmation will be sent
	private   $CustomHeader      = array();
	public	  $SMTPDebug     	 = false;	//Sets SMTP class debugging on or off
	public 	  $Port        		 = 25;	//Sets the default SMTP server port
	public 	  $SMTPSecure   	 = '';	//Sets connection prefix
	public 	  $Timeout       	 = 10;	//Sets the SMTP server timeout in seconds
	public 	  $Helo          	 = '';	//Sets the SMTP HELO of the message (Default is $Hostname)
	public    $Encoding          = '8bit';	//Sets the Encoding of the message
    public 	  $SMTPAuth      	 = false;	//ets SMTP authentication
    public	  $Host         	 = 'localhost';		//Sets the SMTP host
    public 	  $Username    		 = '';		//Sets SMTP username
    public    $Password     	 = '';		//Sets SMTP password
    public 	  $Subject           = '';		//Sets the Subject of the message
    
    public 	  $do_debug;				//Sets whether debugging is turned on
    private   $smtp_conn; 				// the socket to the server
 	private   $error;    				// error if any on the last call
  	private   $helo_rply;				// the reply the server sent to us for HELO
    public 	  $SMTP_PORT 	 = 25;		//SMTP server port
	public 	  $CRLF          = "\r\n";	//SMTP reply line ending
	public 	  $do_verp 		 = false;	//ets VERP use on/off (default is off)
	
    /**
     * Constructor
     * @param boolean $exceptions Should we throw external exceptions?
     */
    public function __construct($exceptions = false) {
        $this->exceptions = ($exceptions == true);
    }
	
	/**
	   * Creates message and assigns Mailer. If the message is
	   * not sent successfully then it returns false.  Use the ErrorInfo
	   * variable to view description of the error.
	   * @return bool
	   */
	public function Send() {
       if ((count($this->to) + count($this->cc) + count($this->bcc)) < 1) {
			echo 'provide_address';
       }

       // Set whether the message is multipart/alternative
       if(!empty($this->AltBody)) {
       		$this->ContentType = 'multipart/alternative';
       }

       $this->error_count = 0; // reset errors
       $this->SetMessageType();
       $header = $this->CreateHeader();
       $body = $this->CreateBody();
      
       if (empty($this->Body)) {
     	 	echo 'empty_message';
       }
      
       // Choose the mailer and send through it
       return $this->SmtpSend($header, $body);
	}
	
	 /**
	   * Sets Mailer to send message using SMTP.
	   * @return void
	   */
	public function IsSMTP() {
	    $this->Mailer = 'smtp';
	}
	
	 /**
	   * Adds a "To" address.
	   * @param string $address
	   * @param string $name
	   * @return boolean true on success, false if address already used
	   */
	public function AddAddress($address, $name = '') {
	    return $this->AddAnAddress('to', $address, $name);
	}
	
	/**
	   * Adds an address to one of the recipient arrays
	   * Addresses that have been added already return false, but do not throw exceptions
	   * @param string $kind One of 'to', 'cc', 'bcc', 'ReplyTo'
	   * @param string $address The email address to send to
	   * @param string $name
	   * @return boolean true on success, false if address already used or invalid in some way
	   * @access private
	   */
	private function AddAnAddress($kind, $address, $name = '') {
	    if (!preg_match('/^(to|cc|bcc|ReplyTo)$/', $kind)) {
	      echo 'Invalid recipient array: ' . kind;
	      return false;
	    }
	    $address = trim($address);
	    $name = trim(preg_replace('/[\r\n]+/', '', $name)); //Strip breaks and trim
	    if (!self::ValidateAddress($address)) {
	      //$this->SetError($this->Lang('invalid_address').': '. $address);
	      if ($this->exceptions) {
	      		echo 'invalid_address';
	      }
	     // echo $this->Lang('invalid_address').': '.$address;
	      return false;
	    }
	  if ($kind != 'ReplyTo') {
	    if (!isset($this->all_recipients[strtolower($address)])) {
	        array_push($this->$kind, array($address, $name));
	        $this->all_recipients[strtolower($address)] = true;
	    return true;
	      }
	  } else {
	    if (!array_key_exists(strtolower($address), $this->ReplyTo)) {
	        $this->ReplyTo[strtolower($address)] = array($address, $name);
	    return true;
	    }
	  }
	    return false;
	}
	
	/**
	   * Check that a string looks roughly like an email address should
	   * Static so it can be used without instantiation
	   * Tries to use PHP built-in validator in the filter extension (from PHP 5.2), falls back to a reasonably competent regex validator
	   * Conforms approximately to RFC2822
	   * @link http://www.hexillion.com/samples/#Regex Original pattern found here
	   * @param string $address The email address to check
	   * @return boolean
	   * @static
	   * @access public
	   */
	public static function ValidateAddress($address) {
	    if (function_exists('filter_var')) { //Introduced in PHP 5.2
	      if(filter_var($address, FILTER_VALIDATE_EMAIL) === FALSE) {
	        return false;
	      } else {
	        return true;
	      }
	    } else {
	      return preg_match('/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/', $address);
	    }
	}
	
	/**
	   * Adds a "Reply-to" address.
	   * @param string $address
	   * @param string $name
	   * @return boolean
	   */
	public function AddReplyTo($address, $name = '') {
	    return $this->AddAnAddress('ReplyTo', $address, $name);
	}
	
	 /**
	   * Sets message type to HTML.
	   * @param bool $ishtml
	   * @return void
	   */
	public function IsHTML($ishtml = true) {
	    if ($ishtml) {
	      $this->ContentType = 'text/html';
	    } else {
	      $this->ContentType = 'text/plain';
	    }
	}
	
	/**
	   * Sends mail via SMTP using PhpSMTP
	   * Returns false if there is a bad MAIL FROM, RCPT, or DATA input.
	   * @param string $header The message headers
	   * @param string $body The message body
	   * @uses SMTP
	   * @access protected
	   * @return bool
	   */
	protected function SmtpSend($header, $body) {
		
	    $bad_rcpt = array();
	
	    if(!$this->SmtpConnect()) {
	    	echo 'smtp_connect_failed';
	    }
	    $smtp_from = ($this->Sender == '') ? $this->From : $this->Sender;
	    if(!$this->Mail($smtp_from)) {
	    	echo 'from_failed';
	    }
		
	    // Attempt to send attach all recipients
	    foreach($this->to as $to) {
	      if (!$this->Recipient($to[0])) {
	        $bad_rcpt[] = $to[0];
	      }
	    }
	    foreach($this->cc as $cc) {
	      if (!$this->Recipient($cc[0])) {
	        $bad_rcpt[] = $cc[0];
	      }
	    }
	    foreach($this->bcc as $bcc) {
	      if (!$this->Recipient($bcc[0])) {
	        $bad_rcpt[] = $bcc[0];
	      }
	    }
	    if (count($bad_rcpt) > 0 ) { //Create error message for any bad addresses
	        $badaddresses = implode(', ', $bad_rcpt);
	      	echo 'recipients_failed';
	    }
	    if(!$this->Data($header . $body)) {
	    	echo 'data_not_accepted';
	    }
	    if($this->SMTPKeepAlive == true) {
	        $this->Reset();
	    }
	    return true;
	}
	
	/**
	   * Initiates a connection to an SMTP server.
	   * Returns false if the operation failed.
	   * @uses SMTP
	   * @access public
	   * @return bool
	   */
	public function SmtpConnect() {
	    if(is_null($this->smtp)) {
	    	 $this->smtp_conn = 0;
   			 $this->error = null;
   			 $this->helo_rply = null;
  			 $this->do_debug = 0;
	    }
	
	    $this->do_debug = $this->SMTPDebug;
	    $hosts = explode(';', $this->Host);
	    $index = 0;
	    $connection = $this->Connected();
	
	    // Retry while there is no connection
	    
      while($index < count($hosts) && !$connection) {
        $hostinfo = array();
        if (preg_match('/^(.+):([0-9]+)$/', $hosts[$index], $hostinfo)) {
          $host = $hostinfo[1];
          $port = $hostinfo[2];
        } else {
          $host = $hosts[$index];
          $port = $this->Port;
        }

        $tls = ($this->SMTPSecure == 'tls');
        $ssl = ($this->SMTPSecure == 'ssl');

        if ($this->Connect(($ssl ? 'ssl://':'').$host, $port, $this->Timeout)) {

          $hello = ($this->Helo != '' ? $this->Helo : $this->ServerHostname());
          $this->Hello($hello);

          if ($tls) {
            if (!$this->smtp->StartTLS()) {
            	echo 'tls';
            }

            //We must resend HELO after tls negotiation
            $this->smtp->Hello($hello);
          }

          $connection = true;
          if ($this->SMTPAuth) {
            if (!$this->Authenticate($this->Username, $this->Password)) {
              	echo  'authenticate';
            }
          }
        }
        $index++;
        if (!$connection) {
        	echo 'connect_host';
        }
      }
	    return true;
	}
	
	/**
	   * Sets the message type.
	   * @access private
	   * @return void
	   */
 	private function SetMessageType() {
	    if(count($this->attachment) < 1 && strlen($this->AltBody) < 1) {
	      $this->message_type = 'plain';
	    } else {
	      if(count($this->attachment) > 0) {
	        $this->message_type = 'attachments';
	      }
	      if(strlen($this->AltBody) > 0 && count($this->attachment) < 1) {
	        $this->message_type = 'alt';
	      }
	      if(strlen($this->AltBody) > 0 && count($this->attachment) > 0) {
	        $this->message_type = 'alt_attachments';
	      }
	    }
  	}

  	/**
	   * Assembles message header.
	   * @access public
	   * @return string The assembled header
	   */
	public function CreateHeader() {
	    $result = '';
	
	    // Set the boundaries
	    $uniq_id = md5(uniqid(time()));
	    $this->boundary[1] = 'b1_' . $uniq_id;
	    $this->boundary[2] = 'b2_' . $uniq_id;
	
	    $result .= $this->HeaderLine('Date', self::RFCDate());
	    if($this->Sender == '') {
	      $result .= $this->HeaderLine('Return-Path', trim($this->From));
	    } else {
	      $result .= $this->HeaderLine('Return-Path', trim($this->Sender));
	    }
	
	    // To be created automatically by mail()
	    if($this->Mailer != 'mail') {
	      if(count($this->to) > 0) {
	        $result .= $this->AddrAppend('To', $this->to);
	      } elseif (count($this->cc) == 0) {
	        $result .= $this->HeaderLine('To', 'undisclosed-recipients:;');
	      }
	    }
	
	    $from = array();
	    $from[0][0] = trim($this->From);
	    $from[0][1] = $this->FromName;
	    $result .= $this->AddrAppend('From', $from);
	
	    // sendmail and mail() extract Cc from the header before sending
	    if(count($this->cc) > 0) {
	      $result .= $this->AddrAppend('Cc', $this->cc);
	    }
	
	    // sendmail and mail() extract Bcc from the header before sending
	    if((($this->Mailer == 'sendmail') || ($this->Mailer == 'mail')) && (count($this->bcc) > 0)) {
	      $result .= $this->AddrAppend('Bcc', $this->bcc);
	    }
	
	    if(count($this->ReplyTo) > 0) {
	      $result .= $this->AddrAppend('Reply-to', $this->ReplyTo);
	    }
	
	    // mail() sets the subject itself
	    if($this->Mailer != 'mail') {
	      $result .= $this->HeaderLine('Subject', $this->EncodeHeader($this->SecureHeader($this->Subject)));
	    }
	
	    if($this->MessageID != '') {
	      $result .= $this->HeaderLine('Message-ID',$this->MessageID);
	    } else {
	      $result .= sprintf("Message-ID: <%s@%s>%s", $uniq_id, $this->ServerHostname(), $this->LE);
	    }
	    $result .= $this->HeaderLine('X-Priority', $this->Priority);
	    $result .= $this->HeaderLine('X-Mailer', 'PHPMailer '.$this->Version.' (phpmailer.codeworxtech.com)');
	
	    if($this->ConfirmReadingTo != '') {
	      $result .= $this->HeaderLine('Disposition-Notification-To', '<' . trim($this->ConfirmReadingTo) . '>');
	    }
	
	    // Add custom headers
	    for($index = 0; $index < count($this->CustomHeader); $index++) {
	      $result .= $this->HeaderLine(trim($this->CustomHeader[$index][0]), $this->EncodeHeader(trim($this->CustomHeader[$index][1])));
	    }
	    if (!$this->sign_key_file) {
	      $result .= $this->HeaderLine('MIME-Version', '1.0');
	      $result .= $this->GetMailMIME();
	    }
	
	    return $result;
	}
	
	/**
	  *  Returns a formatted header line.
	  * @access public
	  * @return string
	  */
	public function HeaderLine($name, $value) {
    	return $name . ': ' . $value . $this->LE;
  	}
	
  	/**
	   * Returns the proper RFC 822 formatted date.
	   * @access public
	   * @return string
	   * @static
	   */
	public static function RFCDate() {
	    $tz = date('Z');
	    $tzs = ($tz < 0) ? '-' : '+';
	    $tz = abs($tz);
	    $tz = (int)($tz/3600)*100 + ($tz%3600)/60;
	    $result = sprintf("%s %s%04d", date('D, j M Y H:i:s'), $tzs, $tz);
	
	    return $result;
	}
	
	/**
	   * Creates recipient headers.
	   * @access public
	   * @return string
	   */
	public function AddrAppend($type, $addr) {
	    $addr_str = $type . ': ';
	    $addresses = array();
	    foreach ($addr as $a) {
	      $addresses[] = $this->AddrFormat($a);
	    }
	    $addr_str .= implode(', ', $addresses);
	    $addr_str .= $this->LE;
	
	    return $addr_str;
	}
	
	/**
	   * Formats an address correctly.
	   * @access public
	   * @return string
	   */
	public function AddrFormat($addr) {
	    if (empty($addr[1])) {
	      return $this->SecureHeader($addr[0]);
	    } else {
	      return $this->EncodeHeader($this->SecureHeader($addr[1]), 'phrase') . " <" . $this->SecureHeader($addr[0]) . ">";
	    }
	}
	
	/**
	   * Strips newlines to prevent header injection.
	   * @access public
	   * @param string $str String
	   * @return string
	   */
	public function SecureHeader($str) {
	    $str = str_replace("\r", '', $str);
	    $str = str_replace("\n", '', $str);
	    return trim($str);
	}
	
	/**
	   * Encode a header string to best (shortest) of Q, B, quoted or none.
	   * @access public
	   * @return string
	   */
	public function EncodeHeader($str, $position = 'text') {
	    $x = 0;
	
	    switch (strtolower($position)) {
	      case 'phrase':
	        if (!preg_match('/[\200-\377]/', $str)) {
	          // Can't use addslashes as we don't know what value has magic_quotes_sybase
	          $encoded = addcslashes($str, "\0..\37\177\\\"");
	          if (($str == $encoded) && !preg_match('/[^A-Za-z0-9!#$%&\'*+\/=?^_`{|}~ -]/', $str)) {
	            return ($encoded);
	          } else {
	            return ("\"$encoded\"");
	          }
	        }
	        $x = preg_match_all('/[^\040\041\043-\133\135-\176]/', $str, $matches);
	        break;
	      case 'comment':
	        $x = preg_match_all('/[()"]/', $str, $matches);
	        // Fall-through
	      case 'text':
	      default:
	        $x += preg_match_all('/[\000-\010\013\014\016-\037\177-\377]/', $str, $matches);
	        break;
	    }
	
	    if ($x == 0) {
	      return ($str);
	    }
	
	    $maxlen = 75 - 7 - strlen($this->CharSet);
	    // Try to select the encoding which should produce the shortest output
	    if (strlen($str)/3 < $x) {
	      $encoding = 'B';
	      if (function_exists('mb_strlen') && $this->HasMultiBytes($str)) {
	        // Use a custom function which correctly encodes and wraps long
	        // multibyte strings without breaking lines within a character
	        $encoded = $this->Base64EncodeWrapMB($str);
	      } else {
	        $encoded = base64_encode($str);
	        $maxlen -= $maxlen % 4;
	        $encoded = trim(chunk_split($encoded, $maxlen, "\n"));
	      }
	    } else {
	      $encoding = 'Q';
	      $encoded = $this->EncodeQ($str, $position);
	      $encoded = $this->WrapText($encoded, $maxlen, true);
	      $encoded = str_replace('='.$this->LE, "\n", trim($encoded));
	    }
	
	    $encoded = preg_replace('/^(.*)$/m', " =?".$this->CharSet."?$encoding?\\1?=", $encoded);
	    $encoded = trim(str_replace("\n", $this->LE, $encoded));
	
	    return $encoded;
	}
	
	/**
	   * Encode string to q encoding.
	   * @link http://tools.ietf.org/html/rfc2047
	   * @param string $str the text to encode
	   * @param string $position Where the text is going to be used, see the RFC for what that means
	   * @access public
	   * @return string
	   */
	public function EncodeQ ($str, $position = 'text') {
	    // There should not be any EOL in the string
	    $encoded = preg_replace('/[\r\n]*/', '', $str);
	
	    switch (strtolower($position)) {
	      case 'phrase':
	        $encoded = preg_replace("/([^A-Za-z0-9!*+\/ -])/e", "'='.sprintf('%02X', ord('\\1'))", $encoded);
	        break;
	      case 'comment':
	        $encoded = preg_replace("/([\(\)\"])/e", "'='.sprintf('%02X', ord('\\1'))", $encoded);
	      case 'text':
	      default:
	        // Replace every high ascii, control =, ? and _ characters
	        //TODO using /e (equivalent to eval()) is probably not a good idea
	        $encoded = preg_replace('/([\000-\011\013\014\016-\037\075\077\137\177-\377])/e',
	              "'='.sprintf('%02X', ord('\\1'))", $encoded);
	        break;
	    }
	
	    // Replace every spaces to _ (more readable than =20)
	    $encoded = str_replace(' ', '_', $encoded);
	
	    return $encoded;
	}
	
	/**
	   * Wraps message for use with mailers that do not
	   * automatically perform wrapping and for quoted-printable.
	   * Original written by philippe.
	   * @param string $message The message to wrap
	   * @param integer $length The line length to wrap to
	   * @param boolean $qp_mode Whether to run in Quoted-Printable mode
	   * @access public
	   * @return string
	   */
	public function WrapText($message, $length, $qp_mode = false) {
	    $soft_break = ($qp_mode) ? sprintf(" =%s", $this->LE) : $this->LE;
	    // If utf-8 encoding is used, we will need to make sure we don't
	    // split multibyte characters when we wrap
	    $is_utf8 = (strtolower($this->CharSet) == "utf-8");
	
	    $message = $this->FixEOL($message);
	    if (substr($message, -1) == $this->LE) {
	      $message = substr($message, 0, -1);
	    }
	
	    $line = explode($this->LE, $message);
	    $message = '';
	    for ($i=0 ;$i < count($line); $i++) {
	      $line_part = explode(' ', $line[$i]);
	      $buf = '';
	      for ($e = 0; $e<count($line_part); $e++) {
	        $word = $line_part[$e];
	        if ($qp_mode and (strlen($word) > $length)) {
	          $space_left = $length - strlen($buf) - 1;
	          if ($e != 0) {
	            if ($space_left > 20) {
	              $len = $space_left;
	              if ($is_utf8) {
	                $len = $this->UTF8CharBoundary($word, $len);
	              } elseif (substr($word, $len - 1, 1) == "=") {
	                $len--;
	              } elseif (substr($word, $len - 2, 1) == "=") {
	                $len -= 2;
	              }
	              $part = substr($word, 0, $len);
	              $word = substr($word, $len);
	              $buf .= ' ' . $part;
	              $message .= $buf . sprintf("=%s", $this->LE);
	            } else {
	              $message .= $buf . $soft_break;
	            }
	            $buf = '';
	          }
	          while (strlen($word) > 0) {
	            $len = $length;
	            if ($is_utf8) {
	              $len = $this->UTF8CharBoundary($word, $len);
	            } elseif (substr($word, $len - 1, 1) == "=") {
	              $len--;
	            } elseif (substr($word, $len - 2, 1) == "=") {
	              $len -= 2;
	            }
	            $part = substr($word, 0, $len);
	            $word = substr($word, $len);
	
	            if (strlen($word) > 0) {
	              $message .= $part . sprintf("=%s", $this->LE);
	            } else {
	              $buf = $part;
	            }
	          }
	        } else {
	          $buf_o = $buf;
	          $buf .= ($e == 0) ? $word : (' ' . $word);
	
	          if (strlen($buf) > $length and $buf_o != '') {
	            $message .= $buf_o . $soft_break;
	            $buf = $word;
	          }
	        }
	      }
	      $message .= $buf . $this->LE;
	    }
	    return $message;
	}
  
	/**
	   * Changes every end of line from CR or LF to CRLF.
	   * @access private
	   * @return string
	   */
	private function FixEOL($str) {
	    $str = str_replace("\r\n", "\n", $str);
	    $str = str_replace("\r", "\n", $str);
	    $str = str_replace("\n", $this->LE, $str);
	    return $str;
	}

	/**
	   * Checks if a string contains multibyte characters.
	   * @access public
	   * @param string $str multi-byte text to wrap encode
	   * @return bool
	   */
	public function HasMultiBytes($str) {
	    if (function_exists('mb_strlen')) {
	      return (strlen($str) > mb_strlen($str, $this->CharSet));
	    } else { // Assume no multibytes (we can't handle without mbstring functions anyway)
	      return false;
	    }
	}
	
	/**
	   * Correctly encodes and wraps long multibyte strings for mail headers
	   * without breaking lines within a character.
	   * Adapted from a function by paravoid at http://uk.php.net/manual/en/function.mb-encode-mimeheader.php
	   * @access public
	   * @param string $str multi-byte text to wrap encode
	   * @return string
	   */
	public function Base64EncodeWrapMB($str) {
	    $start = "=?".$this->CharSet."?B?";
	    $end = "?=";
	    $encoded = "";
	
	    $mb_length = mb_strlen($str, $this->CharSet);
	    // Each line must have length <= 75, including $start and $end
	    $length = 75 - strlen($start) - strlen($end);
	    // Average multi-byte ratio
	    $ratio = $mb_length / strlen($str);
	    // Base64 has a 4:3 ratio
	    $offset = $avgLength = floor($length * $ratio * .75);
	
	    for ($i = 0; $i < $mb_length; $i += $offset) {
	      $lookBack = 0;
	
	      do {
	        $offset = $avgLength - $lookBack;
	        $chunk = mb_substr($str, $i, $offset, $this->CharSet);
	        $chunk = base64_encode($chunk);
	        $lookBack++;
	      }
	      while (strlen($chunk) > $length);
	
	      $encoded .= $chunk . $this->LE;
	    }
	
	    // Chomp the last linefeed
	    $encoded = substr($encoded, 0, -strlen($this->LE));
	    return $encoded;
	}
	
	/**
	   * Returns the server hostname or 'localhost.localdomain' if unknown.
	   * @access private
	   * @return string
	   */
	private function ServerHostname() {
	    if (!empty($this->Hostname)) {
	      $result = $this->Hostname;
	    } elseif (isset($_SERVER['SERVER_NAME'])) {
	      $result = $_SERVER['SERVER_NAME'];
	    } else {
	      $result = 'localhost.localdomain';
	    }
	
	    return $result;
	}
  
	/**
	   * Returns the message MIME.
	   * @access public
	   * @return string
	   */
	public function GetMailMIME() {
	    $result = '';
	    switch($this->message_type) {
	      case 'plain':
	        $result .= $this->HeaderLine('Content-Transfer-Encoding', $this->Encoding);
	        $result .= sprintf("Content-Type: %s; charset=\"%s\"", $this->ContentType, $this->CharSet);
	        break;
	      case 'attachments':
	      case 'alt_attachments':
	        if($this->InlineImageExists()){
	          $result .= sprintf("Content-Type: %s;%s\ttype=\"text/html\";%s\tboundary=\"%s\"%s", 'multipart/related', $this->LE, $this->LE, $this->boundary[1], $this->LE);
	        } else {
	          $result .= $this->HeaderLine('Content-Type', 'multipart/mixed;');
	          $result .= $this->TextLine("\tboundary=\"" . $this->boundary[1] . '"');
	        }
	        break;
	      case 'alt':
	        $result .= $this->HeaderLine('Content-Type', 'multipart/alternative;');
	        $result .= $this->TextLine("\tboundary=\"" . $this->boundary[1] . '"');
	        break;
	    }
	
	    if($this->Mailer != 'mail') {
	      $result .= $this->LE.$this->LE;
	    }
	    return $result;
	}
  
	/**
	   * Returns a formatted mail line.
	   * @access public
	   * @return string
	   */
	public function TextLine($value) {
	    return $value . $this->LE;
	}
  
	/**
	   * Assembles the message body.  Returns an empty string on failure.
	   * @access public
	   * @return string The assembled message body
	   */
	public function CreateBody() {
	    $body = '';
	
	    if ($this->sign_key_file) {
	      $body .= $this->GetMailMIME();
	    }
	
	    $this->SetWordWrap();
	    switch($this->message_type) {
	      case 'alt':
	        $body .= $this->GetBoundary($this->boundary[1], '', 'text/plain', '');
	        $body .= $this->EncodeString($this->AltBody, $this->Encoding);
	        $body .= $this->LE.$this->LE;
	        $body .= $this->GetBoundary($this->boundary[1], '', 'text/html', '');
	        $body .= $this->EncodeString($this->Body, $this->Encoding);
	        $body .= $this->LE.$this->LE;
	        $body .= $this->EndBoundary($this->boundary[1]);
	        break;
	      case 'plain':
	        $body .= $this->EncodeString($this->Body, $this->Encoding);
	        break;
	      case 'attachments':
	        $body .= $this->GetBoundary($this->boundary[1], '', '', '');
	        $body .= $this->EncodeString($this->Body, $this->Encoding);
	        $body .= $this->LE;
	        $body .= $this->AttachAll();
	        break;
	      case 'alt_attachments':
	        $body .= sprintf("--%s%s", $this->boundary[1], $this->LE);
	        $body .= sprintf("Content-Type: %s;%s" . "\tboundary=\"%s\"%s", 'multipart/alternative', $this->LE, $this->boundary[2], $this->LE.$this->LE);
	        $body .= $this->GetBoundary($this->boundary[2], '', 'text/plain', '') . $this->LE; // Create text body
	        $body .= $this->EncodeString($this->AltBody, $this->Encoding);
	        $body .= $this->LE.$this->LE;
	        $body .= $this->GetBoundary($this->boundary[2], '', 'text/html', '') . $this->LE; // Create the HTML body
	        $body .= $this->EncodeString($this->Body, $this->Encoding);
	        $body .= $this->LE.$this->LE;
	        $body .= $this->EndBoundary($this->boundary[2]);
	        $body .= $this->AttachAll();
	        break;
	    }
		if ($this->IsError()) {
	        $body = '';
	    }
	    return $body;
	}
	
	/**
	   * Returns the start of a message boundary.
	   * @access private
	   */
	private function GetBoundary($boundary, $charSet, $contentType, $encoding){
	    $result = '';
	    if($charSet == '') {
	      $charSet = $this->CharSet;
	    }
	    if($contentType == '') {
	      $contentType = $this->ContentType;
	    }
	    if($encoding == '') {
	      $encoding = $this->Encoding;
	    }
	    $result .= $this->TextLine('--' . $boundary);
	    $result .= sprintf("Content-Type: %s; charset = \"%s\"", $contentType, $charSet);
	    $result .= $this->LE;
	    $result .= $this->HeaderLine('Content-Transfer-Encoding', $encoding);
	    $result .= $this->LE;
		
	    return $result;
	}
	
	/**
	   * Set the body wrapping.
	   * @access public
	   * @return void
	   */
	public function SetWordWrap() {
	    if($this->WordWrap < 1) {
	      return;
	    }
	    switch($this->message_type) {
	      case 'alt':
	      case 'alt_attachments':
	        $this->AltBody = $this->WrapText($this->AltBody, $this->WordWrap);
	        break;
	      default:
	        $this->Body = $this->WrapText($this->Body, $this->WordWrap);
	        break;
	    }
	}
	
	/**
	   * Encodes string to requested format.
	   * Returns an empty string on failure.
	   * @param string $str The text to encode
	   * @param string $encoding The encoding to use; one of 'base64', '7bit', '8bit', 'binary', 'quoted-printable'
	   * @access public
	   * @return string
	   */
 	public function EncodeString ($str, $encoding = 'base64') {
	    $encoded = '';
	    switch(strtolower($encoding)) {
	      case 'base64':
	        $encoded = chunk_split(base64_encode($str), 76, $this->LE);
	        break;
	      case '7bit':
	      case '8bit':
	        $encoded = $this->FixEOL($str);
	        //Make sure it ends with a line break
	        if (substr($encoded, -(strlen($this->LE))) != $this->LE)
	          $encoded .= $this->LE;
	        break;
	      case 'binary':
	        $encoded = $str;
	        break;
	      case 'quoted-printable':
	        $encoded = $this->EncodeQP($str);
	        break;
	      default:
	        $this->SetError($this->Lang('encoding') . $encoding);
	        break;
	    }
	    
	    return $encoded;
	}
	
	/**
	   * Returns the end of a message boundary.
	   * @access private
	   */
	private function EndBoundary($boundary) {
	    return $this->LE . '--' . $boundary . '--' . $this->LE;
	}
  
	/**
	   * Attaches all fs, string, and binary attachments to the message.
	   * Returns an empty string on failure.
	   * @access private
	   * @return string
	   */
    private function AttachAll() {
    // Return text of body
	    $mime = array();
	    $cidUniq = array();
	    $incl = array();

    // Add all attachments
	    foreach ($this->attachment as $attachment) {
	      // Check for string attachment
	      $bString = $attachment[5];
	      if ($bString) {
	        $string = $attachment[0];
	      } else {
	        $path = $attachment[0];
	      }

	      if (in_array($attachment[0], $incl)) { continue; }
	      $filename    = $attachment[1];
	      $name        = $attachment[2];
	      $encoding    = $attachment[3];
	      $type        = $attachment[4];
	      $disposition = $attachment[6];
	      $cid         = $attachment[7];
	      $incl[]      = $attachment[0];
	      if ( $disposition == 'inline' && isset($cidUniq[$cid]) ) { continue; }
	      $cidUniq[$cid] = true;

	      $mime[] = sprintf("--%s%s", $this->boundary[1], $this->LE);
	      $mime[] = sprintf("Content-Type: %s; name=\"%s\"%s", $type, $this->EncodeHeader($this->SecureHeader($name)), $this->LE);
	      $mime[] = sprintf("Content-Transfer-Encoding: %s%s", $encoding, $this->LE);
	
	      if($disposition == 'inline') {
	        	$mime[] = sprintf("Content-ID: <%s>%s", $cid, $this->LE);
	      }

	      $mime[] = sprintf("Content-Disposition: %s; filename=\"%s\"%s", $disposition, $this->EncodeHeader($this->SecureHeader($name)), $this->LE.$this->LE);
	
	      // Encode as string attachment
	      if($bString) {
		        $mime[] = $this->EncodeString($string, $encoding);
		        if($this->IsError()) {
		          return '';
		        }
		        $mime[] = $this->LE.$this->LE;
	      } else {
		        $mime[] = $this->EncodeFile($path, $encoding);
		        if($this->IsError()) {
		          return '';
		        }
		        $mime[] = $this->LE.$this->LE;
	      }
    	}

	    $mime[] = sprintf("--%s--%s", $this->boundary[1], $this->LE);
	
	    return join('', $mime);
	}
  
	/**
	   * Returns true if an error occurred.
	   * @access public
	   * @return bool
	   */
	public function IsError() {
	    return ($this->error_count > 0);
	}
  
	/**
	   * Returns true if an inline attachment is present.
	   * @access public
	   * @return bool
	   */
	public function InlineImageExists() {
	    foreach($this->attachment as $attachment) {
	      if ($attachment[6] == 'inline') {
	        return true;
	      }
	    }
	    return false;
	}
	
	/**
	   * Returns true if connected to a server otherwise false
	   * @access public
	   * @return bool
	   */
	public function Connected() {
	    if(!empty($this->smtp_conn)) {
	      $sock_status = socket_get_status($this->smtp_conn);
	      if($sock_status["eof"]) {
	        // the socket is valid but we are not connected
	        if($this->do_debug >= 1) {
	            echo "SMTP -> NOTICE:" . $this->CRLF . "EOF caught while checking if connected";
	        }
	        $this->Close();
	        return false;
	      }
	      return true; // everything looks good
	    }
	    return false;
	}
	
	/**
	   * Closes the socket and cleans up the state of the class.
	   * It is not considered good to use this function without
	   * first trying to use QUIT.
	   * @access public
	   * @return void
	   */
	public function Close() {
	    $this->error = null; // so there is no confusion
	    $this->helo_rply = null;
	    if(!empty($this->smtp_conn)) {
	      // close the connection and cleanup
	      fclose($this->smtp_conn);
	      $this->smtp_conn = 0;
	    }
	}
	
	/**
	   * Connect to the server specified on the port specified.
	   * If the port is not specified use the default SMTP_PORT.
	   * If tval is specified then a connection will try and be
	   * established with the server for that number of seconds.
	   * If tval is not specified the default is 30 seconds to
	   * try on the connection.
	   *
	   * SMTP CODE SUCCESS: 220
	   * SMTP CODE FAILURE: 421
	   * @access public
	   * @return bool
	   */
	public function Connect($host, $port = 0, $tval = 30) {
	    // set the error val to null so there is no confusion
	    $this->error = null;
	
	    // make sure we are __not__ connected
	    if($this->connected()) {
	      // already connected, generate error
	      $this->error = array("error" => "Already connected to a server");
	      return false;
	    }
	
	    if(empty($port)) {
	      $port = $this->SMTP_PORT;
	    }
	
	    // connect to the smtp server
	    $this->smtp_conn = @fsockopen($host,    // the host of the server
	                                 $port,    // the port to use
	                                 $errno,   // error number if any
	                                 $errstr,  // error message if any
	                                 $tval);   // give up after ? secs
	    // verify we connected properly
	    if(empty($this->smtp_conn)) {
	      $this->error = array("error" => "Failed to connect to server",
	                           "errno" => $errno,
	                           "errstr" => $errstr);
	      if($this->do_debug >= 1) {
	        echo "SMTP -> ERROR: " . $this->error["error"] . ": $errstr ($errno)" . $this->CRLF . '<br />';
	      }
	      return false;
	    }
	
	    // SMTP server can take longer to respond, give longer timeout for first read
	    // Windows does not have support for this timeout function
	    if(substr(PHP_OS, 0, 3) != "WIN")
	     socket_set_timeout($this->smtp_conn, $tval, 0);
	
	    // get any announcement
	    $announce = $this->get_lines();
	
	    if($this->do_debug >= 2) {
	      echo "SMTP -> FROM SERVER:" . $announce . $this->CRLF . '<br />';
	    }
	
	    return true;
	}
	
	/**
	   * Read in as many lines as possible
	   * either before eof or socket timeout occurs on the operation.
	   * With SMTP we can tell if we have more lines to read if the
	   * 4th character is '-' symbol. If it is a space then we don't
	   * need to read anything else.
	   * @access private
	   * @return string
	   */
	private function get_lines() {
	    $data = "";
	    while($str = @fgets($this->smtp_conn,515)) {
	      if($this->do_debug >= 4) {
	        echo "SMTP -> get_lines(): \$data was \"$data\"" . $this->CRLF . '<br />';
	        echo "SMTP -> get_lines(): \$str is \"$str\"" . $this->CRLF . '<br />';
	      }
	      $data .= $str;
	      if($this->do_debug >= 4) {
	        echo "SMTP -> get_lines(): \$data is \"$data\"" . $this->CRLF . '<br />';
	      }
	      // if 4th character is a space, we are done reading, break the loop
	      if(substr($str,3,1) == " ") { break; }
	    }
	    return $data;
	}
	
	/**
	   * Starts a mail transaction from the email address specified in
	   * $from. Returns true if successful or false otherwise. If True
	   * the mail transaction is started and then one or more Recipient
	   * commands may be called followed by a Data command.
	   *
	   * Implements rfc 821: MAIL <SP> FROM:<reverse-path> <CRLF>
	   *
	   * SMTP CODE SUCCESS: 250
	   * SMTP CODE SUCCESS: 552,451,452
	   * SMTP CODE SUCCESS: 500,501,421
	   * @access public
	   * @return bool
	   */
	public function Mail($from) {
	    $this->error = null; // so no confusion is caused
	
	    if(!$this->connected()) {
	      $this->error = array(
	              "error" => "Called Mail() without being connected");
	      return false;
	    }
	
	    $useVerp = ($this->do_verp ? "XVERP" : "");
	    fputs($this->smtp_conn,"MAIL FROM:<" . $from . ">" . $useVerp . $this->CRLF);
	
	    $rply = $this->get_lines();
	    $code = substr($rply,0,3);
	
	    if($this->do_debug >= 2) {
	      echo "SMTP -> FROM SERVER:" . $rply . $this->CRLF . '<br />';
	    }
	
	    if($code != 250) {
	      $this->error =
	        array("error" => "MAIL not accepted from server",
	              "smtp_code" => $code,
	              "smtp_msg" => substr($rply,4));
	      if($this->do_debug >= 1) {
	        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
	      }
	      return false;
	    }
	    return true;
	}
	
	/**
	   * Sends the command RCPT to the SMTP server with the TO: argument of $to.
	   * Returns true if the recipient was accepted false if it was rejected.
	   *
	   * Implements from rfc 821: RCPT <SP> TO:<forward-path> <CRLF>
	   *
	   * SMTP CODE SUCCESS: 250,251
	   * SMTP CODE FAILURE: 550,551,552,553,450,451,452
	   * SMTP CODE ERROR  : 500,501,503,421
	   * @access public
	   * @return bool
	   */
	public function Recipient($to) {
	    $this->error = null; // so no confusion is caused
	
	    if(!$this->connected()) {
	      $this->error = array(
	              "error" => "Called Recipient() without being connected");
	      return false;
	    }
	
	    fputs($this->smtp_conn,"RCPT TO:<" . $to . ">" . $this->CRLF);
	
	    $rply = $this->get_lines();
	    $code = substr($rply,0,3);
	
	    if($this->do_debug >= 2) {
	      echo "SMTP -> FROM SERVER:" . $rply . $this->CRLF . '<br />';
	    }
	
	    if($code != 250 && $code != 251) {
	      $this->error =
	        array("error" => "RCPT not accepted from server",
	              "smtp_code" => $code,
	              "smtp_msg" => substr($rply,4));
	      if($this->do_debug >= 1) {
	        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
	      }
	      return false;
	    }
	    return true;
	}
	
	/**
	   * Issues a data command and sends the msg_data to the server
	   * finializing the mail transaction. $msg_data is the message
	   * that is to be send with the headers. Each header needs to be
	   * on a single line followed by a <CRLF> with the message headers
	   * and the message body being seperated by and additional <CRLF>.
	   *
	   * Implements rfc 821: DATA <CRLF>
	   *
	   * SMTP CODE INTERMEDIATE: 354
	   *     [data]
	   *     <CRLF>.<CRLF>
	   *     SMTP CODE SUCCESS: 250
	   *     SMTP CODE FAILURE: 552,554,451,452
	   * SMTP CODE FAILURE: 451,554
	   * SMTP CODE ERROR  : 500,501,503,421
	   * @access public
	   * @return bool
	   */
	public function Data($msg_data) {
	    $this->error = null; // so no confusion is caused
	
	    if(!$this->connected()) {
	      $this->error = array(
	              "error" => "Called Data() without being connected");
	      return false;
	    }
	
	    fputs($this->smtp_conn,"DATA" . $this->CRLF);
	
	    $rply = $this->get_lines();
	    $code = substr($rply,0,3);
	
	    if($this->do_debug >= 2) {
			echo "SMTP -> FROM SERVER:" . $rply . $this->CRLF . '<br />';
	    }
	
	    if($code != 354) {
	        $this->error =
				array("error" => "DATA command not accepted from server",
					"smtp_code" => $code,
					"smtp_msg" => substr($rply,4));
			if($this->do_debug >= 1) {
				echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
			}
			return false;
		}
	 
	    /* the server is ready to accept data!
	     * according to rfc 821 we should not send more than 1000
	     * including the CRLF
	     * characters on a single line so we will break the data up
	     * into lines by \r and/or \n then if needed we will break
	     * each of those into smaller lines to fit within the limit.
	     * in addition we will be looking for lines that start with
	     * a period '.' and append and additional period '.' to that
	     * line. NOTE: this does not count towards limit.
	     */
	
	    // normalize the line breaks so we know the explode works
	    $msg_data = str_replace("\r\n","\n",$msg_data);
	    $msg_data = str_replace("\r","\n",$msg_data);
	    $lines = explode("\n",$msg_data);

	    /* we need to find a good way to determine is headers are
	     * in the msg_data or if it is a straight msg body
	     * currently I am assuming rfc 822 definitions of msg headers
	     * and if the first field of the first line (':' sperated)
	     * does not contain a space then it _should_ be a header
	     * and we can process all lines before a blank "" line as
	     * headers.
	     */

	    $field = substr($lines[0],0,strpos($lines[0],":"));
	    $in_headers = false;
	    if(!empty($field) && !strstr($field," ")) {
			$in_headers = true;
	    }

	    $max_line_length = 998; // used below; set here for ease in change
	
	    while(list(,$line) = @each($lines)) {
			$lines_out = null;
			if($line == "" && $in_headers) {
				$in_headers = false;
			}
     		// ok we need to break this line up into several smaller lines
			while(strlen($line) > $max_line_length) {
	       		$pos = strrpos(substr($line,0,$max_line_length)," ");
	
		        // Patch to fix DOS attack
		        if(!$pos) {
		          $pos = $max_line_length - 1;
		          $lines_out[] = substr($line,0,$pos);
		          $line = substr($line,$pos);
		        } else {
		          $lines_out[] = substr($line,0,$pos);
		          $line = substr($line,$pos + 1);
		        }
	
		        /* if processing headers add a LWSP-char to the front of new line
		         * rfc 822 on long msg headers
		         */
		        if($in_headers) {
		          $line = "\t" . $line;
		        }
     		}
			$lines_out[] = $line;

     		// send the lines to the server
			while(list(,$line_out) = @each($lines_out)) {
		        if(strlen($line_out) > 0)
		        {
		          if(substr($line_out, 0, 1) == ".") {
		            $line_out = "." . $line_out;
		          }
		    	}
	        	fputs($this->smtp_conn,$line_out . $this->CRLF);
	     	}
   		}

	    // message data has been sent
	    fputs($this->smtp_conn, $this->CRLF . "." . $this->CRLF);
	
	    $rply = $this->get_lines();
	    $code = substr($rply,0,3);
	
	    if($this->do_debug >= 2) {
	      echo "SMTP -> FROM SERVER:" . $rply . $this->CRLF . '<br />';
	    }

	    if($code != 250) {
	      $this->error =
	        array("error" => "DATA not accepted from server",
	              "smtp_code" => $code,
	              "smtp_msg" => substr($rply,4));
	      if($this->do_debug >= 1) {
	        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
	      }
	      return false;
	    }
		return true;
	}
	
	/**
	   * Sends the RSET command to abort and transaction that is
	   * currently in progress. Returns true if successful false
	   * otherwise.
	   *
	   * Implements rfc 821: RSET <CRLF>
	   *
	   * SMTP CODE SUCCESS: 250
	   * SMTP CODE ERROR  : 500,501,504,421
	   * @access public
	   * @return bool
	   */
	public function Reset() {
	    $this->error = null; // so no confusion is caused
	
	    if(!$this->connected()) {
	      $this->error = array(
	              "error" => "Called Reset() without being connected");
	      return false;
	    }
	
	    fputs($this->smtp_conn,"RSET" . $this->CRLF);
	
	    $rply = $this->get_lines();
	    $code = substr($rply,0,3);
	
	    if($this->do_debug >= 2) {
	      echo "SMTP -> FROM SERVER:" . $rply . $this->CRLF . '<br />';
	    }
	
	    if($code != 250) {
	      $this->error =
	        array("error" => "RSET failed",
	              "smtp_code" => $code,
	              "smtp_msg" => substr($rply,4));
	      if($this->do_debug >= 1) {
	        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
	      }
	      return false;
	    }
	
	    return true;
	}
	
	/**
	   * Sends the HELO command to the smtp server.
	   * This makes sure that we and the server are in
	   * the same known state.
	   *
	   * Implements from rfc 821: HELO <SP> <domain> <CRLF>
	   *
	   * SMTP CODE SUCCESS: 250
	   * SMTP CODE ERROR  : 500, 501, 504, 421
	   * @access public
	   * @return bool
	   */
	public function Hello($host = '') {
	    $this->error = null; // so no confusion is caused
	
	    if(!$this->connected()) {
	      $this->error = array(
	            "error" => "Called Hello() without being connected");
	      return false;
	    }
	
	    // if hostname for HELO was not specified send default
	    if(empty($host)) {
	      // determine appropriate default to send to server
	      $host = "localhost";
	    }
	
	    // Send extended hello first (RFC 2821)
	    if(!$this->SendHello("EHLO", $host)) {
	      if(!$this->SendHello("HELO", $host)) {
	        return false;
	      }
	    }
	
	    return true;
	}
	
	/**
	   * Sends a HELO/EHLO command.
	   * @access private
	   * @return bool
	   */
	private function SendHello($hello, $host) {
	    fputs($this->smtp_conn, $hello . " " . $host . $this->CRLF);
	
	    $rply = $this->get_lines();
	    $code = substr($rply,0,3);
	
	    if($this->do_debug >= 2) {
	      echo "SMTP -> FROM SERVER: " . $rply . $this->CRLF . '<br />';
	    }
	
	    if($code != 250) {
	      $this->error =
	        array("error" => $hello . " not accepted from server",
	              "smtp_code" => $code,
	              "smtp_msg" => substr($rply,4));
	      if($this->do_debug >= 1) {
	        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
	      }
	      return false;
	    }
	
	    $this->helo_rply = $rply;
	
	    return true;
	}
	
	/**
	   * Performs SMTP authentication.  Must be run after running the
	   * Hello() method.  Returns true if successfully authenticated.
	   * @access public
	   * @return bool
	   */
	public function Authenticate($username, $password) {
	    // Start authentication
	    fputs($this->smtp_conn,"AUTH LOGIN" . $this->CRLF);
	
	    $rply = $this->get_lines();
	    $code = substr($rply,0,3);
	
	    if($code != 334) {
	      $this->error =
	        array("error" => "AUTH not accepted from server",
	              "smtp_code" => $code,
	              "smtp_msg" => substr($rply,4));
	      if($this->do_debug >= 1) {
	        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
	      }
	      return false;
	    }
	
	    // Send encoded username
	    fputs($this->smtp_conn, base64_encode($username) . $this->CRLF);
	
	    $rply = $this->get_lines();
	    $code = substr($rply,0,3);
	
	    if($code != 334) {
	      $this->error =
	        array("error" => "Username not accepted from server",
	              "smtp_code" => $code,
	              "smtp_msg" => substr($rply,4));
	      if($this->do_debug >= 1) {
	        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
	      }
	      return false;
	    }
	
	    // Send encoded password
	    fputs($this->smtp_conn, base64_encode($password) . $this->CRLF);
	
	    $rply = $this->get_lines();
	    $code = substr($rply,0,3);
	
	    if($code != 235) {
	      $this->error =
	        array("error" => "Password not accepted from server",
	              "smtp_code" => $code,
	              "smtp_msg" => substr($rply,4));
	      if($this->do_debug >= 1) {
	        echo "SMTP -> ERROR: " . $this->error["error"] . ": " . $rply . $this->CRLF . '<br />';
	      }
	      return false;
	    }
	
	    return true;
	}
}