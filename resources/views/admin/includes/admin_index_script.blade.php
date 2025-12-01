<script>
    /* --------------------------------------
       Open SystemInfo Modal
    ---------------------------------------*/
    document.getElementById("add{{$module}}Btn").addEventListener("click", () => {
        const form = document.getElementById("{{module_id($module, "form")}}");
        form.reset();
        document.getElementById("{{module_id($module, "id")}}").value = ''; // clear id
        document.querySelector("#{{module_id($module, "modal")}} h2").innerText = "Add {{$module}}";
        document.querySelector("#{{module_id($module, "modal")}} button[type='submit']").innerText = "Add {{$module}}";
        openModal("{{module_id($module, "modal")}}");
    });
    /* --------------------------------------
       Open SystemInfo Edit Modal
    ---------------------------------------*/
    document.addEventListener("click", function (e) {
        if (e.target.closest(".editBtn")) {
            const button = e.target.closest(".editBtn");
            const id = button.dataset.id; // Make sure your button has data-id attribute
            openEdit{{$module}}Modal(id);
        }
    });

    /* --------------------------------------
       Close Button Functions
    ---------------------------------------*/
    function close{{$module}}Modal() {
        closeModal("{{module_id($module, "modal")}}");
    }

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
       Handle Submit for form
    ---------------------------------------*/
    function handle{{$module}}Submit(event) {

        event.preventDefault();

        const form = document.getElementById("{{module_id($module, "form")}}");
        const formData = new FormData(form);

        // Check if it's edit mode
        const uniId = document.getElementById("{{module_id($module, "id")}}").value;
        let url = "{{ route($base_route .'store') }}";
        let method = "POST";

        if (uniId) {
            url = "{{ route($base_route . 'update', ':id') }}".replace(':id', uniId);
            method = "POST";
            formData.append("_method", "PUT");
        }

        fetch(url, {
            method: method,
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
            },
            body: formData
        })
            .then(async response => {

                if (response.status === 422) {
                    const errorData = await response.json();
                    const errors = errorData.errors;

                    document.querySelectorAll(".error-message").forEach(el => el.remove());

                    for (let field in errors) {
                        const messages = errors[field]; // array of messages
                        const inputField = document.querySelector(`[name="${field}"]`);

                        if (inputField) {
                            messages.forEach(msg => {
                                const errorP = document.createElement("p");
                                errorP.className = "error-message text-red-500 text-sm mt-1";
                                errorP.textContent = msg;

                                inputField.insertAdjacentElement("afterend", errorP);
                            });
                        }
                    }
                }

                const data = await response.json();
                if (data.status === "success") {
                    close{{$module}}Modal();
                    Toastify({
                        text: data.message,
                        duration: 3000,
                        close: true,
                        gravity: "bottom",
                        position: "right",
                        backgroundColor: "#16a34a",
                    }).showToast();
                    table.ajax.reload(null, false);
                }

                if (data.status === "error") {
                    Toastify({
                        text: data.message,
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "#dc2626",
                    }).showToast();
                }

            })
            .catch(error =>
                Toastify({
                    text: "Unable to process request, please try again later.",
                    duration: 3000,
                    close: true,
                    gravity: "bottom",
                    position: "right",
                    backgroundColor: "#dc2626",
                }).showToast()
            );
    }

    let table;
    $(document).ready(function () {
        let tableColumns = @json($columns);
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
                url: "{{ $ajax_url }}",
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                data: function (d) {
                    d.search_value = $('#search{{ $table_id }}').val();
                }

            },
            columns: tableColumns
        });

        $('#search{{ $table_id }}').on('keyup', function () {
            table.draw();
        });
    });

    $(document).ready(function () {
        @if(Route::has($base_route . 'destroy'))
        $(document).on('click', '.deleteBtn', function () {
            let itemId = $(this).data("id");

            let deleteUrl = "{{ route($base_route . 'destroy', ':id') }}".replace(':id', itemId);

            Swal.fire({
                title: 'Are you sure?',
                text: "This will soft delete the {{ $module }}!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'sharp-btn',
                    cancelButton: 'sharp-btn'
                },
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: deleteUrl,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            if (response.status === "success") {
                                Swal.fire('Deleted!', response.message, 'success');
                                $('#{{ $table_id }}').DataTable().ajax.reload();
                            } else {
                                Swal.fire('Error!', response.message, 'error');
                            }
                        },
                        error: function (xhr) {
                            Swal.fire('Error!', 'Something went wrong!', 'error');
                        }
                    });
                }
            });
        });
        @endif


    });
</script>
