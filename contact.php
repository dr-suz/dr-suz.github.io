
<?php if(!isset($_POST['send'])) { ?>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <noscript><input type="hidden" name="havejs" id="havejs"></noscript>
    <input type="hidden" name="send" value="send">
    <!-- spam bait - if the bcc field contains anything, this email is rejected -->
    <!--<input type="text" name="bcc" />-->
    <!--<label for="bcc">Bcc</label>-->

    <p><input type="text" name="name" required><label for="name">Name</label></p>
    <p><input type="text" name="phone" required><label for="phone">Phone</label></p>
    <p><input type="email" name="email" required><label for="email">Email</label></p>
    <p><textarea name="message" required></textarea><label for="message">Message</label></p>
    <p><input type="submit" value="Send message"></p>
  </form>
<?php
}

if(isset($_POST['send'])) {
  // extra check for non-HTML pages/browsers
  function chip_get_my_valid_email($email) {
    return preg_match('#^[a-z0-9.!\#$%&\'*+-/=?^_`{|}~]+@([0-9.]+|([^\s]+\.+[a-z]{2,6}))$#si', $email);
  }
  function chip_get_my_bot() {
    $bots = array("Indy", "Blaiz", "Java", "libwww-perl", "Python", "OutfoxBot", "User-Agent", "PycURL", "AlphaServer", "T8Abot", "Syntryx", "WinHttp", "WebBandit", "nicebot", "Teoma", "alexa", "froogle", "inktomi", "looksmart", "URL_Spider_SQL", "Firefly", "NationalDirectory", "Ask Jeeves", "TECNOSEEK", "InfoSeek", "WebFindBot", "girafabot", "crawler", "www.galaxy.com", "Googlebot", "Scooter", "Slurp", "appie", "FAST", "WebBug", "Spade", "ZyBorg", "rabaz");
    foreach($bots as $bot)
      if(stripos($_SERVER['HTTP_USER_AGENT'], $bot) !== false)
        return true;
      if(empty($_SERVER['HTTP_USER_AGENT']) || $_SERVER['HTTP_USER_AGENT'] == " ")
        return true;
    return false;
  }
  function chip_get_my_clean_string($string) {
    $bad = array('content-type', 'bcc:', 'to:', 'cc:', 'href');
    return str_replace($bad, '', $string);
  }
  function chip_get_my_ip() {
    if(!empty($_SERVER['HTTP_CLIENT_IP']))
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else
      $ip = $_SERVER['REMOTE_ADDR'];
    return $ip;
  }

  $bcc    = filter_var($_POST['bcc'], FILTER_SANITIZE_STRING);

  $name     = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
  $phone    = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
  $email    = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

  $message  = filter_var($_POST['message'], FILTER_SANITIZE_SPECIAL_CHARS);
  $message  = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

  $name     = chip_get_my_clean_string($name);
  $phone    = chip_get_my_clean_string($phone);
  $email    = chip_get_my_clean_string($email);
  $message  = chip_get_my_clean_string($message);

  // HEADERS
  $headers = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

  // Additional headers
  $headers .= 'To: Recipient Name <info@domain.com' . "\r\n";
  $headers .= 'From: Sender Name <info@domain.com>' . "\r\n";

  $headers .= 'Reply-To: info@domain.com' . "\r\n";
  $headers .='X-Mailer: PHP/' . phpversion();

  $subject = "Your Email Subject Here";
  $mail = "recipient@domain.com";

  $message=' 
    <strong>Name:</strong> ' . $name . '<br>
    <strong>Phone:</strong> ' . $phone . '<br>
    <strong>Email:</strong> ' . $email . '<br>
    <strong>Message:</strong> ' . $message . '<br><br>
    Message from http://dr-suz.github.io/<br><br>
    ==<br>
    <small><strong>Sender IP:</strong> ' . chip_get_my_ip() . '</small><br>
    <small><strong>Sender Browser:</strong> ' . $_SERVER['HTTP_USER_AGENT'] . '</small><br>
    <small><strong>Sender OS:</strong> ' . $_SERVER['SERVER_SOFTWARE'] . '</small>
  ';

  if($bcc == '' && !isset($_POST['havejs']) && $name != '' && $email != '' && $message != '' && chip_get_my_valid_email($email) && $_SERVER['REQUEST_METHOD'] == 'POST' && chip_get_my_bot() == false) {
    mail($mail, $subject, $message, $headers);
    echo '<p>Message sent!</p><p>Thank you!</p>';
  }
  else {
    echo '<p>Error!</p><p>Please fill in all fields!</p>';
  }
}
?>
<!DOCTYPE HTML>
<html>

<head>
  <title>Suzanne's website</title>
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <!-- modernizr enables HTML5 elements and feature detects -->
  <script type="text/javascript" src="js/modernizr-1.5.min.js"></script>
</head>

<body>
  <div id="main">
    <header>
      <div id="logo"><h1>S.Thornton</h1></div>
      <nav>
        <ul class="lavaLampWithImage" id="lava_menu">
          <li><a href="index.html">home</a></li>
          <li><a href="about.html">about me</a></li>
          <li><a href="portfolio.html">my portfolio</a></li>
          <li><a href="fun.html">just for fun</a></li> 
          <li class="current"><a href="contact.php">contact</a></li>
        </ul>
      </nav>
    </header>
    <div id="site_content">
      <div id="sidebar_container">
        <div> <!-- id="gallery"> -->
          <ul class="images">
            <li class="show"> <!--<img width="450" height="450" src="images/1.jpg" alt="photo_one" /></li>
            <li><img width="450" height="450" src="images/2.jpg" alt="photo_two" /></li> -->
            <li><img width="450" height="450" src="images/3.jpg" alt="photo_three" /></li>
            <!-- <li><img width="450" height="450" src="images/4.jpg" alt="photo_four" /></li>
            <li><img width="450" height="450" src="images/5.jpg" alt="photo_five" /></li> -->
          </ul>
        </div>
      </div>
      <div id="content">
        <h1>Contact</h1>
        <form id="contact" action="contact.php" method="post">
          <div class="form_settings">
            
          </div>
        </form>
      </div>
    </div>
    <footer>
      <p><a href="index.html">home</a> | <a href="about.html">about me</a> | <a href="portfolio.html">my portfolio</a> | <a href="fun.html">just for fun</a> --> | <a href="contact.php">contact</a></p>
      <p>&copy; 2012 my portfolio two. All Rights Reserved. | <a href="http://www.css3templates.co.uk">design from css3templates.co.uk</a></p>
    </footer>
  </div>
  <!-- javascript at the bottom for fast page loading -->
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/jquery.easing.min.js"></script>
  <script type="text/javascript" src="js/jquery.lavalamp.min.js"></script>
  <!-- <script type="text/javascript" src="js/image_fade.js"></script> -->
  <script type="text/javascript">
    $(function() {
      $("#lava_menu").lavaLamp({
        fx: "backout",
        speed: 700
      });
    });
  </script>
</body>
</html>

