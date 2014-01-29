<!DOCTYPE html>
<html lang="en" data-require="math math-format graphie word-problems">
    <head>
        <meta charset="utf-8">
        <title>kuepa, una nueva forma de aprender.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <script type="text/javascript" src="/assets/jquery-ui/js/jquery-1.9.1.js"></script>
        <script type="text/javascript" src="/assets/jquery-ui/js/jquery-ui-1.10.3.custom.min.js"></script>

        <!-- Le styles -->
        <link rel="stylesheet" href="/styles/css/bootstrap.css">
        <link rel="stylesheet" href="/styles/css/docs.css">
        <link rel="stylesheet" href="/styles/css/kuepa.css">
        <link rel="stylesheet" href="/styles/css/kuepa.hangouts.css">
        <link rel="stylesheet" href="/styles/css/kuepa.notifications.css">
        <link rel="stylesheet" href="/styles/css/plataforma.css">
        <link rel="stylesheet" href="/styles/css/thumbgrid.css">

        <!-- modalwindow -->
        <link rel="stylesheet" href="/assets/modalwindoweffect/css/default.css">
        <link rel="stylesheet" href="/assets/modalwindoweffect/css/component.css">

        <script type="text/javascript" src="/assets/modalwindoweffect/js/modalEffects.js"></script>

        <!-- jqform -->
        <script type="text/javascript" src="/js/jquery.form.min.js"></script>

        <!-- knob -->
        <script type="text/javascript" src="/js/jquery.knob.js"></script>

        <script type="text/javascript" src="/assets/tinymce/tinymce.min.js"></script>
        <script type="text/javascript" src="/assets/tinymce/jquery.tinymce.min.js"></script>

        <!-- spinner -->
        <script type="text/javascript" src="/assets/smartspin/smartspinner.js"></script>
        <link rel="stylesheet" href="/assets/smartspin/smartspinner.css">

        <!-- UI TOUCH for drag & drop for ios -->
        <script type="text/javascript" src="/assets/jquery-ui-touch/jquery.ui.touch-punch.min.js"></script>

        <!-- PUSH MENU -->
        <script type="text/javascript" src="/assets/modernizr/modernizr.custom.js"></script>
        <script type="text/javascript" src="/assets/modernizr/classie.js"></script>

        <!-- LEARNING PATH -->
        <script type="text/javascript" src="/js/libs/learningPathService.js"></script>
        <script type="text/javascript" src="/js/libs/learningPath.js"></script>

        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <?php include_javascripts() ?>
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <?php include_title() ?>
        <link rel="shortcut icon" href="/favicon.ico" />
        <?php include_stylesheets() ?>
    </head>

    <body class="cbp-spmenu-push">

        <?php include_component('layout', 'navigation') ?>
        <?php echo $sf_content ?>
        <?php include_partial('layout/footer') ?>

        <!-- Modals -->
        <?php include_partial("views/modals/success") ?>
        <?php include_component("support","Modalurl") ?>

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
        <script type="text/javascript" src="https://apis.google.com/js/platform.js"></script>
        <script type="text/javascript" src="https://apis.google.com/js/client:plusone.js"></script>
        <script src="/js/course.js"></script>

        <script src="/js/uno/application.js"></script>

        <script src="/js/support.global.js"></script>
        <script src="/js/notifications.global.js"></script>


        <?php include_partial('global/analytics') ?>
    </body>
</html>