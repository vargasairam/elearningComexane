function menu() {
  const btn = document.querySelector(".btn_menu");
  const btnClose = document.querySelector(".btn-close");
  const asideMenu = document.querySelector(".aside_nav");

  btn.addEventListener("click", function () {
    asideMenu.classList.add("show");
  });

  btnClose.addEventListener("click", function () {
    asideMenu.classList.remove("show");
  });
}

function forms() {
  // Botones modificar
  document.querySelectorAll(".btn_edit").forEach((btnEdit) => {
    btnEdit.addEventListener("click", () => {
      const form = btnEdit.closest("form");

      // Habilitar inputs
      form.querySelectorAll("input, select, textarea").forEach((field) => {
        field.disabled = false;
      });

      // Toggle botones
      btnEdit.classList.add("d-none");
      form.querySelector(".btn_save_info").classList.remove("d-none");
    });
  });

  // Botones guardar
  document.querySelectorAll(".btn_save_info").forEach((btnSave) => {
    btnSave.addEventListener("click", (e) => {
      e.preventDefault(); // evita submit si aún no guardas

      const form = btnSave.closest("form");

      // Deshabilitar inputs
      form.querySelectorAll("input, select, textarea").forEach((field) => {
        field.disabled = true;
      });

      // Toggle botones
      btnSave.classList.add("d-none");
      form.querySelector(".btn_edit").classList.remove("d-none");
    });
  });
}
