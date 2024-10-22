<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
        
    <form action="{{ route('email.send')}}" method="GET">
        <label>
            Email envoyeur
            <input type="text" name="sender" >
            @error('sender')
                <span style="color: red">{{ $message }}</span>
            @enderror
        </label>

        <label>
            Email recepteur
            <input type="text" name="receiver" >
            @error('receiver')
                <span style="color: red">{{ $message }}</span>
            @enderror
        </label>

        <label>
            Message
            <input type="text" name="message" >
            @error('message')
                <span style="color: red">{{ $message }}</span>
            @enderror
        </label>

        <input type="submit" value="Envoyer">
    </form>
</body>
</html>