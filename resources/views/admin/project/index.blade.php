@extends('layouts.master')
@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Project Lists</h6>
            <a href="{{ route('project-create') }}" class="btn btn-primary btn_modal">Create New Project</a>
        </div>

    </div>
    <div class="card-body">
        <div class="table-responsive" id="listdata">

        </div>
    </div>
</div>
@endsection

@push('script')
<script>
$(document).ready(function() {
    loadItems();
    $(document).on("click", ".btn_modal", function(e) {
        e.preventDefault();
        var url = $(this).attr("href");
        $.ajax({
            type: "GET",
            url: url,
            data: {},
            success: function(res) {
                $("div#common_modal").html(res).modal("show");
                var myDropzone = new Dropzone("#kt_dropzonejs_example_1", {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('upload.store') }}",
                    paramName: 'attachment[]',
                    addRemoveLinks: true,
                    maxFilesize: 10,
                    dictResponseError: 'Error uploading file!',
                    sending: function(file, xhr, formData) {
                        formData.append("_token", "{{ csrf_token() }}");
                    },
                });
            },
        });
    });

    $(document).on("submit", "#form", function(e) {
        e.preventDefault();
        $('#name, #assign_staff_id, #status').removeClass('add-border-red');
        var form = $(this);
        var actionUrl = form.attr('action');
        var formData = new FormData(form[0]);
        $.ajax({
            url: actionUrl,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                toastr.success('Data submitted successfully');
                $('#common_modal').modal('hide');
                form[0].reset();
                loadItems();
            },
            error: function(response) {
                if (response.status === 422) {
                    var errors = response.responseJSON.error;
                    $.each(errors, function(key, value) {
                        $('#' + key).addClass('add-border-red');
                    });
                }
            }
        });
    });

    function loadItems() {
        $.ajax({
            url: '/get/progects',
            type: 'get',
            datatype: 'html',
            success: function(data) {
                $('#listdata').html(data);
            },
        });
    }

    $(document).on("click", ".show_confirm", function(e) {
        e.preventDefault();
        var form = $(this).closest("form");
        Swal.fire({
            title: 'Do you want to delete ?',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: `Delete`,

        }).then((result) => {
            if (result.isConfirmed) {
                deleteRecord(form);
            }
        });
    });

    function deleteRecord(form) {
        axios.delete(form.attr('action'))
            .then(response => {
                toastr.success('Data deleted successfully');
                loadItems();
            })
            .catch(error => {
                console.error(error.response.data);
            });
    }


});
</script>
@endpush