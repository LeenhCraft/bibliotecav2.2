let divLoading = $("#divLoading");
function flip() {
  $("#usulog").hide("swing");
  $("#usureset").show("slow");
}

function flop() {
  $("#usureset").hide("swing");
  $("#usulog").show("slow");
}

$("#exampleModal")
  .on("shown.bs.modal", function (event) {
    var mdl = $(event.relatedTarget);
    var ths = $(this);
    var resp = ths.find(".modal-body");
    resp.html(
      '<div class="text-center my-5"><div class="spinner-border" style="width: 3rem; height: 3rem;" role="status"><span class="sr-only">Loading...</span></div></div>'
    );

    $.get(mdl.data("url"), function (data, textStatus, jqXHR) {
      if (textStatus == "success") {
        // ths.find(".modal-title").text(mdl.data("title"));
        resp.html(data);
      }
    });
  })
  .on("hidden.bs.modal", function (event) {
    var mbody = $(this).find(".modal-body");
    mbody.empty();
    $(this).find(".login-content").removeClass("modal-lg");
    // $(this).find(".modal-title").text("");
    mbody.html(
      `<div class="text-center my-5"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>`
    );
  });
