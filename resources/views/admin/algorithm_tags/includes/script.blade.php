<script>
    function openEditAlgorithmTagModal(id) {
        let moduleId = "{{ strtolower($module) }}";
        let editUrl = "{{ route($base_route . 'edit', ':id') }}".replace(':id', id);

        fetch(editUrl)
            .then(res => res.json())
            .then(response => {
                if (response.status === 'success') {
                    let data = response.data;
                    document.getElementById(moduleId + "Id").value = data.id;
                    document.getElementById(moduleId + "Name").value = data.name;
                    document.getElementById(moduleId + "Status").value = data.status;

                    document.querySelector("#" + moduleId + "Modal h2").innerText = "Edit Algorithm Tag";
                    document.querySelector("#" + moduleId + "Modal button[type='submit']").innerText = "Update Algorithm Tag";
                    openModal(moduleId + "Modal");
                } else {
                    alert(response.message);
                }
            })
            .catch(err => {
                console.error(err);
                alert("Failed to fetch tag details.");
            });
    }
</script>
