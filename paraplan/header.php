<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="initial-scale=1, width=device-width, minimum-scale=1, maximum-scale=1, user-scalable=no">
<title><?php wp_title('|', true, 'right'); ?></title>
<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/img/favicon.png">
<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/img/touch-icon-iphone.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_template_directory_uri(); ?>/img/touch-icon-ipad.png">
<link href="https://plus.google.com/109164351509424621346" rel="publisher">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

	<!--googleoff: all-->
    <noindex class="robots-nocontent">
        <div id="warning" class="robots-nocontent">
            <noscript class="noscript" style="text-align: center;">
                Откройте для себя красивый интернет, <a href="http://www.enable-javascript.com/ru/" target="_blank">включите JavaScript</a>.
                <br>
                <script>
                    document.getElementsByClassName("noscript").remove();
                </script>
            </noscript>
            <!--[if IE]>
            <div id="oldBrowser" style="text-align: center;">
                Ваш браузер так устарел, что он больше не может показывать современные сайты. <a href="http://whatbrowser.org/" target="_blank">Установите что-нибудь по-новее</a>.
                <script>
                    $('#oldBrowser').remove();
                </script>
            </div>
            <![endif]-->
        </div>
    </noindex>
    <!--googleon: all-->

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-39902684-4', 'auto');
        ga('send', 'pageview');
    </script>

<?php if (is_front_page() || is_404()) : ?>
    <main class="main">
<?php endif; ?>