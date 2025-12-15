console.log("Sistema de control de préstamos activo");

document.addEventListener("DOMContentLoaded", () => {

    const equipo = document.getElementById("equipo");
    const aprendiz = document.getElementById("aprendiz");
    const ficha = document.getElementById("ficha");

    const errorEquipo = document.getElementById("error-equipo");
    const errorAprendiz = document.getElementById("error-aprendiz");
    const errorFicha = document.getElementById("error-ficha");

    // SOLO LETRAS
    function soloLetras(input, error, mensaje) {
        input.addEventListener("input", () => {
            if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]*$/.test(input.value)) {
                error.textContent = mensaje;
                input.value = input.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, "");
            } else {
                error.textContent = "";
            }
        });
    }

    // SOLO NÚMEROS
    function soloNumeros(input, error, mensaje) {
        input.addEventListener("input", () => {
            if (!/^[0-9]*$/.test(input.value)) {
                error.textContent = mensaje;
                input.value = input.value.replace(/[^0-9]/g, "");
            } else {
                error.textContent = "";
            }
        });
    }

    soloLetras(equipo, errorEquipo, "⚠️ Solo se permiten letras en el campo Equipo");
    soloLetras(aprendiz, errorAprendiz, "⚠️ Solo se permiten letras en el campo Aprendiz");
    soloNumeros(ficha, errorFicha, "⚠️ Solo se permiten números en el campo Ficha");
});

