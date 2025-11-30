<script>
    $(document).ready(function () {
        @if(Route::has($base_route . 'destroy'))
        $(document).on('click', '.deleteBtn', function () {
            let itemId = $(this).data("id");

            let deleteUrl = "{{ route($base_route . 'destroy', ':id') }}".replace(':id', itemId);

            Swal.fire({
                title: 'Are you sure?',
                text: "This will soft delete the {{ $module }}!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'sharp-btn',
                    cancelButton: 'sharp-btn'
                },
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: deleteUrl,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status === "success") {
                                Swal.fire('Deleted!', response.message, 'success');
                                $('#{{ $table_id }}').DataTable().ajax.reload();
                            } else {
                                Swal.fire('Error!', response.message, 'error');
                            }
                        },
                        error: function(xhr) {
                            Swal.fire('Error!', 'Something went wrong!', 'error');
                        }
                    });
                }
            });
        });
        @endif
    });
</script>
