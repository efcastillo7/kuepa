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

function initQuestionInteractive() {
    var $scope = $("#questionEditor");
    var $items = $("#image-edition .tool-item", $scope);

    $(".addZone li", $scope).click(onAddZoneClicked);

    $items.click(onZoneClicked);
    $("#image-edition .tool-item .remove").click(onRemoveZoneClicked);

    initStage();

}

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

function onZoneClicked() {
    var $this = $(this);
    $(".tool-item.active").removeClass("active");
    $this.addClass("active");
    activeItem = $this;
}

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

            initShape(i,type);
        } else {
            alert("Se produjo un error al crear la respuesta");
        }
    }, "JSON");

}

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
}

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

function onRemoveZoneClicked(e){
    e.preventDefault();

    if (window.confirm("¿Está seguro que desea remover esta zona?")) {

        var $item = $(this).parents(".tool-item");
        var i = $item.index();
        $item.addClass("loading");


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