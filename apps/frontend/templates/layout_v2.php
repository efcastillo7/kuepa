<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>kuepa, una nueva forma de aprender.</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

  <link href="/assets/v2/styles/css/bootstrap.css" rel="stylesheet">
  <link href="/assets/v2/styles/css/docs.css" rel="stylesheet">
  <link href="/assets/v2/styles/css/kuepa.css" rel="stylesheet">
  <link href="/assets/v2/styles/css/component.css" rel="stylesheet">
  <link href="/assets/v2/styles/css/style.css" rel="stylesheet">
  <link href="/assets/v2/styles/css/perfect-scrollbar.css" rel="stylesheet">

  <link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
  

  <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

  <!-- Le fav and touch icons -->
  <link rel="shortcut icon" href="ico/favicon.ico">
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">

  <script src="/assets/v2/js/jquery.js"></script>

  <script src="/assets/v2/js/jquery.mousewheel.js"></script>

  <script src="/assets/v2/js/jquery.knob.js"></script>
  
  <?php use_javascript("/js/jquery.form.min.js") ?>
  <?php use_javascript("/assets/jquery-ui/js/jquery-ui-1.10.3.custom.min.js", 'first') ?>

  <?php include_http_metas() ?>
  <?php include_metas() ?>
  <?php include_title() ?>
  <link rel="shortcut icon" href="/favicon.ico" />
  <?php include_stylesheets() ?>
  <?php include_javascripts() ?>  
</head>

<body>

  <div class="wrapper"> <?php /* cierra en layout_footer.php */ ?>

  <?php include_component('layout', 'navigationV2') ?>

  <?php echo $sf_content ?>

</div> <!-- /wrapper -->

<footer>
  <div class="container">
    <p class="gray2 small2 clearmargin"><span class="AvantMd">kuepa</span> Copyright &copy; Kuepa 2012</p>
  </div>
</footer>
  <!-- ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="/assets/v2/js/bootstrap.js"></script>
  <!--<script src="js/bootstrap-transition.js"></script>
  <script src="js/bootstrap-alert.js"></script>
  <script src="js/bootstrap-modal.js"></script>
  <script src="js/bootstrap-dropdown.js"></script>
  <script src="js/bootstrap-scrollspy.js"></script>
  <script src="js/bootstrap-tab.js"></script>
  <script src="js/bootstrap-tooltip.js"></script>
  <script src="js/bootstrap-popover.js"></script>
  <script src="js/bootstrap-button.js"></script>
  <script src="js/bootstrap-collapse.js"></script>
  <script src="js/bootstrap-carousel.js"></script>
  <script src="js/bootstrap-typeahead.js"></script>-->
  <script src="/assets/v2/js/perfect-scrollbar.js"></script>

  <script language="javascript">
    $(document).ready(function(){

      $('.carousel').carousel({
        interval: 6000
      });

      $(function(){
        $('[rel="tooltip"]').tooltip();
      });

      $(".knob-small").knob({
        height: 24
      });

    });
  </script>



</body>
</html>