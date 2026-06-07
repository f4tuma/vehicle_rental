document.addEventListener("DOMContentLoaded", function () {
  const rentalForm = document.getElementById("rentalForm");

  if (rentalForm) {
    rentalForm.addEventListener("submit", function (e) {
      const startDateInput = document.getElementById("start_date").value;
      const endDateInput = document.getElementById("end_date").value;

      if (startDateInput && endDateInput) {
        const start = new Date(startDateInput);
        const end = new Date(endDateInput);

        if (end <= start) {
          e.preventDefault(); // Stop form processing submission completely
          alert(
            "⚠️ Error validation trigger: Return Date cannot occur before or on your collection date!",
          );
        }
      }
    });
  }
});
