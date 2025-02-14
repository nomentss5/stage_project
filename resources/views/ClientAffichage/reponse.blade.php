@extends('layoutsClient.app')
@section('contents')
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                    <h5 class="card-title" style="text-align: center">Votre fiche de reponse</h5>        
                    <br>
                    <div class="row">
                        @for($i = 0; $i < count($result); $i++) 
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <h5 class="col-sm-5">{{ $result[$i][0]['question'] }}</h5>
                                    {{-- <input type="hidden" name="question[{{ $i }}]" value={{ $result[$i][0]['id_question'] }}>
                                    <input type="hidden" name="id_user" value={{ $result[$i][0]['id_user'] }}>
                                    <input type="hidden" name="id_poste" value={{ $result[$i][0]['id_poste'] }}> --}}
                                    @for ($j = 0; $j < count($result[$i]); $j++)
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="{{ $result[$i][$j]['reponse'] }}" readonly>
                                            {{-- @if($result[$i][$j]['note'] != null)
                                                <input type="number" style="text-align: center" min="0" max="5" class="form-control" value="{{ $result[$i][$j]['note']}}" name="note[{{$i}}][{{$j}}]" readonly>
                                            @else
                                                <input type="number" style="text-align: center" min="0" max="5" class="form-control" value="{{ $result[$i][$j]['note']}}" name="note[{{$i}}][{{$j}}]">
                                            @endif --}}
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        @endfor
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection