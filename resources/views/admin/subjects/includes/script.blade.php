<script>
    function openEditSubjectModal(id) {
        let moduleId = "{{ strtolower($module) }}";
        let editUrl = "{{ route($base_route . 'edit', ':id') }}".replace(':id', id);

        fetch(editUrl)
            .then(res => res.json())
            .then(response => {
                if (response.status === 'success') {
                    let data = response.data;
                    document.getElementById(moduleId + "Id").value = data.id;
                    document.getElementById(moduleId + "Name").value = data.name;
                    document.getElementById(moduleId + "Code").value = data.code || '';
                    document.getElementById(moduleId + "Course_id").value = data.course_id;
                    document.getElementById(moduleId + "Description").value = data.description || '';

                    document.querySelector("#" + moduleId + "Modal h2").innerText = "Edit Subject";
                    document.querySelector("#" + moduleId + "Modal button[type='submit']").innerText = "Update Subject";
                    openModal(moduleId + "Modal");
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
