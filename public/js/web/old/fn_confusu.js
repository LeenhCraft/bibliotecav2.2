let divLoading = $("#divLoading");

$(document).ready(function () {
  $("#pregvalid").submit(function (event) {
    event.preventDefault();
    let form = $("#pregvalid").serialize();
    divLoading.css("display", "flex");
    let ajaxUrl = base_url + "web/activar";
    $.post(ajaxUrl, form, function (data) {
      let objData = JSON.parse(data);
      console.log(objData);
      if (objData.status) {
        Swal.fire(objData.title, objData.text, objData.icon);
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
        Swal.fire(objData.title, objData.text, objData.icon);
      }
      divLoading.css("display", "none");
    });
  });
});
