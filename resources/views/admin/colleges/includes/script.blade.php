<script>
    function openEdit{{$module}}Modal(id) {
        const url = "{{ route('admin.colleges.edit', ':id') }}".replace(':id', id);

        $.get(url, function(response) {
            if (response.status === 'success') {
                const data = response.data;
                const moduleId = "{{module_id($module, '')}}";
                
                document.getElementById(moduleId + "Id").value = data.id;
                document.getElementById(moduleId + "Name").value = data.name;
                document.getElementById(moduleId + "UniversityId").value = data.university_id || '';
                document.getElementById(moduleId + "Description").value = data.description || '';
                document.getElementById(moduleId + "Status").value = data.status;
                document.getElementById(moduleId + "Address").value = data.address || '';
                document.getElementById(moduleId + "Phone").value = data.phone || '';
                document.getElementById(moduleId + "Email").value = data.email || '';
                document.getElementById(moduleId + "Website").value = data.website || '';
                document.getElementById(moduleId + "Facebook").value = data.facebook || '';
                document.getElementById(moduleId + "Twitter").value = data.twitter || '';
                document.getElementById(moduleId + "Instagram").value = data.instagram || '';
                document.getElementById(moduleId + "Youtube").value = data.youtube || '';
                document.getElementById(moduleId + "Linkedin").value = data.linkedin || '';
                
                if (data.logo) {
                    const preview = document.getElementById('logoPreview');
                    preview.src = "/storage/" + data.logo;
                    preview.classList.remove('hidden');
                } else {
                    document.getElementById('logoPreview').classList.add('hidden');
                }

                document.querySelector(`#${moduleId}Modal h2`).innerText = "Edit " + "{{$module}}";
                document.querySelector(`#${moduleId}Modal button[type='submit']`).innerText = "Update " + "{{$module}}";
                openModal(moduleId + "Modal");
            }
        });
    }
</script>
