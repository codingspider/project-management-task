<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Name</th>
            <th>Staff</th>
            <th>Description</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)

        <tr>
            <td>{{ $item->name }}</td>
            <td>{{ $item->staff?->name }}</td>
            <td>{{ $item->description }}</td>
            <td>{!! $item->badgeData()!!}</td>
            <td>
                <div class="d-flex">

                    <a href="{{ route('projects.edit', $item->id) }}" class="btn btn-primary btn_modal mr-2"><i
                            class="fa fa-edit">
                            Edit</a>
                    <form action="{{ route('projects.destroy', $item->id) }}" method="post" class="delete-form"
                        id="form">
                        @csrf
                        @method('delete')
                        <button type="button" class="show_confirm btn-outline-dark btn btn-danger"><i
                                class="ph ph-trash"></i>Delete</button>
                    </form>
                </div>
            </td>
        </tr>

        @endforeach
        </tr>
    </tbody>
</table>