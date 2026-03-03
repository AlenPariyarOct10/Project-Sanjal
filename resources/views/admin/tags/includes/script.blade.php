<script>
    function openEditTagModal(id) {
        const form = document.getElementById("{{module_id($module, "form")}}");
        form.reset();

        // Construct edit URL dynamically
        let editUrl = "{{ route($base_route . 'edit', ':id') }}".replace(':id', id);

        fetch(editUrl)
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    const row = data.data;

                    // Fill form fields
                    document.getElementById("{{module_id($module, "id")}}").value = row.id;
                    document.getElementById("tagName").value = row.name;
                    document.getElementById("tagKey").value = row.key;
                    document.getElementById("tagSlug").value = row.slug;

                    document.querySelector("#{{module_id($module, "modal")}} button[type='submit']").innerText = "Update {{$module}}";
                    document.querySelector("#{{module_id($module, "modal")}} h2").innerText = "Edit {{$module}}";

                    // Open modal
                    openModal("{{module_id($module, "modal")}}");
                } else {
                    alert(data.message || "Failed to fetch data");
                }
            });
    }

    document.addEventListener("DOMContentLoaded", function () {
        const nameInput = document.getElementById("tagName");
        const keyInput = document.getElementById("tagKey");
        const slugInput = document.getElementById("tagSlug");

        // Function to convert name → key
        function generateKey(text) {
            return text
                .trim()
                .toLowerCase()
                .replace(/\s+/g, "_");  // spaces → underscore
        }

        function generateSlug(text) {
            return text
                .trim()
                .toLowerCase()
                .replace(/\s+/g, "-");  // spaces → dash
        }

        // Auto-generate key & slug on name typing
        if (nameInput) {
            nameInput.addEventListener("input", function () {
                const value = nameInput.value;

                // Only auto-fill if user hasn't manually typed key/slug yet
                if (keyInput && !keyInput.dataset.modified) {
                    keyInput.value = generateKey(value);
                }

                if (slugInput && !slugInput.dataset.modified) {
                    slugInput.value = generateSlug(value);
                }
            });
        }

        // Mark key/slug as manually edited
        if (keyInput) keyInput.addEventListener("input", () => keyInput.dataset.modified = true);
        if (slugInput) slugInput.addEventListener("input", () => slugInput.dataset.modified = true);
    });
</script>
