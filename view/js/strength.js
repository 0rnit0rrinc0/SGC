$(function () {
  $(document).on("keyup", "#pass1, #pass2", function () {
    var foo = $("#pass1").val().trim();
    var bar = $("#pass2").val().trim();

    $("#poo").text("Las contraseñas deben coincidir.");
    $("#length").text("Poseer al menos 8 carácteres.");
    $("#letter").text("Poseer al menos una letra.");
    $("#number").text("Poseer al menos un numero.");
    if (!foo || !bar || foo == "" || bar == "") {
      $("#poo").removeClass("valid").addClass("invalid");
      /* .text("Las contraseñas no coinciden"); */
    } else {
      if (foo !== bar) {
        $("#poo").removeClass("valid").addClass("invalid");
        /* .text("Las contraseñas no coinciden"); */
      } else {
        $("#poo").removeClass("invalid").addClass("valid");
        /* .text("Las contraseñas si coinciden"); */
      }
    }

    if (foo.length < 8) {
      $("#length").removeClass("valid").addClass("invalid");
      /* .text("Posee al menos 8 carácteres."); */
    } else {
      $("#length").removeClass("invalid").addClass("valid");
      /* .text("Posee al menos 8 carácteres."); */
    }

    if (foo.match(/[A-z]/)) {
      $("#letter").removeClass("invalid").addClass("valid");
      /* .text("Sí posee letras."); */
    } else {
      $("#letter").removeClass("valid").addClass("invalid");
      /* .text("No posee ninguna letra."); */
    }

    if (foo.match(/\d/)) {
      $("#number").removeClass("invalid").addClass("valid");
      /* .text("Sí posee numeros."); */
    } else {
      $("#number").removeClass("valid").addClass("invalid");
      /* .text("No posee ningún numero."); */
    }

    if (
      foo == bar &&
      foo.length >= 8 &&
      foo.match(/[A-z]/) &&
      foo.match(/\d/)
    ) {
      $("#btn")
        .prop("disabled", false)
        .removeClass("registerbtnm")
        .addClass("registerbtng");
    } else {
      $("#btn")
        .prop("disabled", true)
        .removeClass("registerbtng")
        .addClass("registerbtnm");
      $("#txt2")
        .text("La contraseña no cumple los requisitos.")
        .removeClass("valid")
        .addClass("invalid");
    }
  });
  $("#txt").text("Los requisitos para una contraseña son:");
  $("#poo").text("Las contraseñas deben coincidir.");
  $("#length").text("Poseer al menos 8 carácteres.");
  $("#letter").text("Poseer al menos una letra.");
  $("#number").text("Poseer al menos un numero.");
});

/* $(document).ready(function () {
  $("#pass").keyup(function () {
      var pswd = $(this).val();

      //validar longitud contraseña
      if (pswd.length < 8) {
        $("#length").removeClass("valid").addClass("invalid");
      } else {
        $("#length").removeClass("invalid").addClass("valid");
      }
      //validate letter
      if (pswd.match(/[A-z]/)) {
        $("#letter").removeClass("invalid").addClass("valid");
      } else {
        $("#letter").removeClass("valid").addClass("invalid");
      }

      //validate capital letter
      if (pswd.match(/[A-Z]/)) {
        $("#capital").removeClass("invalid").addClass("valid");
      } else {
        $("#capital").removeClass("valid").addClass("invalid");
      }

      //validate number
      if (pswd.match(/\d/)) {
        $("#number").removeClass("invalid").addClass("valid");
      } else {
        $("#number").removeClass("valid").addClass("invalid");
      }

      var foo = $("#pass1").val().trim();
      var bar = $("#pass2").val().trim();
      if (!foo || !bar || foo == "" || bar == "") {
        $("#poo")
          .removeClass("valid")
          .addClass("invalid")
          .text("Las contraseñas no coinciden");
      } else {
        if (foo !== bar) {
          $("#poo")
            .removeClass("valid")
            .addClass("invalid")
            .text("Las contraseñas no coinciden");
        } else {
          $("#poo")
            .removeClass("invalid")
            .addClass("valid")
            .text("Las contraseñas si coinciden");
        }
      }
    })
    .focus(function () {
      $("#pswd_info").show();
    })
    .blur(function () {
      $("#pswd_info").hide();
    });
});
 */
