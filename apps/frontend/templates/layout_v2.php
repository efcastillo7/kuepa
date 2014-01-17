<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>kuepa, una nueva forma de aprender.</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Le styles -->
  <link rel="stylesheet" href="/styles/css/docs.css">
  <link rel="stylesheet" href="/styles/css/kuepa.css">
  <link rel="stylesheet" href="/styles/css/kuepa.hangouts.css">
  <link rel="stylesheet" href="/styles/css/plataforma.css">
  <link rel="stylesheet" href="/styles/css/thumbgrid.css">

  <link href="/assets/v2/styles/css/fullcalendar.css" rel="stylesheet">
  <link href="/assets/v2/styles/css/jqui.css" rel="stylesheet">
  <link href="/assets/v2/styles/css/jquery.cluetip.css" rel="stylesheet">

  <link href="/assets/v2/styles/css/bootstrap.css" rel="stylesheet">
  <link href="/assets/v2/styles/css/component.css" rel="stylesheet">
  <link href="/assets/v2/styles/css/style.css" rel="stylesheet">
  <link href="/assets/v2/styles/css/perfect-scrollbar.css" rel="stylesheet">
  <link href="/assets/v2/styles/css/bootstrap-select.css" rel="stylesheet">

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

  <!-- PUSH MENU -->
  <?php use_javascript("/assets/modernizr/modernizr.custom.js") ?>
  <?php use_javascript("/assets/modernizr/classie.js") ?>
  
  <?php use_javascript("/js/jquery.form.min.js") ?>
  <?php use_javascript("/assets/jquery-ui/js/jquery-ui-1.10.3.custom.min.js", 'first') ?>

  <script src="/assets/v2/js/bootstrap-select.js"></script>

  <?php include_http_metas() ?>
  <?php include_metas() ?>
  <?php include_title() ?>
  <link rel="shortcut icon" href="/favicon.ico" />
  <?php include_stylesheets() ?>
  <?php include_javascripts() ?>  
</head>

<body>

  <div class="wrapper">

  <?php include_component('layout', 'navigationV2') ?>

  <?php echo $sf_content ?>

  <div class="push"></div>

</div> <!-- /wrapper -->

<footer>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="ft-logo">kuepa</div>
        <p class="ft-copy">Copyright &copy; Kuepa 2013</p>
      </div>
    </div>
  </div>
</footer>

  <script src="/assets/v2/js/bootstrap.js"></script>
  <script src="/assets/v2/js/perfect-scrollbar.js"></script>
  <script src="/assets/v2/js/fullcalendar.js"></script>
  <script src="/assets/v2/js/jquery-ui.custom.min.js"></script>

  <script src="/assets/v2/js/jquery.placeholder.js"></script>

  <!-- cluetip -->
  <script src="/assets/v2/js/jquery.hoverIntent.js"></script>
  <script src="/assets/v2/js/jquery.cluetip.js"></script>
  <!-- cluetip -->


  <script language="javascript">
    $(document).ready(function(){

      $(function(){
        $('[rel="tooltip"]').tooltip();
      });

      $('input, textarea').placeholder();
      $('.selectpicker').selectpicker(); //selects

      $('.cont-notifications').perfectScrollbar({wheelSpeed:30});
    });
  </script>


</body>
</html>