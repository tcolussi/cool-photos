<?php
    include_once "fbmain.php";
?>

<!DOCTYPE html>

<!-- BEGIN html -->
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">

<!-- BEGIN head -->
<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

<title>Cool Photos</title>

<!-- Favicon -->
<link rel="shortcut icon" href="images/favicon.png" />

<!-- Stylesheet -->
<link type="text/css" href="css/style.css" rel="stylesheet" />
<link type="text/css" href="css/jquery.ui.theme.css" rel="stylesheet" />
<link type="text/css" href="http://fonts.googleapis.com/css?family=Droid+Sans:rerular,italic,bold,bolditalic" rel="stylesheet" />
<!--[if lt IE 9]>
	<link rel="stylesheet" href="css/ie.css" type="text/css" media="screen" />
<![endif]-->

<!-- END head -->
</head>

<!-- BEGIN body -->
<body>

<div id="preloader"></div>

<div id="header" class="inner">

  <div class="logo left">

    <img src="images/logo.png" alt="Cool Photos" />

    <div class="like-button">

      <fb:like href="http://www.facebook.com/thevolumens" layout="button_count"></fb:like>

    </div><!--like-button-->

  </div><!--logo-->

  <div class="profile right">

    <a class="trigger">Hello, <strong><?php echo $user_profile['name']; ?></strong><span></span></a>

    <div class="tooltip">
      <ul>
		<li><a href="<?php echo $user_profile['link']; ?>" target="_blank"><span>Profile</span></a></li>
        <li><a href="#" onclick="feedDialog(); return false;"><span>Share</span></a></li>
        <li><a href="#" onClick="requestsDialog(); return false;"><span>Invite</span></a></li>
      </ul>
    </div><!--tooltip-->

  </div><!--profile-->

</div><!--header-->

<div id="main" class="clearfix">

  <div id="left-add" class="banner">

	<script type="text/javascript">
		google_ad_client = "ca-pub-5997029164354874";
		google_ad_slot = "8599768551";
		google_ad_width = 120;
		google_ad_height = 600;
    </script>
    <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>

  </div><!--left-add-->

  <div id="right-add" class="banner">

	<script type="text/javascript">
		google_ad_client = "ca-pub-5997029164354874";
		google_ad_slot = "2553234954";
		google_ad_width = 120;
		google_ad_height = 600;
    </script>
    <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>

  </div><!--right-add-->

  <?php
	if (isset($_GET['res'])) {
	  if ($_GET['res'] == 'true'){
  ?>

  <div class="alert clearfix" id="success">

    <p>Photo generated successfully. You can create another picture if you like...</p>

  </div><!--success-->

  <?php
      }
    if ($_GET['res'] == 'false'){
  ?>

  <div class="alert clearfix" id="error">

    <p>An error has occurred, please try again...</p>

  </div><!--error-->

  <?php
	}
  }
  ?>

  <div class="alert clearfix" id="loading" >

	<p>Please wait while your photo is generated and uploaded to Facebook...</p>

  </div><!--loading-->

  <div id="wrap">

    <div id="fixer" class="clearfix">

      <div id="elements">

        <div class="object"><img id="object1" width="43" height="18" class="ui-widget-content" src="elements/glasses1.png" alt=""/></div>
        <div class="object"><img id="object2" width="43" height="18" class="ui-widget-content" src="elements/glasses2.png" alt=""/></div>
        <div class="object"><img id="object3" width="43" height="19" class="ui-widget-content" src="elements/glasses3.png" alt=""/></div>
        <div class="object"><img id="object4" width="43" height="18" class="ui-widget-content" src="elements/glasses4.png" alt=""/></div>
        <div class="object"><img id="object5" width="43" height="19" class="ui-widget-content" src="elements/glasses5.png" alt=""/></div>
        <div class="object"><img id="object6" width="43" height="17" class="ui-widget-content" src="elements/glasses6.png" alt=""/></div>
        <div class="object"><img id="object13" width="43" height="30" class="ui-widget-content" src="elements/mustache1.png" alt=""/></div>
        <div class="object"><img id="object14" width="43" height="26" class="ui-widget-content" src="elements/mustache2.png" alt=""/></div>
        <div class="object"><img id="object15" width="43" height="22" class="ui-widget-content" src="elements/mustache3.png" alt=""/></div>
        <div class="object"><img id="object16" width="43" height="20" class="ui-widget-content" src="elements/mustache4.png" alt=""/></div>
        <div class="object"><img id="object17" width="43" height="20" class="ui-widget-content" src="elements/mustache5.png" alt=""/></div>
        <div class="object"><img id="object18" width="43" height="31" class="ui-widget-content" src="elements/mustache6.png" alt=""/></div>
		<div class="object"><img id="object19" width="43" height="29" class="ui-widget-content" src="elements/hat1.png" alt=""/></div>
        <div class="object"><img id="object20" width="43" height="44" class="ui-widget-content" src="elements/hat2.png" alt=""/></div>
        <div class="object"><img id="object21" width="43" height="31" class="ui-widget-content" src="elements/hat3.png" alt=""/></div>
        <div class="object"><img id="object22" width="43" height="35" class="ui-widget-content" src="elements/hat4.png" alt=""/></div>
        <div class="object"><img id="object23" width="43" height="29" class="ui-widget-content" src="elements/hat5.png" alt=""/></div>
        <div class="object"><img id="object24" width="43" height="28" class="ui-widget-content" src="elements/hat6.png" alt=""/></div>
		<div class="object"><img id="object25" width="43" height="20" class="ui-widget-content" src="elements/lips1.png" alt=""/></div>
        <div class="object"><img id="object26" width="43" height="25" class="ui-widget-content" src="elements/lips2.png" alt=""/></div>
        <div class="object"><img id="object27" width="43" height="21" class="ui-widget-content" src="elements/lips3.png" alt=""/></div>
        <div class="object"><img id="object28" width="43" height="21" class="ui-widget-content" src="elements/lips4.png" alt=""/></div>
        <div class="object"><img id="object29" width="43" height="22" class="ui-widget-content" src="elements/lips5.png" alt=""/></div>
        <div class="object"><img id="object30" width="43" height="22" class="ui-widget-content" src="elements/lips6.png" alt=""/></div>

      </div><!--elements-->

    </div><!--fixer-->

  </div><!--wrap-->

  <div id="picture">

    <?php $destination = $code2."_uploaded_photo"; ?>

    <input type="text" name="description" onclick="this.value='';" onblur="this.value=!this.value?'Add a description...':this.value;" value="Add a description..." id="description">

    <form action="upload.php" method="post" name="image_upload" id="image_upload" enctype="multipart/form-data">
      <input type="hidden" name="uploaded_photo" value="<?php echo $destination;?>">
      <div id="upload">
        <input type="file" name="uploadfile" onchange="ajaxUpload(this.form);" />
        <span>Add Picture</span>
      </div>
      <div id="background" class="clearfix"></div>
    </form>

    <form id="jsonform" action="index.php" method="post" onsubmit="getImageData();">
      <input type="hidden" name="action" value="upload_fb_image">
      <input type="hidden" name="photo" id="photo_path" value="">
      <input type="hidden" name="message" id="message" value="">
      <input id="submit" type="submit" value="Upload to Facebook"/>
      <input id="jsondata" name="jsondata" type="hidden" value="Upload to Facebook" autocomplete="off">
    </form>

  </div><!--picture-->

  <div id="tools"></div>

