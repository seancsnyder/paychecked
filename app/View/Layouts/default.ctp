<html>
    <head>
        <?php echo $this->Html->charset(); ?>
        <title><?php echo $title_for_layout; ?></title>
        <link href="/favicon.ico" type="image/x-icon" rel="icon" />
        <link href="/favicon.ico" type="image/x-icon" rel="shortcut icon" />

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="/css/bootstrap.css" rel="stylesheet">
        <link href="/css/bootstrap-responsive.css" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="/css/style.css" />

        <script src="/js/jquery-1.8.0.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>

        <?php if(isset($page_specific_css_includes)) { ?>
            <?php foreach($page_specific_css_includes as $page_specific_css_include) { ?>
                <?php echo $this->Html->css($page_specific_css_include); ?>
            <?php } ?>
        <?php } ?>

        <?php if(isset($page_specific_js_includes)) { ?>
            <?php foreach($page_specific_js_includes as $page_specific_js_include) { ?>
                <?php echo $this->Html->script($page_specific_js_include); ?>
            <?php } ?>
        <?php } ?>

    </head>
    <body>
        <div class="navbar">
            <div class="navbar-inner">
                <div class="container">
                    <?php if ($logged_in) { ?>
                        <a class="brand" href="/dashboard">paychecked</a>
                    <?php } else { ?>
                        <a class="brand" href="/">paychecked</a>
                    <?php } ?>

                    <div>
                        <ul class="nav">
                            <li><a href="/about">about</a></li>
                            <li><a href="/privacy">privacy</a></li>
                            <?php if ($logged_in) { ?>
                                <li><a href="/account">account</a></li>
                                <li><a href="/logout">logout</a></li>
                            <?php } else { ?>
                                <li><a href="/login">login</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <?php echo $this->fetch('content'); ?>
        </div>


        <div class="navbar" id="footer_navbar">
            <div class="navbar-inner">
                <div class="container">
                    <div>
                        <ul class="nav">
                            <li><a href="/contact">contact/help</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            var pkBaseURL = (("https:" == document.location.protocol) ? "https://analytics.snyderitis.com/" : "http://analytics.snyderitis.com/");
            document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
        </script>
        <script type="text/javascript">
            try {
                var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 8);
                piwikTracker.trackPageView();
                piwikTracker.enableLinkTracking();
            } catch( err ) {}
        </script>
        <noscript>
            <p>
                <img src="http://analytics.snyderitis.com/piwik.php?idsite=8" style="border:0" alt="" />
            </p>
        </noscript>
     </body>
</html>