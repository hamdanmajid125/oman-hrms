

<form class="needs-validation mt-4 pt-2" method="POST" action="{{ route('register') }}">
    @csrf
    <div class="mb-3">
        <label for="useremail" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
        @error('email')
            <div class="invalid-feedback">
                Please Enter Email
            </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="username" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Enter username" required>
        <div class="invalid-feedback">
            Please Enter Name
        </div>
        @error('name')
            <div class="invalid-feedback">
                Please Enter Email
            </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="userpassword" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password"
            required>
            @error('password')
            <div class="invalid-feedback">
             Password is not meet requirement
            </div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
            placeholder="Enter password" required>
            @error('password_confirmation')
            <div class="invalid-feedback">
             Password dont match
            </div>
        @enderror
    </div>
    <div class="mb-4">
        <p class="mb-0">By registering you agree to the Minia <a href="#" class="text-primary">Terms of Use</a>
        </p>
    </div>
    <div class="mb-3">
        <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Register</button>
    </div>
</form>
