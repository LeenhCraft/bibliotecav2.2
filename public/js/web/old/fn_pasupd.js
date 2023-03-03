let divLoading = $("#divLoading");
$(document).ready(function () {
  $("#passupd").submit(function (event) {
    event.preventDefault();
    let form = $("#passupd").serialize();
    divLoading.css("display", "flex");
    let ajaxUrl = base_url + "web/actualizar";
    $.post(ajaxUrl, form, function (data) {
      let objData = JSON.parse(data);
      if (objData.status) {
        Swal.fire({
          title: objData.title,
          icon: objData.icon,
          text: objData.text,
          // toast: true,
          // position: "top-end",
          showConfirmButton: false,
          timer: 1500,
          timerProgressBar: true,
        }).then((result) => {
          if (result.dismiss === Swal.DismissReason.timer) {
            window.location.href = base_url;
          }
        });
      } else {
        Swal.fire({
          title: objData.title,
          text: objData.text,
          icon: objData.icon,
          confirmButtonText: "ok",
        });
      }
      divLoading.css("display", "none");
      $("#regusu").trigger("reset");
    });
  });
});
