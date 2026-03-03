<script>
    function openEditSubjectModal(id) {
        let editUrl = "{{ route($base_route . 'edit', ':id') }}".replace(':id', id);

        fetch(editUrl)
            .then(res => res.json())
            .then(response => {
                if (response.status === 'success') {
                    let data = response.data;
                    document.getElementById("{{module_id($module, "id")}}").value = data.id;
                    document.getElementById("{{module_id($module, "name")}}").value = data.name;
                    document.getElementById("{{module_id($module, "code")}}").value = data.code || '';
                    document.getElementById("{{module_id($module, "course_id")}}").value = data.course_id;
                    document.getElementById("{{module_id($module, "description")}}").value = data.description || '';

                    document.querySelector("#{{module_id($module, "modal")}} h2").innerText = "Edit {{$module}}";
                    document.querySelector("#{{module_id($module, "modal")}} button[type='submit']").innerText = "Update {{$module}}";
                    openModal("{{module_id($module, "modal")}}");
                } else {
                    alert(response.message);
                }
            })
            .catch(err => {
                console.error(err);
                alert("Failed to fetch subject details.");
            });
    }
</script>
