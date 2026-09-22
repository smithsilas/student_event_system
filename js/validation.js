// =========================================================
// Registration form: validation + confirm-before-submit
// =========================================================

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("registrationForm");
    if (!form) return;

    const confirmModalEl = document.getElementById("confirmModal");
    const confirmModal = new bootstrap.Modal(confirmModalEl);
    const confirmBody = document.getElementById("confirmModalBody");
    const confirmBtn = document.getElementById("confirmSubmitBtn");

    // Feature 1: Bootstrap-style client-side validation
    form.addEventListener("submit", function (e) {
        e.preventDefault(); // always intercept first — we show a confirm step

        if (!form.checkValidity()) {
            e.stopPropagation();
            form.classList.add("was-validated");
            return;
        }

        // Feature 2: confirm-before-submit modal, populated with entered data
        const name = document.getElementById("student_name").value;
        const admission = document.getElementById("admission_number").value;
        const email = document.getElementById("email").value;
        const eventSelect = document.getElementById("event_id");
        const eventText = eventSelect.options[eventSelect.selectedIndex].text;

        confirmBody.innerHTML = `
            <p class="mb-2"><strong>Name:</strong> ${escapeHtml(name)}</p>
            <p class="mb-2"><strong>Admission No.:</strong> ${escapeHtml(admission)}</p>
            <p class="mb-2"><strong>Email:</strong> ${escapeHtml(email)}</p>
            <p class="mb-0"><strong>Event:</strong> ${escapeHtml(eventText)}</p>
        `;

        confirmModal.show();
    });

    // Only truly submit once the user confirms in the modal
    confirmBtn.addEventListener("click", function () {
        confirmModal.hide();
        form.submit();
    });

    // Feature 3: success/error banners (rendered server-side) auto-dismiss after a few seconds
    const statusAlert = document.getElementById("statusAlert");
    if (statusAlert) {
        setTimeout(() => {
            statusAlert.style.transition = "opacity .4s ease";
            statusAlert.style.opacity = "0";
            setTimeout(() => statusAlert.remove(), 400);
        }, 4000);
    }

    // Small UX touch: live character count isn't needed here, but phone
    // field gets a soft format hint as the user types
    const phoneInput = document.getElementById("phone");
    phoneInput.addEventListener("input", function () {
        const valid = /^[0-9+\s-]{0,15}$/.test(phoneInput.value);
        phoneInput.classList.toggle("is-invalid", !valid && phoneInput.value.length > 0);
    });

    function escapeHtml(str) {
        const div = document.createElement("div");
        div.textContent = str;
        return div.innerHTML;
    }
});
