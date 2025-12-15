console.log("Sistema de control de préstamos activo");
const campos = document.querySelectorAll("input");

campos.forEach(campo => {
    campo.addEventListener("input", () => {
        campo.setCustomValidity("");
        if (!campo.checkValidity()) {
            campo.setCustomValidity(campo.title);
        }
    });
});

