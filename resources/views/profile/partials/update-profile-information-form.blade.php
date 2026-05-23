<div class="card">
    <div class="card-header">
        <div class="card-title">{{ __('Profile Information') }}</div>
    </div>
    <div class="card-body">
        <p class="text-muted">{{ __("Update your account's profile information and email address.") }}</p>
        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name', $user->name) }}"
                    class="form-control @error('email') is-invalid @enderror">
                @error('name')
                <span class="invalid-feedback d-block">
                    {{ $message }}
                </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input
                    type="text"
                    name="email"
                    id="email"
                    value="{{ old('email', $user->email) }}"
                    class="form-control @error('email') is-invalid @enderror">

                @error('email')
                <span class="invalid-feedback d-block">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="avatar" class="form-label">Avatar</label>
                <input
                    type="file"
                    name="avatar"
                    id="avatar"
                    class="form-control-file">

                @error('avatar')
                <span class="invalid-feedback d-block">{{ $message }}</span>
                @enderror
            </div>

            @if(auth()->user()->avatar_url)
            <div class="card-body">
                <img src="{{ route('avatar.show') }}" alt="Avatar" style="width: 200px;">
            </div>
            @endif

            <button class="btn btn-primary" type="submit">
                Save
            </button>
        </form>

    </div>
</div>