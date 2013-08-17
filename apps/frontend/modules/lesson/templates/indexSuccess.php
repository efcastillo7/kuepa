<div id="" class="container">
    <div id="leccion" class="row">
        <div class="span12">
            <p class="gray3"><?php echo $course->getName() ?>  /  <?php echo $chapter->getName() ?></p>
            <p class="title3 clearmargin"><?php echo $lesson->getName() ?></p>
        </div>
    </div>
</div><!-- /container -->

<!-- leccion-camino -->
<div id="" class="learning-path">
    <div id="" class="container">
        <div id="" class="row">
            <?php include_partial("left_menu", array("parent" => $lesson )) ?>
            <div class="span9">
                <div class="path-content">
                    <p class="title3 white">Introducción a la lección</p>
                    <p class="gray2">
                        Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    </p>
                    <div class="txt-right margintop">
                        <a class="btn btn-large">Comenzar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- /leccion-camino -->

<div id="" class="container margintop40">
    <div id="utilities" class="row">
        <div class="span8">
            <div class="notes">
                <p class="title5">Anotaciones</p>
                <input class="span8" type="text" placeholder="Escribe un recordatorio para esta lección...">
                <ul class="unstyled">
                    <li>
                        <p class="">
                            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </p>
                        <p class="small1 gray2">2013/07/11 11:10hs</p>
                    </li> 
                    <li>
                        <p class="">
                            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </p>
                        <p class="small1 gray2">2013/07/11 11:10hs</p>
                    </li> 
                    <li>
                        <p class="">
                            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </p>
                        <p class="small1 gray2">2013/07/11 11:10hs</p>
                    </li> 
                    <li>
                        <p class="">
                            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </p>
                        <p class="small1 gray2">2013/07/11 11:10hs</p>
                    </li> 
                </ul>
            </div>
        </div>
        <div class="span3 offset1">
            <div class="share">
                <p class="title5">Compartir</p>
                <a href=""><img src="img/icn_fb.jpg"></a>
                <a href=""><img src="img/icn_tw.jpg"></a>
                <a href=""><img src="img/icn_gp.jpg"></a>
            </div>
            <div class="credits margintop40">
                <p class="title5 clearmargin">Créditos</p>
                <p class="gray3 small1">
                    Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </p>
            </div>

        </div>
    </div>
</div><!-- /container -->