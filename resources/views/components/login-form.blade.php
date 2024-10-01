@if ($errors->any())
<div class="alert alert-danger mt-3">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<form class="mt-4 pt-2" method="POST" action="{{ route('login') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" value="{{ old('email') }}" name="email" id="email" placeholder="Enter Email" required>
    </div>
    <div class="mb-3">
        <div class="d-flex align-items-start">
            <div class="flex-grow-1">
                <label class="form-label">Password</label>
            </div>
            <div class="flex-shrink-0">
                <div class="">
                    <a href="auth-recoverpw.html" class="text-muted">Forgot password?</a>
                </div>
            </div>
        </div>
        
        <div class="input-group auth-pass-inputgroup">
            <input type="password"   name="password" val class="form-control" placeholder="Enter password" aria-label="Password" aria-describedby="password-addon" required>
            <button class="btn btn-light shadow-none ms-0" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember-check">
                <label class="form-check-label" for="remember-check">
                    Remember me
                </label>
            </div>  
        </div>
        
    </div>
    <div class="mb-3">
        <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Log In</button>
    </div>
</form> 