<!-- Content -->
<?php $resourceData = $resource->getResourceData()->getFirst();
      $exercise = $resourceData->getExercise();
      $questions = $exercise->getQuestions();
?>

<section class="data-exercise two-columns clearpadding" data-spy="scroll" data-target="#navbar-scroll">

  <div class="content">
    <h2><?php echo $exercise->getDescription() ?></h2>

    <section class="breadcrum gray">
      <div class="icon bg-<?php echo $course->getColor()?>-alt-1">
        <img src="<?php echo $course->getThumbnailPath() ?>">
      </div>

      <span>Ejercitación</span>
      <i class="spr ico-arrow-breadcrum"></i>

      <span>Contesta a continuación las preguntas 1 a <?php echo $exercise->getQuestions()->count() ?></span>
    </section>
  </div>

  <div class="content questions">
    <?php for ($i=0; $i < $questions->count(); $i++): ?>
    <h4 id="ex-question-<?php echo $i+1?>">
      <i class="dot8 orange"></i> Pregunta <?php echo $i+1 ?>
    </h4>
    <?php include_partial("type_" . $questions[$i]->getType(), array('exercise' => $exercise, 'question' => $questions[$i]))?>
    <?php endfor ?>

    

    <h4 id="pregunta2">
      <i class="dot8 orange"></i> Pregunta 2
    </h4>
    <h4 class="head-fieldset">Seleccione cuál es la opción correcta</h4>
    <fieldset>
      <ul>
        <li>
          <input id="box1" class="checkbox checkbox-default" type="checkbox" />
          <label for="box1" name="label-box" class="chk-label checkbox-default">Checkbox</label>
        </li>
        <li>
          <input id="box2" class="checkbox checkbox-default" type="checkbox" />
          <label for="box2" name="label-box" class="chk-label checkbox-default">Checkbox</label>
        </li>
        <li>
          <input id="box3" class="checkbox checkbox-default" type="checkbox" />
          <label for="box3" name="label-box" class="chk-label checkbox-default">Checkbox</label>
        </li>
      </ul>
    </fieldset>

    <h4 id="pregunta3">
      <i class="dot8 orange"></i> Pregunta 3
    </h4>
    <h4 class="head-fieldset">Complete los espacios en blanco con los conceptos apropiados</h4>
    <fieldset>
      <input type="text" class="input-small orange" name="input1"> queda en la región <input type="text" class="input-small orange" name="input2"> de América. La provincia <input type="text" class="input-small orange" name="input3"> es la provincia más al <input type="text" class="input-small orange" name="input4"> del mundo.
    </fieldset>

    <h4 id="pregunta4">
      <i class="dot8 orange"></i> Pregunta 4
    </h4>

    <h4 class="head-fieldset">Relacione los conceptos</h4>
    <table>
      <thead>
        <tr>
          <td>Grupo Partida</td>
          <td>Grupo Llegada</td>
          <td>Relaciones</td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1. Tortuga</td>
          <td>A. Mamífero</td>
          <td>
            <span class="number">1. </span>
            <div class="dropdown">
              <a href="#" role="button" class="dropdown-toggle dropdown-stylized orange" data-toggle="dropdown">
                <span class="text">A</span>
                <span class="icon"><i class="spr ico-arrow-dropdown"></i></span>
              </a>
              <ul class="dropdown-menu dropdown-stylized-list orange" role="menu" aria-labelledby="drop1">
                <li role="presentation"><a role="menuitem" tabindex="-1">A</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1">B</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1">C</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1">D</a></li>
              </ul>
            </div>
          </td>
        </tr>
        <tr>
          <td>2. León</td>
          <td>B. Reptil</td>
          <td>
            <span class="number">2. </span>
            <div class="dropdown">
              <a href="#" role="button" class="dropdown-toggle dropdown-stylized orange" data-toggle="dropdown">
                <span class="text">A</span>
                <span class="icon"><i class="spr ico-arrow-dropdown"></i></span>
              </a>
              <ul class="dropdown-menu dropdown-stylized-list orange" role="menu" aria-labelledby="drop1">
                <li role="presentation"><a role="menuitem" tabindex="-1">A</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1">B</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1">C</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1">D</a></li>
              </ul>
            </div>
          </td>
        </tr>
        <tr>
          <td>3. Delfín</td>
          <td>C. Ave</td>
          <td>
            <span class="number">3. </span>
            <div class="dropdown">
              <a href="#" role="button" class="dropdown-toggle dropdown-stylized orange" data-toggle="dropdown">
                <span class="text">A</span>
                <span class="icon"><i class="spr ico-arrow-dropdown"></i></span>
              </a>
              <ul class="dropdown-menu dropdown-stylized-list orange" role="menu" aria-labelledby="drop1">
                <li role="presentation"><a role="menuitem" tabindex="-1">A</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1">B</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1">C</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1">D</a></li>
              </ul>
            </div>
          </td>
        </tr>
        <tr>
          <td>4. Avestruz</td>
          <td>D. Pez</td>
          <td>
            <span class="number">4. </span>
            <div class="dropdown">
              <a href="#" role="button" class="dropdown-toggle dropdown-stylized orange" data-toggle="dropdown">
                <span class="text">A</span>
                <span class="icon"><i class="spr ico-arrow-dropdown"></i></span>
              </a>
              <ul class="dropdown-menu dropdown-stylized-list orange" role="menu" aria-labelledby="drop1">
                <li role="presentation"><a role="menuitem" tabindex="-1">A</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1">B</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1">C</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1">D</a></li>
              </ul>
            </div>
          </td>
        </tr>
      </tbody>
    </table>

    <h4 id="pregunta5">
      <i class="dot8 orange"></i>
      Pregunta 5
    </h4>
    <h4 class="head-fieldset">Fundamene por qué suceden los cambios climáticos</h4>

    <textarea class="ckeditor" cols="80" id="editor1" name="editor1" rows="10">
    </textarea>
  </div>

  <div class="content">
    <section class="breadcrum gray margintop">
      <div class="icon subject-biology">
        <img src="img/subject-icons/subject-icn-biology.png">
      </div>
      <span>Estímulo 2</span>
      <i class="spr ico-arrow-breadcrum"></i>
      <span>Contesta las preguntas 7 a 10 de acuerdo al siguiente texto</span>
    </section>

    <section class="text-image">
      <article class="without-image">
        <h2>Para mirarte mejor</h2>
        <h3>Por: Juan Armando Epple</h3>
        <p>
          Debéis saber que mi abuela, hará unos sesenta años, vivió en París e hizo allí auténtico furor. La gente corría tras ella para ver a la Vénus Moscovite; Richelieu estaba prendado de ella y la abuela asegura que casi se pega un tiro por la crueldad con que ella lo trató. En aquel tiempo las damas jugaban al faraón. Cierta vez, jugando en la corte, perdió bajo palabra con el duque de Orleans no sé qué suma inmensa. La abuela al llegar a casa, mientras se despegaba los lunares de la cara y se desataba el miriñaque, le comunicó al abuelo que había perdido en el juego y le mandó que se hiciera cargo de la deuda. Por cuanto recuerdo, mi difunto abuelo era una especie de mayordomo de la abuela. La temía como al fuego y, sin embargo, al oír la horrorosa suma, perdió los estribos: se trajo el libro de cuentas y, tras mostrarle que en medio año se habían gastado medio millón y que ni su aldea cercana a Moscú ni la de Sarátov se encontraban en las afueras de París, se negó en redondo a pagar. La abuela le dio un bofetón y se acostó sola en señal de enojo. Al día siguiente mandó llamar a su marido con la esperanza de que el castigo doméstico hubiera surtido efecto, pero lo encontró incólume. Por primera vez en su vida la abuela accedió a entrar en razón y a dar explicaciones; pensaba avergonzarlo, y se dignó a demostrarle que había deudas y deudas, como había diferencia entre un príncipe y un carretero. ¡Pero ni modo! ¡El abuelo se había sublevado y seguía en sus trece! La abuela no sabía qué hacer. Anna Fedótovna era amiga íntima de un hombre muy notable. Habréis oído hablar del conde Saint-Germain, de quien tantos prodigios se cuentan. Como sabréis, se hacía pasar por el judío errante, por el inventor del elixir de la vida, de la piedra filosofal y de muchas cosas más. La gente se reía de él tomándolo por un charlatán, y Casanova en sus memorias dice que era un espía. En cualquier caso, a pesar de todo el misterio que lo envolvía, Saint-Germain tenía un aspecto muy distinguido y en sociedad era una persona muy amable. La abuela, que lo sigue venerando hasta hoy y se enfada cuando hablan de él sin el debido respeto, sabía que Saint-Germain podía disponer de grandes sumas de dinero, y decidió recurrir a él. Le es- cribió una nota en la que le pedía que viniera a verla de inmediato. El estrafalario viejo se presentó al punto y halló a la dama sumida en una horrible pena.
        </p>
      </article>
    </section>

  </div><!-- /content questions -->

</section>


<div class="row">
  <section class="correct">
    <div class="left">
      <span class="subject">Simulacro A</span>
    </div>
    <div class="right">
      <span class="send">Enviar respuestas y corregir</span>
      <button type="submit" class="send-square blue">
        <i class="spr ico-arrows-right"></i>
        <i class="spr ico-arrows-right"></i>
      </button>
    </div>
  </section>
</div>