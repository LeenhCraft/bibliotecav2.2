let divLoading = $("#divLoading");
$(document).ready(function () {
  $("#passupd").submit(function (event) {
    event.preventDefault();
    let form = $("#passupd").serialize();
    let ajaxUrl = base_url + "web/validar";
    divLoading.css("display", "flex");
    $.post(ajaxUrl, form, function (data) {
      let objData = JSON.parse(data);
      if (objData.status) {
        Swal.fire({
          icon: objData.icon,
          title: objData.title,
          text: objData.text,
          confirmButtonText: "Iniciar Sesión",
        }).then((result) => {
          if (result.isConfirmed) {
            document.location.href = base_url;
          }
        });
      } else {
        if (objData.url != "") {
          Swal.fire({
            icon: objData.icon,
            title: objData.title,
            text: objData.text,
            confirmButtonText: "Ok",
          }).then((result) => {
            if (result.isConfirmed) {
              document.location.href = objData.url;
            }
          });
        } else {
          Swal.fire(objData.title, objData.text, objData.icon);
        }
      }
      divLoading.css("display", "none");
      $("#passupd").trigger("reset");
    });
  });
});
