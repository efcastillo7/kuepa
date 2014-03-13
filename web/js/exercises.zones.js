var colors = [
    "#4271B5",
    "#FE8E16",
    "#3B3B3B",
    "#BCD631",
    "#D63173",
    "#D7D7D7",
    "#90AFDD",
    "#AF8640",
    "#4F9242",
    "#F4EB24",
    "#ED2024",
    "#45C7F0"
];
var stage;
var layer;
var zones = [];
var iniX;
var iniY;
var isDown = false;

/**
 * Initiates an interactive zone question
 * @returns {undefined}
 */
function initQuestionInteractive() {
    var $scope = $("#questionEditor");
    var $items = $("#image-edition .tool-item", $scope);

    //Triggered when a zone is added
    $(".addZone li", $scope).click(onAddZoneClicked);

    //Triggered when a zone is marked as active
    $items.click(onZoneClicked);

    //Triggered when a zone is removed
    $("#image-edition .tool-item .remove").click(onRemoveZoneClicked);

    //Initiates the stage
    initStage();

    onTinyMCEChangeCallback = checkForImages;

    checkForImages();

}

/**
 * Initiates the KineticJS stage
 * @returns {undefined}
 */
function initStage() {

    var $stage = $("#stage");
    var $scope = $("#questionEditor");
    var $items = $("#image-edition .tool-item", $scope);

    layer = new Kinetic.Layer();
    stage = new Kinetic.Stage({
        container: $('#stage').get(0),
        width: $stage.width(),
        height: $stage.height()
    });

    stage.add(layer);

    $stage
        .off()
        .on("mousedown touchstart", onDrawStart)
        .on("mousemove touchmove", onDraw)
        .on('mouseup touchend', onDrawEnd);

    $("#image-edition .tool-item .type").unbind().change(onShapeChange);
    $items.each(function(i){ initShape(i); });

}

/**
 * Places a shape in the stage for the first time
 * @param {int} i
 * @param {string} selectedShape
 * @returns {undefined}
 */
function initShape(i,selectedShape) {
    var $this = $("#image-edition .tool-item:eq("+i+")");
    var config = {"radius":10,"stroke":"lightgray","strokeWidth":1,"sides":4,"fill":colors[i],"opacity":0.6};
    var shapeData = $(".shape-data",$this).val();
    var shape;
    var zone;

    if(!!selectedShape){
        shape = selectedShape;
    }else{
        shape = $(".type",$this).val();
        try{
            var shapeJson = JSON.parse(shapeData);
            if(shapeJson){
                $.extend(config,shapeJson);
                if(!!config.shape){
                    $(".type",$this).val(config.shape);
                    shape = config.shape;
                }
            }
        }catch(error){

        }

    }

    switch (shape) {
        case "circle":
            zone = new Kinetic.Circle(config);
        break;
        case "rectangle":
            zone = new Kinetic.Rect(config);
        break;
    }

    zones[i] = zone;
    layer.add(zone);
    layer.draw();

}

/**
 * Trigerred when a zone is clicked
 * @returns {undefined}
 */
function onZoneClicked() {
    var $this = $(this);
    $(".tool-item.active").removeClass("active");
    $this.addClass("active");
    activeItem = $this;
}

/**
 * Triggered when a zone is added
 * @param {Event} e
 * @returns {undefined}
 */
function onAddZoneClicked(e) {
    var $this = $(this);
    var type = $this.attr("data-type");
    var $scope = $("#questionEditor");
    var params = {
        question_id: $(".question_id", $scope).val()
    };
    var i = $(".zones-container .tool-item").length;

    e.preventDefault();

    if(i>=12){
        alert("Sólo se admiten hasta 12 zonas");
        return;
    }

    var $clon = $(".tool-item.ignore").clone(false);

    modified = true;

    $clon
        .removeClass("ignore")
        .appendTo($(".zones-container", $scope))
        .click(onZoneClicked)
        .find(".remove").click(onRemoveZoneClicked);
    $clon.find(".color").removeClass("zone-color-1").addClass("color zone-color-" + (i+1));

    $.post("/exercise/addAnswer", params, function(data) {

        if (data.status === "success") {

            //Introduction question_id
            var answer_id = data.answer_id;

            $clon
                 .attr("data-id", answer_id)
                 .find(".title").attr("name", "zone-text-" + answer_id);
            $clon.find(".value").attr("name", "zone-value-" + answer_id);
            $clon.find(".shape-data").attr("name", "zone-type-" + answer_id);
            $clon.find("select.type")
                    .val(type)
                    .change(onShapeChange);
            $clon.addClass("active");
            activeItem = $clon;

            initShape(i,type);
        } else {
            alert("Se produjo un error al crear la respuesta");
        }
    }, "JSON");

}

