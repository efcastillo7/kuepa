<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <title>kuepa, una nueva forma de aprender.</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Le fav and touch icons -->
  <link rel="shortcut icon" href="ico/favicon.ico">
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">

  <!-- Le styles -->
  <link rel="stylesheet" href="/styles/css/kuepa.css">
  <link rel="stylesheet" href="/styles/css/kuepa.hangouts.css">
  <link rel="stylesheet" href="/styles/css/plataforma.css">
  <link rel="stylesheet" href="/styles/css/kuepa.notifications.css"> <!-- from v1 -->
  <link rel="stylesheet" href="/styles/css/thumbgrid.css"> <!-- from v1 -->
  <link rel="stylesheet" href="/assets/v2/styles/css/fullcalendar.css">
  <link rel="stylesheet" href="/assets/v2/styles/css/jqui.css">
  <link rel="stylesheet" href="/assets/v2/styles/css/jquery.cluetip.css">
  <link rel="stylesheet" href="/assets/v2/styles/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/v2/styles/css/docs.css">
  <link rel="stylesheet" href="/assets/v2/styles/css/component.css">
  <link rel="stylesheet" href="/assets/v2/styles/css/style.css">
  <link rel="stylesheet" href="/assets/v2/styles/css/perfect-scrollbar.css">
  <link rel="stylesheet" href="/assets/v2/styles/css/bootstrap-select.css">
  <link rel="stylesheet" href="/assets/modalwindoweffect/css/default.css"> <!-- from v1 -->
  <link rel="stylesheet" href="/assets/modalwindoweffect/css/component.css"> <!-- from v1 -->
  <link rel="stylesheet" href="/assets/smartspin/smartspinner.css"> <!-- from v1 -->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">

  <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

  <!-- Le javascript -->
  <script src="/assets/v2/js/jquery.js"></script>
  <script src="/assets/v2/js/jquery.mousewheel.js"></script>
  <script src="/assets/v2/js/bootstrap-select.js"></script>

  <script type="text/javascript" src="/assets/jquery-ui/js/jquery-1.9.1.js"></script>
  <script type="text/javascript" src="/assets/jquery-ui/js/jquery-ui-1.10.3.custom.min.js"></script>
  <script type="text/javascript" src="/assets/modalwindoweffect/js/modalEffects.js"></script>
  <script type="text/javascript" src="/js/jquery.form.min.js"></script>
  <script type="text/javascript" src="/js/jquery.knob.js"></script>
  <script type="text/javascript" src="/assets/tinymce/tinymce.min.js"></script>
  <script type="text/javascript" src="/assets/tinymce/jquery.tinymce.min.js"></script>
  <script type="text/javascript" src="/assets/smartspin/smartspinner.js"></script>
  <script type="text/javascript" src="/assets/jquery-ui-touch/jquery.ui.touch-punch.min.js"></script>
  <script type="text/javascript" src="/assets/modernizr/modernizr.custom.js"></script>
  <script type="text/javascript" src="/assets/modernizr/classie.js"></script>
  <script type="text/javascript" src="/js/libs/learningPathService.js"></script>
  <script type="text/javascript" src="/js/libs/learningPath.js"></script>

  <?php include_http_metas() ?>
  <?php include_metas() ?>
  <?php include_title() ?>
  <link rel="shortcut icon" href="/favicon.ico" />
  <?php include_stylesheets() ?>
  <?php include_javascripts() ?> 
  <?php include_component('layout', 'styles') ?> 

</head>
<body>
  <div id="wrap">
    <?php include_component('layout', 'navigationV2') ?>
    <?php echo $sf_content ?>
    <div id="push"></div>
  </div>

  <footer id="footer">
    <div class="container">
      <div class="ft-logo">kuepa</div>
      <p class="ft-copy">Copyright &copy; Kuepa 2014</p>
    </div>
  </footer>

  <!-- Modals -->
  <?php include_partial("views/modals/success") ?>
  <?php include_component("support","Modalurl") ?>


  <script src="/assets/v2/js/bootstrap.js"></script>
  <script type="text/javascript" src="https://apis.google.com/js/platform.js"></script>
  <script type="text/javascript" src="https://apis.google.com/js/client:plusone.js"></script>
  <script src="/js/course.js"></script>
  <script src="/js/uno/application.js"></script>
  <script src="/js/support.global.js"></script>
  <script src="/js/notifications.global.js"></script>
  <script src="/assets/v2/js/perfect-scrollbar.js"></script>
  <script src="/assets/v2/js/fullcalendar.js"></script>
  <script src="/assets/v2/js/jquery-ui.custom.min.js"></script>
  <script src="/assets/v2/js/jquery.placeholder.js"></script>
  <!-- cluetip -->
  <script src="/assets/v2/js/jquery.hoverIntent.js"></script>
  <script src="/assets/v2/js/jquery.cluetip.js"></script>
  <!-- cluetip -->
  <?php include_partial('global/analytics') ?>
  <script language="javascript">
    $(document).ready(function(){
      $(function(){
        $('[rel="tooltip"]').tooltip();
      });
      $('input, textarea').placeholder();
      // $('.selectpicker').selectpicker(); //selects
      $('.cont-notifications').perfectScrollbar({wheelSpeed:30});
    });
  </script>



</body>
</html>