<script>

    let table;
    $(document).ready(function () {

        table = $('#{{$table_id}}').DataTable({
            processing: true,
            serverSide: true,
            deferRender: true,
            scrollY: 450,
            responsive: true,
            scrollX: false,
            searching: false,
            scroller: {
                loadingIndicator: true
            },
            pageLength: 10,
            ajax: {
                url: "{{ route('admin.universities.data') }}",
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                data: function (d) {
                    d.search_value = $('#searchUniversities').val();
                }

            },
            columns: [
                { data: "DT_RowIndex", name: "DT_RowIndex", orderable: false, searchable: false },
                { data: "name", name: "name"},
                { data: "address", name: "address" },
                { data: "phone", name: "phone" },
                { data: "email", name: "email" },
                { data: "created_at", name: "created_at" },
                { data: "action", name: "action", orderable: false },
            ]
        });

        $('#searchUniversities').on('keyup', function () {
            table.draw();
        });

    });

</script>


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
       Close Button Functions
    ---------------------------------------*/
    function closeUniversityModal() {
        closeModal("universityModal");
    }

    /* --------------------------------------
       Submit Handlers (AJAX-ready)
    ---------------------------------------*/
    function handleUniversitySubmit(event) {
        event.preventDefault();

        const form = document.getElementById("universityForm");
        const formData = new FormData(form);

        fetch("{{ route('admin.universities.store') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
            },
            body: formData
        })
            .then(async response => {

                // Validation error (422)
                if (response.status === 422) {
                    const errorData = await response.json();
                    showValidationErrors(errorData.errors);
                    return;
                }

                // Success
                const data = await response.json();
                if(data.status==="success") {
                    Toastify({
                        text: data.message,
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "#16a34a", // Tailwind green-600
                    }).showToast();
                    table.ajax.reload(null, false);
                }

                if(data.status==="error") {
                    Toastify({
                        text: data.message,
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "#dc2626", // Tailwind green-600
                    }).showToast();
                }

                closeUniversityModal();
            })
            .catch(error => {
                console.error("Error:", error);
            });
    }



</script>
