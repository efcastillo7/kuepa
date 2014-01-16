<!DOCTYPE html>
<html lang="en" data-require="math math-format graphie word-problems">
    <head>
        <meta charset="utf-8">
        <title>kuepa, una nueva forma de aprender.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Le styles -->
        <?php use_stylesheet("/styles/css/bootstrap.css") ?>
        <?php use_stylesheet("/styles/css/bootstrap-responsive.css") ?>
        <?php use_stylesheet("/styles/css/docs.css") ?>
        <?php use_stylesheet("/styles/css/kuepa.css") ?>
        <?php use_stylesheet("/styles/css/kuepa.hangouts.css") ?>
        <?php use_stylesheet("/styles/css/plataforma.css") ?>
        <?php use_stylesheet("/styles/css/thumbgrid.css") ?>
        <!-- modalwindow -->
        <?php use_stylesheet("/assets/modalwindoweffect/css/default.css") ?>
        <?php use_stylesheet("/assets/modalwindoweffect/css/component.css") ?>
        <?php use_javascript("/assets/modalwindoweffect/js/modalEffects.js") ?>

        <?php use_javascript("/assets/jquery-ui/js/jquery-1.9.1.js", 'first') ?>
        <?php use_javascript("/assets/jquery-ui/js/jquery-ui-1.10.3.custom.min.js", 'first') ?>.
        <?php use_javascript("/assets/modalwindoweffect/js/modalEffects.js") ?>

        <!-- jqform -->
        <?php use_javascript("/js/jquery.form.min.js") ?>

        <!-- knob -->
        <?php use_javascript("/js/jquery.knob.js") ?>

        <?php use_javascript("/assets/tinymce/tinymce.min.js") ?>
        <?php use_javascript("/assets/tinymce/jquery.tinymce.min.js") ?>

        <!-- spinner -->
        <?php use_javascript("/assets/smartspin/smartspinner.js") ?>
        <?php use_stylesheet("/assets/smartspin/smartspinner.css") ?>

        <!-- UI TOUCH for drag & drop for ios -->
        <?php use_javascript("/assets/jquery-ui-touch/jquery.ui.touch-punch.min.js") ?>

        <!-- PUSH MENU -->
        <?php use_javascript("/assets/modernizr/modernizr.custom.js") ?>
        <?php use_javascript("/assets/modernizr/classie.js") ?>

        <!-- LEARNING PATH -->
        <?php use_javascript("libs/learningPathService.js") ?>
        <?php use_javascript("libs/learningPath.js") ?>


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
        <script src="/js/support.global.js"></script>

    </body>
</html>