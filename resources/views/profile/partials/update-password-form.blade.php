<div class="card">
    <div class="card-header">
        <div class="card-title mr-3">Update Password</div>

        @if(session('status') == 'password-updated') 
            <span class="text-success text-sm">Saved!</span> 
        @endif
    </div>

    <div class="card-body">
        <p class="text-muted">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div class="mb-3 row">
                <label for="current_password" class="col-sm-2 col-form-label">Current Password</label>
                <div class="col-sm-10">
                    <input
                        name="current_password"
                        type="password"
                        id="current_password"
                        value=""
                        class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                        required>
                    @error('current_password', 'updatePassword')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            <div class="mb-3 row">
                <label for="update_password" class="col-sm-2 col-form-label">New Password</label>
                <div class="col-sm-10">
                    <input
                        name="password"
                        type="password"
                        id="update_password"
                        value=""
                        class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                        required>

                    @error('password', 'updatePassword')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            <div class="mb-3 row">
                <label for="password_confirmation" class="col-sm-2 col-form-label">Confirm Password</label>
                <div class="col-sm-10">
                    <input
                        name="password_confirmation"
                        type="password"
                        id="password_confirmation"
                        value=""
                        class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                        required>

                    @error('password_confirmation', 'updatePassword')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>

