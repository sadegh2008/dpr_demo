@extends ('layouts.app')

@section ('content')
    <form action="{{ route('users.create') }}" method="post">
        @csrf
        <div class="row">
            <div class="form-group col-md-6">
                <label for="name">Name</label>
                <input class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Name..."/>
                @error('name')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="family">Family</label>
                <input class="form-control @error('family') is-invalid @enderror" name="family" id="family" placeholder="family..."/>
                @error('family')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="email..."/>
            @error('email')
            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="mobile">Mobile</label>
            <input type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" id="mobile" placeholder="mobile..."/>
            @error('mobile')
            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input autocomplete="false" type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="password..."/>
            @error('password')
            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input autocomplete="false" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation" placeholder="password..."/>
            @error('confirmation_password')
            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
            @enderror
        </div>
        <input type="hidden" name="role" id="role" value="{{ request('role', '') }}">
        <button class="btn btn-success" type="submit">Save</button>
        <a class="btn btn-secondary" href="{{ route('users.index') }}">Cancel</a>
    </form>
@endsection
