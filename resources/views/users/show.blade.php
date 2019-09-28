@extends ('layouts.app')

@section ('content')
    <div class="mb-4">
        <a class="btn btn-success text-white" href="{{ route('users.edit', ['user_id' => $result->id]) }}">Edit</a>
    </div>
    <div>
        <p><strong>Name: {{ $result->name }}</strong></p>
        <p><strong>Family: {{ $result->family }}</strong></p>
        <p><strong>Mobile: {{ $result->mobile }}</strong></p>
        <p><strong>Email: {{ $result->email }}</strong></p>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="usersModal" tabindex="-1" role="dialog" aria-labelledby="usersModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="usersModalLabel">Assign User...</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('tickets.assign_user', ['ticket_id' => $result->id]) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="user">Select User:</label>
                            <select class="form-control" name="user_id" id="user_id"></select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function () {
            $.ajax({
                url: '/dashboard/users/list',
                method: 'GET',
                header: {
                    Accept: 'application/json; charset=utf-8'
                },
                success: function (res) {
                    res.result.forEach(function (user) {
                        $('#user_id').append(new Option(user.name + ' ' + user.family, user.id))
                    });
                }
            });
        });
    </script>
@endsection
