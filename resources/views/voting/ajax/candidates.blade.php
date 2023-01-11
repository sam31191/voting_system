<option selected value="">Select the candidate</option>
@foreach($candidates as $can)
    <option value="{{$can}}">{{$can}}</option>
@endforeach 