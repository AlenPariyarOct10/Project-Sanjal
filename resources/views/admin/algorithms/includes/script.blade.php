<script>
    function openEditAlgorithmModal(id) {
        let moduleId = "{{ strtolower($module) }}";
        let editUrl = "{{ route($base_route . 'edit', ':id') }}".replace(':id', id);

        fetch(editUrl)
            .then(res => res.json())
            .then(response => {
                if (response.status === 'success') {
                    let data = response.data;
                    document.getElementById(moduleId + "Id").value = data.id;
                    document.getElementById(moduleId + "Name").value = data.name;
                    document.getElementById(moduleId + "Description").value = data.description || '';
                    document.getElementById(moduleId + "Resource_url").value = data.resource_url || '';
                    document.getElementById(moduleId + "Status").value = data.status;

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

                    document.querySelector("#" + moduleId + "Modal h2").innerText = "Edit Algorithm";
                    document.querySelector("#" + moduleId + "Modal button[type='submit']").innerText = "Update Algorithm";
                    openModal(moduleId + "Modal");
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
