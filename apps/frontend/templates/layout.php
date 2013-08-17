<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>kuepa, una nueva forma de aprender.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Le styles -->
        <link href="/styles/css/bootstrap.css" rel="stylesheet">
        <link href="/styles/css/docs.css" rel="stylesheet">
        <link href="/styles/css/kuepa.css" rel="stylesheet">
        <link href="/styles/css/plataforma.css" rel="stylesheet">
        <link href="/styles/css/thumbgrid.css" rel="stylesheet">

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
        <script src="/js/jquery.knob.js"></script>

        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <?php include_title() ?>
        <link rel="shortcut icon" href="/favicon.ico" />
        <?php include_stylesheets() ?>
        <?php include_javascripts() ?>
    </head>

    <body>

        <?php include_component('layout', 'navigation') ?>
        <?php echo $sf_content ?>
        <?php include_partial('layout/footer') ?>
        

        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="/js/bootstrap-transition.js"></script>
        <script src="/js/bootstrap-alert.js"></script>
        <script src="/js/bootstrap-modal.js"></script>
        <script src="/js/bootstrap-dropdown.js"></script>
        <script src="/js/bootstrap-scrollspy.js"></script>
        <script src="/js/bootstrap-tab.js"></script>
        <script src="/js/bootstrap-tooltip.js"></script>
        <script src="/js/bootstrap-popover.js"></script>
        <script src="/js/bootstrap-button.js"></script>
        <script src="/js/bootstrap-collapse.js"></script>
        <script src="/js/bootstrap-carousel.js"></script>
        <script src="/js/bootstrap-typeahead.js"></script>
        <script src="/js/course.js"></script>

        <script type="text/javascript">
            $(".knob-small").knob({
                height: 24
            });
        </script>
    </body>
</html>