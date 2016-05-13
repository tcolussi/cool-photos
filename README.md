# Cool Photos - Facebook App

 <h3><strong>Introduction</strong></h3>
  <p>The first thing you have to do is to decide which color and background you are going to use for the app. You can choose from 32 different background images and unlimited color combos.</p>
  <p>To change the color of your app you will have to open <strong>style.css</strong> and look for the underlined code below in line 37:</p>
  <code>background: url(../images/bgs/<span class="underline">bg-28.jpg</span>) repeat center top <span class="underline">#004772</span>;</code>
  <p>Then change the background image name <strong>bg-28.jpg</strong> to the name of the background you want (see <a href="http://apps.volumens.com/cool-photos/">demo</a> page for reference). To change the background color just overwrite the default <strong>#004772</strong> RGB color code to the one you want.</p>
  <p>To change the color of the buttons go to <strong>style.css</strong> and change the underlined RGB color code in line 55 to the one you want:</p>
  <code>background-color: <span class="underline">#1BADDF</span>;</code>
  <p><strong>Change the URL of the like button</strong></p>
  <p>To change the URL of the like button (so that it can count your own app likes) you just have to open <strong>index.php</strong>, line 41, and change the underlined code below with the URL you want your users to like:</p>
  <code>&lt;fb:like href=&quot;<span class="underline">https://apps.facebook.com/facebook/</span>&quot; layout=&quot;button_count&quot;&gt;&lt;/fb:like&gt;</code> <img src="assets/images/1.jpg" alt="" />
  <p>The app works like this:</p>
  <ul>
    <li>First, the app reads the cookie from the logged Facebook user and pulls his or her profile information.</li>
    <li>Then, the user uploads a picture wich is automatically reduced to fit in the app space.</li>
    <li>When the user clicks on the "upload picture" button the app renders the elements added on the picture in the local server and then uploads it into a new photo album in the users profile.</li>
  </ul>
  
    <h3><strong>B) API Usage</strong></h3>
  <p><strong>Initialize Your App</strong></p>
  <p>The first step is to get a Facebook App ID and App Secret, which allows your app to retrieve information from Facebook. Go to <a href="https://developers.facebook.com/apps">Facebook Developers</a> and click on the “Create New App” button, pick a name and you’ve got your API. Now you need to set up your Site URL.</p>
  <img src="assets/images/2.jpg" alt="" />
  <p>The Site URL points to the server hosting the app files. To set these up, from the <a href="https://developers.facebook.com/apps">Apps</a> page click “Edit App” on the top right side. You will see the fields to fill in both, as I did in the screenshot below. While there are lots of other options, none are necessary for this app.</p>
  <img src="assets/images/3.jpg" alt="" />
  <p><span class="underline">Once you got your App ID, your App Secret and your Site URL you just have to insert them in the corresponding places on the fbmain.php file and the App should start working.</span></p>
  <hr>
