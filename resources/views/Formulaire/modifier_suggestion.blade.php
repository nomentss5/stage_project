@extends('layoutsAdmin.app')
@section('contents')
<div class="row">
{{-- exemple de card avec collapse --}}
<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
          <h4 class="card-title" style="text-align: center">Modifier suggestion</h4>
          <form action="{{ route('suggestion.update')}}" method="GET">
          <br>
            <input type="hidden" name="id" value={{ $suggestion_message->id}} >
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Nom suggestion</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="nom_suggestion" value="{{ $suggestion_message->nom }}" >
                  </div>
                </div>                  
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-12">
                <div class="form-group row">
                    <label class="col-sm-12 col-form-label">Message</label>
                    <div class="col-sm-12">
                      <textarea class="form-control" aria-label="With textarea" name="message">{{ $suggestion_message->message }}</textarea>
                    </div>
                    <label style="margin-left: 2%">
                      @error('message')
                          <span style="color: red">{{ $message }}</span>
                      @enderror
                    </label>
                </div>
              </div>
            </div>

            <button type="submit" class="btn btn-outline-primary btn-lg " onclick="return validation();">Modifier</button>
              
        </div>
      </div>
      </form>
</div>

<script>
    function validation() {
        return confirm('Êtes-vous sûr de vouloir modifier?');
    }
</script>

@endsection