<div class="col-md-4">
    <div class="card">
        <div class="card-body">
            <ul class="list-unstyled">
                <li><a href="{{ route('tickets.index') }}">Ticket List</a></li>
                <li class="mt-2"><a href="{{ route('tickets.wait_for_destroy') }}">Ticket wait for destroy</a></li>
                <li class="mt-2"><a href="{{ route('users.index') }}">Users</a></li>
                <li class="mt-2">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">New User</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('users.create') . '?role=customer' }}">Customer</a>
                        <a class="dropdown-item" href="{{ route('users.create') . '?role=reseller' }}">Reseller</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
