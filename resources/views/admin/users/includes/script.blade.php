<script>
    function openEditUserModal(id) {
        let moduleId = "{{ strtolower($module) }}";
        let editUrl = "{{ route($base_route . 'edit', ':id') }}".replace(':id', id);

        fetch(editUrl)
            .then(res => res.json())
            .then(response => {
                if (response.status === 'success') {
                    let data = response.data;
                    document.getElementById(moduleId + "Id").value = data.id;
                    document.getElementById(moduleId + "Name").value = data.name;
                    document.getElementById(moduleId + "Email").value = data.email;
                    document.getElementById(moduleId + "RoleId").value = data.role_id;
                    document.getElementById(moduleId + "CollegeId").value = data.college_id || '';
                    document.getElementById(moduleId + "Status").value = data.status;
                    
                    // Password should stay empty on edit unless user wants to change it
                    document.getElementById(moduleId + "Password").value = '';

                    document.querySelector("#" + moduleId + "Modal h2").innerText = "Edit User";
                    document.querySelector("#" + moduleId + "Modal button[type='submit']").innerText = "Update User";
                    openModal(moduleId + "Modal");
                } else {
                    alert(response.message);
                }
            })
            .catch(err => {
                console.error(err);
                alert("Failed to fetch user details.");
            });
    }
</script>
