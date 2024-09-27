@extends('layouts.master')
@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Project Lists</h6>
            <button style="margin-bottom: 10px" class="btn btn-primary delete_all"
                data-url="{{ route('restore-all-project') }}">Restore All Selected</button>
        </div>

    </div>
    <div class="card-body">
        <div class="table-responsive" id="listdata">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th width="50px"><input type="checkbox" id="allCheck"></th>
                        <th>Name</th>
                        <th>Staff</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)

                    <tr>
                        <td><input type="checkbox" class="row-check" value="{{ $item->id }}"></td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->staff?->name }}</td>
                        <td>{{ $item->description }}</td>
                    </tr>
                    @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
$('#allCheck').on('click', function(e) {
    if ($(this).is(':checked', true)) {
        $(".row-check").prop('checked', true);
    } else {
        $(".row-check").prop('checked', false);
    }
});
$('.delete_all').on('click', function(e) {
    var allVals = [];
    $('.row-check:checked').each(function() {
        allVals.push($(this).val());
    });
    var join_selected_values = allVals.join(",");
    $.ajax({
        url: $(this).data('url'),
        type: 'POST',
        data: {
            ids: join_selected_values,
            _token: "{{ csrf_token() }}",
        },
        success: function(data) {
            $(".row-check:checked").each(function() {
                $(this).parents("tr").remove();
            });
            toastr.success('Data deleted successfully');
        },
        error: function(data) {
            alert(data.responseText);
        }
    });
});
</script>
@endpush