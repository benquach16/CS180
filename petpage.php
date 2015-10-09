<!doctype html>
<body>
        <?php include('./library/nav-bar.html'); ?>
<?php
	//pull information from database
	include './library/opendb.php';
	
?>
</body>
</html>



















<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html><head>
          

<title>Login - MyAnimeList.net
</title>
<meta name="description" content="Welcome to MyAnimeList, the world&#039;s most active online anime and manga community and database. Login or Signup now! Join the online community, create your anime and manga list, read reviews, explore the forums, follow news, and so much more!" />

  
<meta name="keywords" content="anime, myanimelist, anime news, manga" />
<link rel="canonical" href="http://myanimelist.net/login.php" />  
<meta name='csrf_token' content='0c1077e77ad25adc415030ac7dd533091a297d97'><script type="text/javascript" src="http://cdn.myanimelist.net/static/assets/js/pc/all-348b55699c.js"></script><script type="text/javascript" src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://cdn.myanimelist.net/js/hover.js?v=36"></script>
<script type="text/javascript" src="http://cdn.myanimelist.net/js/jquery.fancybox.pack.js?v=36"></script>



<script type="text/javascript" src="http://cdn.myanimelist.net/js/myanimelist.js?v=36" id="myanimelistjs" data-myanimelistjs-params='{&quot;origin_url&quot;:&quot;http:\/\/myanimelist.net&quot;,&quot;is_request_bot_filter_log&quot;:true}'></script>


	<link rel="stylesheet" type="text/css" href="http://cdn.myanimelist.net/css/mal.ridlayout.css?v=26" />

<link rel="stylesheet" type="text/css" href="http://cdn.myanimelist.net/css/jquery.fancybox.css?v=26" />
<link rel="stylesheet" type="text/css" href="http://cdn.myanimelist.net/css/dialog.css?v=26" />
<link rel="stylesheet" type="text/css" href="http://cdn.myanimelist.net/static/assets/css/pc/style-3c584c91fb.css" />
<link rel="search" type="application/opensearchdescription+xml" href="http://cdn.myanimelist.net/plugins/myanimelist.xml" title="MyAnimeList" />

<link rel="shortcut icon" href="http://cdn.myanimelist.net/images/faviconv5.ico" />

<!-- ### Load GPT Library ### -->
<script type='text/javascript'>
  var googletag = googletag || {};
  googletag.cmd = googletag.cmd || [];
  (function() {
    var gads = document.createElement('script');
    gads.async = true;
    gads.type = 'text/javascript';
    var useSSL = 'https:' == document.location.protocol;
    gads.src = (useSSL ? 'https:' : 'http:') +
               '//www.googletagservices.com/tag/js/gpt.js';
    var node = document.getElementsByTagName('script')[0];
    node.parentNode.insertBefore(gads, node);
  })();
</script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-369102-1', 'auto');
  ga('require', 'linkid'); // Enhanced Link Attribution
  ga('send', 'pageview');

</script>

<script src="https://apis.google.com/js/platform.js" async defer>{lang: 'en-GB'}</script>
<script src="https://www.google.com/recaptcha/api.js?hl=en"></script>

      </head>

    <body class="page-common page_login page_password_login">  
    <div id="myanimelist">
          <script type='text/javascript'>
    googletag.cmd.push(function() {
      googletag.defineOutOfPageSlot('/84947469/Skin_Others', 'div-gpt-ad-930272589').addService(googletag.pubads());
      googletag.pubads().collapseEmptyDivs();
      googletag.enableServices();
    });
  </script>
  <div style="display: none !important;">
    <div id='div-gpt-ad-930272589'>
      <script type='text/javascript'>
        googletag.cmd.push(function() { googletag.display('div-gpt-ad-930272589'); });
      </script>
    </div>
  </div>

    <script type='text/javascript'>
    window.MAL.SkinAd.prepareForSkin('Skin_Others');
  </script>

    <div id="ad-skin-bg-left" class="ad-skin-side-outer ad-skin-side-bg bg-left">
    <div id="ad-skin-left" class="ad-skin-side left" style="display: none;">
      <div id="ad-skin-left-absolute-block">
        <div id="ad-skin-left-fixed-block"></div>
      </div>
    </div>
  </div><div class="wrapper">
        
                        
        <div id="headerSmall" >  <div id="header-menu">
    <div class="header-menu-login">
      <a class="btn-login" href="http://myanimelist.net/login.php?from=%2Fpanel.php" id="malLogin">Login</a>
      <a class="btn-signup" href="http://myanimelist.net/register.php?from=%2Fpanel.php">Sign Up</a>
    </div>
  </div>