</div><!--main-->

<div id="steps" class="clearfix">

  <div class="column">

    <h3>Choose</h3>

    <p><span class="number">1</span>Add a picture and then drag the elements in the left box to put them on it. Now ajust each element by making them bigger or smaller and rotating them to fit well in the picture.</p>

  </div><!--column-->

  <div class="column">

    <h3>Upload</h3>

    <p><span class="number">2</span>When you have your elements selected, press the "Upload to Facebook" button and automatically save the picture into a new photo album in your profile. You can also add a description for your picture.</p>

  </div><!--column-->

  <div class="column" id="last">

    <h3>Share</h3>

    <p><span class="number">3</span>Now share this awesome app with your friends by clicking the "like" button, post it in your profile by clicking the "share it" button or send an invitation by email by clicking the "invite" button.</p>

  </div><!--column-->

</div><!--steps-->

<div id="footer">

  <div class="inner clearfix">

    <p class="left">Cool Photos © <?php echo date("Y") ?> | All Rights Reserved</p>

    <p class="right">Developed by <a href="http://www.volumens.com" target="_blank">Volumens</a></p>

  </div><!--inner-->

</div><!--footer-->

<!-- JS Scripts -->
<script type="text/javascript" src="js/jquery.min.js?ver=1.8.2"></script>
<script type="text/javascript" src="js/jquery.ui.min.js?ver=1.8.24"></script>
<script type="text/javascript" src="js/jquery.tools.min.js?ver=1.2.7"></script>
<script type="text/javascript" src="js/jquery.rotate.min.js?ver=0.1"></script>
<script type="text/javascript" src="js/jquery.json.min.js?ver=1.0"></script>
<script type="text/javascript" src="js/jquery.upload.min.js?ver=1.1"></script>
<script type="text/javascript" src="js/jquery.custom.js?ver=1.0"></script>

<script type="text/javascript">

	// Feed Dialog
	function feedDialog() {
		FB.ui({
			method: 'feed',
			link: 'http://apps.volumens.com/cool-photos/',
			picture: 'http://apps.volumens.com/cool-photos/images/thumbnail.png',
			name: 'Cool Photos',
			caption: 'Facebook Application',
			description: 'Have fun adding funny elements to your photos and share them with your friends'
        });
	}

	// Requests Dialog
	function requestsDialog(){
		var receiverUserIds = FB.ui({
			method : 'apprequests',
			message: 'Have fun adding funny elements to your photos and share them with your friends'
		});
	}

</script>

<div id="fb-root"></div>
<script type="text/javascript" src="https://connect.facebook.net/en_US/all.js"></script>
<script type="text/javascript">
	FB.init({
		appId  : '<?= $_CONFIG['appid'] ?>',
		status : true, // Check login status
		cookie : true, // Enable cookies to allow the server to access the session
		xfbml  : true  // Parse XFBML
	});
</script>

</body>
<!-- END body -->

</html>
<!-- END html -->
