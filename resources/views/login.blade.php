<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Figured Blog</title>
    </head>
    <body>
        <h1>Login</h1>

        <form method="POST" action="/login">
            @csrf

            <div>
                <label for="email">Email</label>
                <input type="text" name="email" />
                @if($errors->has('email'))
                    <span style="color: red;">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div>
                <label for="password">Password</label>
                <input type="password" name="password" />
                @if($errors->has('password'))
                    <span style="color: red;">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <div>
                <button type="submit">Login</button>
            </div>
        </form>
    </body>
</html>