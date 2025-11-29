<script>
    /* --------------------------------------
       Helper: Open Modal
    ---------------------------------------*/
    function openModal(modalId) {
        const modal = document.getElementById(modalId);

        if (!modal) return;

        modal.style.display = "flex";         // show modal immediately
        requestAnimationFrame(() => {
            modal.classList.add("modal-show");
            modal.classList.remove("modal-hide");
        });
    }

    /* --------------------------------------
       Helper: Close Modal
    ---------------------------------------*/
    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) return;

        modal.classList.add("modal-hide");
        modal.classList.remove("modal-show");

        setTimeout(() => {
            modal.style.display = "none";
        }, 200); // sync with fade-out animation
    }

    /* --------------------------------------
       Click Outside to Close
    ---------------------------------------*/
    document.querySelectorAll(".modal").forEach((modal) => {
        modal.addEventListener("click", (e) => {
            if (e.target.classList.contains("modal")) {
                modal.classList.remove("modal-show");
                setTimeout(() => (modal.style.display = "none"), 200);
            }
        });
    });

    /* --------------------------------------
       ESC Key Close
    ---------------------------------------*/
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            document.querySelectorAll(".modal-show").forEach((modal) => {
                closeModal(modal.id);
            });
        }
    });

    /* --------------------------------------
       Open University Modal
    ---------------------------------------*/
    document.getElementById("addUniversityBtn").addEventListener("click", () => {
        document.getElementById("universityForm").reset();
        openModal("universityModal");
    });

    /* --------------------------------------
       Open College Modal
    ---------------------------------------*/
    document.getElementById("addCollegeBtn").addEventListener("click", () => {
        document.getElementById("collegeForm").reset();
        openModal("collegeModal");
    });

    /* --------------------------------------
       Close Button Functions
    ---------------------------------------*/
    function closeUniversityModal() {
        closeModal("universityModal");
    }

    function closeCollegeModal() {
        closeModal("collegeModal");
    }

    /* --------------------------------------
       Submit Handlers (AJAX-ready)
    ---------------------------------------*/
    function handleUniversitySubmit(event) {
        event.preventDefault();
        // TODO: add AJAX call here
        closeUniversityModal();
    }

    function handleCollegeSubmit(event) {
        event.preventDefault();
        // TODO: add AJAX call here
        closeCollegeModal();
    }
</script>
