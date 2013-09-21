<!DOCTYPE html>
<html lang="en" data-require="math math-format graphie word-problems">
    <head>
        <meta charset="utf-8">
        <title>kuepa, una nueva forma de aprender.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Le styles -->
        <link href="/styles/css/bootstrap.css" rel="stylesheet">
        <link href="/styles/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="/styles/css/docs.css" rel="stylesheet">
        <link href="/styles/css/kuepa.css" rel="stylesheet">
        <link href="/styles/css/plataforma.css" rel="stylesheet">
        <link href="/styles/css/thumbgrid.css" rel="stylesheet">

        <!-- jquery ui -->
        <link href="/assets/jquery-ui/css/ui-lightness/jquery-ui-1.10.3.custom.min.css" rel="stylesheet">

        <!-- modalwindow -->
        <link rel="stylesheet" type="text/css" href="/assets/modalwindoweffect/css/default.css" />
        <link rel="stylesheet" type="text/css" href="/assets/modalwindoweffect/css/component.css" />

        <!-- jquery -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
        <!-- jquery UI -->
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

        <script src="/assets/jquery-ui/js/jquery-1.9.1.js"></script>
        <script src="/assets/jquery-ui/js/jquery-ui-1.10.3.custom.min.js"></script>

        <!-- jqform -->
        <script src="/js/jquery.form.min.js"></script>
        <!-- knob -->
        <script src="/js/jquery.knob.js"></script>
        
        <?php use_javascript("/assets/tinymce/tinymce.min.js") ?>
        <?php use_javascript("/assets/tinymce/jquery.tinymce.min.js") ?>
        <?php use_javascript("/assets/smartspin/smartspinner.js") ?>
        <?php use_stylesheet("/assets/smartspin/smartspinner.css") ?>

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

        <!-- Modals -->
        <?php include_partial("views/modals/success") ?>

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

        <!-- classie.js by @desandro: https://github.com/desandro/classie -->
        <script src="/assets/modalwindoweffect/js/classie.js"></script>
        <script src="/assets/modalwindoweffect/js/modalEffects.js"></script>

        <script type="text/javascript">
            $(".knob-small").knob({
                height: 24
            });
        </script>
    </body>
</html>