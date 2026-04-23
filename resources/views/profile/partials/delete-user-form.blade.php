<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('Delete Account') }}</h3>
    </div>

    <div class="card-body">
        <p class="text-muted">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>

        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteAccountModal">
            {{ __('Delete Account') }}
        </button>
    </div>
</div>


{{-- Modal --}}
<div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')

                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="deleteAccountModalLabel">
                        {{ __('Confirm Delete Account') }}
                    </h5>

                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


                <div class="modal-body">

                    <p>
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm.') }}
                    </p>

                    <div class="form-group mt-3">
                        <label for="delete_password">{{ __('Password') }}</label>

                        <input
                            type="password"
                            name="password"
                            id="delete_password"
                            class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                            placeholder="{{ __('Password') }}"
                            required>

                        @error('password', 'userDeletion')
                        <span class="invalid-feedback d-block">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>

                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        {{ __('Cancel') }}
                    </button>

                    <button type="submit" class="btn btn-danger">
                        {{ __('Delete Account') }}
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>


{{-- Auto reopen modal if validation fails --}}
@if($errors->userDeletion->isNotEmpty())
@section('js')
<script>
    $(document).ready(function() {
        $('#deleteAccountModal').modal('show');
    });
</script>
@stop
@endif