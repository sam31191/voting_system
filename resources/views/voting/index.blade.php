<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="{{route('details')}}">Voting Results</a>
    </nav>
    <div class="wrapper">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ $message }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <form method="post" id="votingForm" action="{{url('save-vote')}}">
            @csrf
            <select class="form-select" name="constituency" id="constituency" aria-label="Default select example">
                <option selected value="">Select the constituency</option>
                @foreach($constituency as $c)
                    <option value="{{$c}}">{{$c}}</option>
                @endforeach 
            </select>
            @if($errors->has('constituency'))
                <div class="error">{{ $errors->first('constituency') }}</div>
            @endif
            <select class="form-select" name="candidate" id="candidates" aria-label="Default select example">
                <option selected value="">Select the candidate</option>
            </select>
            @if($errors->has('candidate'))
                <div class="error">{{ $errors->first('candidate') }}</div>
            @endif
            <div class="text-center">
                <button type="submit" id="vote" class="btn btn-primary">Vote</button>
            </div>
        </form>
    </div>
    <footer>@copyright(2022-2023)</footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script>
        $("#constituency").on('change', function(){
            let constituency = $(this).val();
            if(constituency){
                $.ajax({
                    method: "GET",
                    url: "{{ route('candidates') }}",
                    data: { constituency: constituency}
                })
                .done(function( data ) {
                    $("#candidates").html(data);
                });  
            }else{
                alert("Please select a constituency");
            }
        });
    </script>
</body>
</html>