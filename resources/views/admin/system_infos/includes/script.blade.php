<script>

    function openEdit{{$module}}Modal(id) {
        const form = document.getElementById("{{module_id($module, "form")}}");
        form.reset();

        // Construct edit URL dynamically
        let editUrl = "{{ route($base_route . 'edit', ':id') }}".replace(':id', id);

        fetch(editUrl)
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    const uni = data.data;

                    document.getElementById("{{module_id($module, "id")}}").value = uni.id;
                    document.getElementById("{{module_id($module, "key")}}").value = uni.key;
                    document.getElementById("{{module_id($module, "value")}}").value = uni.value || '';
                    document.getElementById("{{module_id($module, "status")}}").value = uni.status ? "1" : "0" || '';

                    console.log(uni.status)

                    document.querySelector("#{{module_id($module, "modal")}} button[type='submit']").innerText = "Update {{$module}}";


                    // Change modal title
                    document.querySelector("#{{module_id($module, "modal")}} h2").innerText = "Edit {{$module}}";

                    // Open modal
                    openModal("{{module_id($module, "modal")}}");
                } else {
                    alert(data.message || "Failed to fetch {{$module}} data");
                }
            });
    }

</script>
