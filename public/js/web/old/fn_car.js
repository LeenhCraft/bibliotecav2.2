$(document).ready(function () {
  mostrar_articulos();
});

function mostrar_articulos() {
  let ajaxUrl = base_url + "carrito/articulos";
  $.get(ajaxUrl, function (data, textStatus, jqXHR) {
    if (textStatus == "success") {
      let objData = JSON.parse(data);
      if (objData.status) {
        $("tbody").html(objData.data);
        $(".step_2").html(objData.data2);
      } else {
        $(".step_2").html(objData.data2);
        $("tbody").html(objData.data);
      }
    }
  });
}

function eliminar(elem, id) {
  Swal.fire({
    toast: true,
    position: "top-end",
    title: "¿Deseas eliminar este articulo?",
    showCancelButton: true,
    confirmButtonText: `Eliminar`,
    confirmButtonColor: "red",
    cancelButtonText: `Cancelar`,
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
      $.post(
        base_url + "carrito/eliminar",
        {
          id: id,
        },
        function (data, textStatus, jqXHR) {
          if (textStatus == "success") {
            var data = JSON.parse(data);
            Toast.fire({
              icon: data.icon,
              title: data.title,
            });
            mostrar_articulos();
            if (data.data == null) {
              $(".step_2").hide("slow").html("");
            }
            $("#cantcar").find(".cant_car").show("slow").html(data.data);
          }
        }
      );
    }
  });
}

function upd_can(e, id) {
  let ajaxUrl = base_url + "carrito/upd";
  let canti = $(e).val();
  if (canti != "" && /^[0-9]+$/.test(canti)) {
    if (canti > 0) {
      var data = {
        id: id,
        cant: canti,
      };
      $.post(ajaxUrl, data, function (data, textStatus, jqXHR) {
        if (textStatus == "success") {
          let objData = JSON.parse(data);
          Toast.fire({
            icon: objData.icon,
            title: objData.text,
          });
          if (objData.status == true) {
            $("#cantcar").find(".cant_car").show("slow").html(objData.data);
          }
          mostrar_articulos();
        }
      });
    } else {
      eliminar(e, id);
    }
  } else {
    Toast.fire({
      icon: "error",
      title: "Ingrese una cantidad valida",
    });
  }
}
