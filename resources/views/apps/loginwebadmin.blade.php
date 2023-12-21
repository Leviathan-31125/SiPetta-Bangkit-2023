<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <title>SiPetta</title>
    <style>
        html, body {
            background-color: #224b32;
            margin: 0;
            height: 100%;
        }

        .container-custom {
            background-color: white;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center">
    <div class="container-custom p-4 d-flex justify-content-center align-items-center gap-4 rounded">
        <img class="rounded" src="{{ asset('assets/images/backgrounds/hidroponik.jpg') }}" alt="hidroponik">
        <form action="{{ route('authentication') }}" method="post">
            @csrf
            <img src="{{asset('assets/images/logos/sipetta.png')}}" alt="Logo SiPetta" height="180">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" class="form-control" id="input-email" name="email" aria-describedby="emailHelp">
                @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" id="input-password" name="password">
            </div>
            <button type="submit" class="btn btn-success" style="width: 100%">Login</button>
        </form>
    </div>
</body>
</html>