<a href="/">MyAnimeList.net</a>
          <a href="http://myanimelist.net/watch" class="banner-header-anime-straming">
  <img src="http://cdn.myanimelist.net/images/stream_banner/banner_anime_streaming.png" srcset="http://cdn.myanimelist.net/images/stream_banner/banner_anime_streaming@2x.png 2x" alt="Anime Streaming Now Available on MAL!">
</a>
</div>
        
                
          <div id="menu">

    <div id="menu_right">

      <form id="searchBar" method="get">

        <input id="topSearchText" type="text" class="inputtext" value="Search" size="30" />
        <select id="topSearchValue" class="inputtext">
        <option value="0">Anime</option>
        <option value="1">Manga</option>
        <option value="2">Characters</option>
        <option value="6">People</option>
        <option value="4">Clubs</option>
        <option value="5">Users</option>
        </select>

        <input id="topSearchButon" type="image" src="http://cdn.myanimelist.net/images/magnify.gif" value="Search" />

      </form>

	</div>    <div id="menu_left">
                        <ul id="nav">
    <li class="small"><a href="#" class="non-link">Anime</a>
    <ul class="wider">
            <li><a href="/anime.php">Anime Search</a></li>
      <li><a href="/reviews.php?t=anime">Reviews</a></li>
      <li><a href="/recommendations.php?s=recentrecs&t=anime">Recommendations</a></li>
      <li><a href="/topanime.php">Top Anime</a></li>
      <li><a href="http://myanimelist.net/anime/season">Seasonal Anime</a></li>
    </ul>
  </li>
  <li class="small"><a href="#" class="non-link">Manga</a>
    <ul class="wider">
            <li><a href="/manga.php">Manga Search</a></li>
      <li><a href="/reviews.php?t=manga">Reviews</a></li>
      <li><a href="/recommendations.php?s=recentrecs&t=manga">Recommendations</a></li>
      <li><a href="/topmanga.php">Top Manga</a></li>
    </ul>
  </li>
  <li><a href="#" class="non-link">Community</a>
    <ul>
      <li><a href="/forum/">Forums</a></li>
      <li><a href="/clubs.php">Clubs</a></li>
      <li><a href="/blog.php">Blogs</a></li>
      <li><a href="/users.php">Users</a></li>
    </ul>
  </li>
  <li class="small2"><a href="#" class="non-link">Industry</a>
    <ul class="wider">
      <li><a href="/news">News</a></li>
      <li><a href="http://myanimelist.net/featured">Featured Articles</a></li>
      <li><a href="/people.php">People</a></li>
      <li><a href="/character.php">Characters</a></li>
      <li><a href="/favorites.php">Top Favorites</a></li>
    </ul>
  </li>
  <li class="small"><a href="http://myanimelist.net/watch">Watch</a></li>
  <li class="smaller"><a href="#" class="non-link">Help</a>
    <ul class="wide">
      <li><a href="/about.php">About</a></li>
      <li><a href="/about.php?go=support">Support</a></li>
      <li><a href="/about.php?go=advertising">Advertising</a></li>
      <li><a href="/forum/?topicid=515949">FAQ</a></li>
      <li><a href="/modules.php?go=report">Report</a></li>
      <li><a href="/about.php?go=team">Staff</a></li>
    </ul>
  </li>
  </ul>
                  </div>  </div>        <div id="contentWrapper" >
          <h1 class="h1">Login</h1>            <div id="content">
          <div class="badresult">
        You must first login to see this page.
      </div>
    
    
<table id="dialog" cellpadding="0" cellspacing="0" style="width: 530px;">
  <tr>
    <td class="">
                    <div class="social-login-block mauto">

    <p class="ff-avenir fs16 pt12 ac">Login with</p>

    <div class="login-sns-buttons pt16 pb24 ac"><a class="icon-social-login icon-fb" href="http://myanimelist.net/sns/login/facebook?from=%2Fpanel.php" tabindex=1>Facebook</a><a class="icon-social-login icon-tw" href="http://myanimelist.net/sns/login/twitter?from=%2Fpanel.php" tabindex=2>Twitter</a><a class="icon-social-login icon-gp" href="http://myanimelist.net/sns/login/google?from=%2Fpanel.php" tabindex=3>Google+</a></div>
