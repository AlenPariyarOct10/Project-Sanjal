<script>

    function openEditUniversityModal(id) {
        const form = document.getElementById("universityForm");
        form.reset();

        // Construct edit URL dynamically
        let editUrl = "{{ route($base_route . 'edit', ':id') }}".replace(':id', id);

        fetch(editUrl)
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    const uni = data.data;
                    console.log(uni);
                    // Fill form fields
                    document.getElementById("{{module_id($module, "id")}}").value = uni.id;
                    document.getElementById("{{module_id($module, "name")}}").value = uni.name;
                    document.getElementById("{{module_id($module, "description")}}").value = uni.description || '';
                    document.getElementById("{{module_id($module, "address")}}").value = uni.address || '';
                    document.getElementById("{{module_id($module, "phone")}}").value = uni.phone || '';
                    document.getElementById("{{module_id($module, "email")}}").value = uni.email || '';
                    document.getElementById("{{module_id($module, "website")}}").value = uni.website || '';
                    document.getElementById("{{module_id($module, "facebook")}}").value = uni.facebook || '';
                    document.getElementById("{{module_id($module, "twitter")}}").value = uni.twitter || '';
                    document.getElementById("{{module_id($module, "instagram")}}").value = uni.instagram || '';
                    document.getElementById("{{module_id($module, "youtube")}}").value = uni.youtube || '';
                    document.getElementById("{{module_id($module, "linkedin")}}").value = uni.linkedin || '';
                    document.querySelector("#universityModal button[type='submit']").innerText = "Update University";
                    // Handle logo preview
                    const logoPreview = document.getElementById("logoPreview");
                    if (uni.logo) {
                        logoPreview.src = `{{ asset('') }}${uni.logo}`;
                        logoPreview.classList.remove("hidden");
                    } else {
                        logoPreview.src = '';
                        logoPreview.classList.add("hidden");
                    }

                    // Change modal title
                    document.querySelector("#universityModal h2").innerText = "Edit University";

                    // Open modal
                    openModal("universityModal");
                } else {
                    alert(data.message || "Failed to fetch university data");
                }
            });
    }

    document.getElementById("universityLogo").addEventListener("change", function () {
        const file = this.files[0];
        const preview = document.getElementById("logoPreview");

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.classList.remove("hidden");
        } else {
            preview.src = '';
            preview.classList.add("hidden");
        }
    });


</script>
