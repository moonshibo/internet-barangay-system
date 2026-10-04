<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citizen Registration</title>
</head>
<body>

    <h1>Citizen Registration</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/register">
        @csrf

        <div>
            <label for="name">Name</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                required
            >
        </div>

        <div>
            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required
            >
        </div>

        <div>
            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                required
            >
        </div>

        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                required
            >
        </div>

        <div>
            <h2>Privacy Notice</h2>

            <p>
                By registering, you acknowledge that the information you provide
                will be collected and processed for the purposes of providing
                barangay services and managing your account.
            </p>

            <p>
                You may contact the barangay regarding questions about the
                collection and use of your personal information.
            </p>

            <label>
                <input
                    type="checkbox"
                    name="privacy_consent"
                    value="1"
                    {{ old('privacy_consent') ? 'checked' : '' }}
		      required
                >
                I have read and agree to the Privacy Notice.
            </label>
        </div>

        <button type="submit">Register</button>
    </form>

</body>
</html>