</div>

        <form name="loginForm" method="post" action="http://myanimelist.net/login.php?from=%2Fpanel.php">

          <div class="login-form-block form_password_login pb16">

            <p class="pt16">
              <label class="di-b fs12 pb4">Username</label>
              <input type="text" class="inputtext login-inputtext" name="user_name" id="loginUserName" value="" size="30" maxlength="50" tabindex="4">

              <p class="badresult-text">
                              </p>
            </p>

            <p class="pt16">
              <span class="fl-r di-ib fs12 ff-avenir" data-ajax="false">
                <input id="show-password" type="checkbox" name="show_password" value="0" tabindex="6">
                Show Password
              </span>
              <label class="di-b fs12 pb4">Password</label>
              <input type="password" id="login-password" class="inputtext login-inputtext" name="password" size="30" maxlength="50" tabindex="5">

              <p class="badresult-text">
                              </p>
            </p>

            <p class="pt12">
              <input type="checkbox" name="cookie" value="1" checked="checked" tabindex="6"> Always stay logged in?
            </p>

            <p class="pt16 ac">
              <input type="submit" class="inputButton btn-form-submit" name="sublogin" value="Login" tabindex="7">            </p>

            <p class="pt12 pb8 ac">
              <a href="http://myanimelist.net/password.php?username=1&amp;from=%2Fpanel.php" tabindex="8">Forgot username?</a> | <a href="http://myanimelist.net/password.php?from=%2Fpanel.php" tabindex="9">Forgot password?</a>
            </p>

            <p class="pt24 pb8 ac">
              <input type="button" onclick="document.location='http://myanimelist.net/register.php?from=%2Fpanel.php';" name="register" value="Sign Up" class="inputButton btn-form-submit small" tabindex="10">            </p>

          </div>

          
          <input type="hidden" name="submit" value="1">
        </form>
          </td>
  </tr>
</table>

  </div>
                                              </div>            <!--  control container height -->
            <div style="clear:both;"></div>
            <!-- end rightbody -->
          
                      
                </div>
          <div id="ad-skin-bg-right" class="ad-skin-side-outer ad-skin-side-bg bg-right">
    <div id="ad-skin-right" class="ad-skin-side right" style="display: none;">
      <div id="ad-skin-right-absolute-block">
        <div id="ad-skin-right-fixed-block"></div>
      </div>
    </div>
  </div></div>
          

    
    <footer>
  <div id="footer-block">
    <div class="footer-link-block">
      <p class="footer-link home di-ib">
        <a href="http://myanimelist.net/">Home</a>
      </p>
      <p class="footer-link di-ib">
        <a href="http://myanimelist.net/about.php">About</a>
        <a href="http://myanimelist.net/about.php?go=contact">Support</a>
        <a href="http://myanimelist.net/about.php?go=advertising">Advertising</a>
        <a href="http://myanimelist.net/forum/?topicid=515949">FAQ</a>
        <a href="http://myanimelist.net/about/terms_of_use">Terms</a>
        <a href="http://myanimelist.net/about/privacy_policy">Privacy</a>
        <a href="http://myanimelist.net/about/sitemap">Sitemap</a>
    	</p>
  		  		<p class="footer-link login di-ib">
  			<a href="http://myanimelist.net/login.php?from=%2Fpanel.php" id="malLogin" rel="nofollow">Login</a>
  			<a href="http://myanimelist.net/register.php?from=%2Fpanel.php">Sign Up</a>
  		</p>
  		    </div>

    <div class="footer-link-icon-block">
            <div class="footer-social-media ac">
        <a target="_blank" class="icon-sns icon-fb di-ib" href="https://www.facebook.com/OfficialMyAnimeList"></a>
        <a target="_blank" class="icon-sns icon-tw di-ib" title="Follow @myanimelist on Twitter" href="https://twitter.com/myanimelist"></a>
        <a class="icon-sns icon-gp" href="https://plus.google.com/105884801583962160252?prsrc=3" rel="publisher" target="_blank" style="text-decoration:none;">
          <img src="http://cdn.myanimelist.net/images/footer/icon-google_plus.png" alt="Google+" style="border:0;width:30px;height:30px;" />
        </a>
    </div>

  </div>
</footer>

<div id="evolve_footer"></div>

      <script type="text/javascript">
//<![CDATA[
(function() {
var _analytics_scr = document.createElement('script');
_analytics_scr.type = 'text/javascript'; _analytics_scr.async = true; _analytics_scr.src = '/_Incapsula_Resource?SWJIYLWA=2977d8d74f63d7f8fedbea018b7a1d05&ns=2';
var _analytics_elem = document.getElementsByTagName('script')[0]; _analytics_elem.parentNode.insertBefore(_analytics_scr, _analytics_elem);
})();
// ]]>
</script></body>
</html>

