<script>
    function openEditAlgorithmModal(id) {
        let editUrl = "{{ route($base_route . 'edit', ':id') }}".replace(':id', id);

        fetch(editUrl)
            .then(res => res.json())
            .then(response => {
                if (response.status === 'success') {
                    let data = response.data;
                    document.getElementById("{{module_id($module, "id")}}").value = data.id;
                    document.getElementById("{{module_id($module, "name")}}").value = data.name;
                    document.getElementById("{{module_id($module, "description")}}").value = data.description || '';
                    document.getElementById("{{module_id($module, "resource_url")}}").value = data.resource_url || '';
                    document.getElementById("{{module_id($module, "status")}}").value = data.status;

                    // Clear and set categories
                    document.querySelectorAll(".category-checkbox").forEach(cb => cb.checked = false);
                    if (data.categories) {
                        data.categories.forEach(cat => {
                            const cb = document.querySelector(`.category-checkbox[value="${cat.id}"]`);
                            if (cb) cb.checked = true;
                        });
                    }

                    // Clear and set tags
                    document.querySelectorAll(".tag-checkbox").forEach(cb => cb.checked = false);
                    if (data.tags) {
                        data.tags.forEach(t => {
                            const cb = document.querySelector(`.tag-checkbox[value="${t.id}"]`);
                            if (cb) cb.checked = true;
                        });
                    }

                    if (data.image) {
                        const preview = document.getElementById("imagePreview");
                        preview.src = "/" + data.image;
                        preview.classList.remove("hidden");
                    } else {
                        document.getElementById("imagePreview").classList.add("hidden");
                    }

                    document.querySelector("#{{module_id($module, "modal")}} h2").innerText = "Edit {{$module}}";
                    document.querySelector("#{{module_id($module, "modal")}} button[type='submit']").innerText = "Update {{$module}}";
                    openModal("{{module_id($module, "modal")}}");
                } else {
                    alert(response.message);
                }
            })
            .catch(err => {
                console.error(err);
                alert("Failed to fetch algorithm details.");
            });
    }

    // Image preview logic
    document.getElementById("algorithmImage").addEventListener("change", function(e) {
        const preview = document.getElementById("imagePreview");
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove("hidden");
            }
            reader.readAsDataURL(file);
        }
    });
</script>
