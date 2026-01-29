<script>
    const addAlgorithmBtn = document.getElementById("addAlgorithmBtn");
    const algorithmModal = document.getElementById("algorithmModal");
    const closeAlgorithmModal = () => {
        algorithmModal.classList.add("hidden");
    }
    addAlgorithmBtn.addEventListener("click", () => {
        algorithmModal.classList.remove("hidden");
    })

    function handleAlgorithmSubmit(e) {
        e.preventDefault();

        const form = document.getElementById("algorithmForm");
        const submitBtn = document.getElementById("algorithmSubmitBtn");

        let formData = new FormData(form);

        submitBtn.disabled = true;
        submitBtn.innerText = "Saving...";

        fetch("{{ route('admin.algorithms.store') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: formData
        })
            .then(res => res.json())
            .then(response => {
                console.log(response);

                if (response.success) {
                    closeAlgorithmModal();
                    form.reset();
                    page = 1;
                    finished = false;
                    grid.innerHTML = "";
                    loadAlgorithms();
                } else {
                    alert("Error: " + (response.message || "Something went wrong"));
                }
            })
            .catch(err => {
                console.error(err);
                alert("Failed to save algorithm.");
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerText = "Add Algorithm";
            });
    }

</script>