/**
 * Triggered when the user starts drawing
 * @returns {Boolean}
 */
function onDrawStart() {
    var $activeZone = $(".tool-item.active");

    if (!$activeZone.length) {
        return false;
    }

    var i = $activeZone.index();
    var zone = zones[i];
    var mouse = stage.getMousePosition();

    zone.setPosition(mouse.x, mouse.y);
    layer.draw();

    isDown = true;
    iniX = mouse.x;
    iniY = mouse.y;
    modified = true;
}

/**
 * Triggered while drawing
 * @returns {Boolean|undefined}
 */
function onDraw() {
    if (!isDown) {
        return;
    }

    var $activeZone = $(".tool-item.active");
    if (!$activeZone.length) {
        return false;
    }

    var i = $activeZone.index();
    var zone = zones[i];
    var mouse = stage.getMousePosition();
    var dx = mouse.x - iniX;
    var dy = mouse.y - iniY;
    var shape = $("select.type", $activeZone).val();

    switch(shape){
        case "circle":
            var radius = Math.sqrt(dx * dx + dy * dy);
            zone.setRadius(radius);
        break;
        case "rectangle":
            zone.setWidth(dx);
            zone.setHeight(dy);
        break;
        case "polygon": break;
    }

    layer.draw();
}

/**
 * Triggered when the user stops drawing
 * @returns {Boolean}
 */
function onDrawEnd() {
    var $activeZone = $(".tool-item.active");
    if (!$activeZone.length) {
        return false;
    }

    var i = $activeZone.index();
    var zone = zones[i];
    var shape = $("select.type", $activeZone).val();

    layer.draw();
    isDown = false;

    var shape_data = {
        x: zone.getX(),
        y: zone.getY(),
        fill: colors[i],
        stroke: "lightgray",
        strokeWidth: 1
    };

    switch(shape){
        case "circle":
            shape_data.radius = zone.getRadius();
            shape_data.shape = "circle";
        break;
        case "rectangle":
            shape_data.width = zone.getWidth();
            shape_data.height = zone.getHeight();
            shape_data.sides = 4;
            shape_data.shape = "rectangle";
        break;
        case "polygon": break;
    }

    $(".shape-data", $activeZone).val(JSON.stringify(shape_data));
}

/**
 * Triggered when a zone is removed
 * @param {Event} e
 * @returns {undefined}
 */
function onRemoveZoneClicked(e){
    e.preventDefault();

    if (window.confirm("¿Está seguro que desea remover esta zona?")) {

        var $item = $(this).parents(".tool-item");
        var i = $item.index();
        $item.addClass("loading");

        modified = true;

        if ($item.attr("data-id") !== "") {
            var params = {
                answer_id: $item.attr("data-id")
            };

            $.post("/exercise/removeAnswer", params, function(data) {

                if (data.status === "success") {

                    $item.remove();
                    zones[i].destroy();
                    zones.splice(i, 1);
                    layer.draw();

                } else {
                    alert("Se produjo un error al eliminar la zona");
                }
            }, "JSON");
        } else {
            $item.remove();
        }

    }
}

/**
 * Triggered when a shape type is changed
 * @param {Event} e
 * @returns {Boolean}
 */
function onShapeChange(e){
    var $this = $(this);
    var $activeZone = $(".tool-item.active");
    if (!$activeZone.length) {
        return false;
    }
    var i = $activeZone.index();

    zones[i].destroy();
    layer.draw();

    initShape(i,$this.val());
}

function checkForImages(e){
    var $content = $(tinymce.get($("[name='exercise[description]']").attr("id")).getContent());
    var $img = $("img:first",$content);
    var $stage = $("#stage");

    if($img.length){
        $stage.css({
            "background-image": "url("+$img.attr("src")+")"
        });
    }
}