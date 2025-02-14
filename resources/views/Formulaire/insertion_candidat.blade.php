@extends('layoutsAdmin.app')
@section('contents')

<div class="row">
  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Nouveau Candidats</h4>
    <form action="{{ route('candidat.insert') }}" method="POST">
          <br>
        @csrf
          <div class="row">
            <div class="col-md-12">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Nom du Candidat</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="nom" />
                </div>
                <label style="margin-left: 45%">
                  @error('nom')
                      <span style="color: red">{{ $message }}</span>
                  @enderror
                </label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Specialisation</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="specialisation"/>
                </div>
              </div>                  
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 ">Postule pour poste</label>
                    <div class="col-sm-9">
                    <select class="custom-select" name="poste_postule">
                      @foreach ($poste as $postes)
                        <option value={{ $postes->id }} >{{ $postes->nom }}</option>
                      @endforeach
                    </select>
                    </div>
                </div>                          
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Postulé le</label>
                <div class="col-sm-9">
                  <input type="date" class="form-control" placeholder="dd/mm/yyyy" name="date_postule"/>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Mail</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="email"/>
                </div>
                <label style="margin-left: 50%">
                  @error('email')
                      <span style="color: red">{{ $message }}</span>
                  @enderror
                </label>                  
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Telephone</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="telephone"/>
                </div>
                <label style="margin-left: 50%">
                  @error('telephone')
                      <span style="color: red">{{ $message }}</span>
                  @enderror
                </label>
              </div>
            </div>
          </div>
          <br>
          {{-- <p class="card-description"> Address </p> --}}
          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Adresse</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="adresse" />
                </div>
                <label style="margin-left: 50%">
                  @error('adresse')
                      <span style="color: red">{{ $message }}</span>
                  @enderror
                </label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Genre</label>
                <div class="col-sm-9">
                  <select class="custom-select" name="genre">
                    <option>Homme</option>
                    <option>Femme</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Nationalité</label>
                  <div class="col-sm-9">
                      <select class="custom-select" name="nationalite">
                      <option>Malagasy</option>
                      <option>Francais</option>
                      <option>Congolais</option>
                      </select>
                  </div>
                </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Date de naissance</label>
                <div class="col-sm-9">
                  <input type="date" class="form-control" placeholder="dd/mm/yyyy" name="date_naissance" />
                </div>
                <label style="margin-left: 50%">
                  @error('date_naissance')
                      <span style="color: red">{{ $message }}</span>
                  @enderror
                </label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group row">
                  <label class="col-sm-12 col-form-label">Diplome et formation</label>
                  <div class="col-sm-12">
                    <textarea class="form-control" aria-label="With textarea" name="formation_diplome"></textarea>
                  </div>
                  <label style="margin-left: 2%">
                    @error('formation_diplome')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                  </label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group row">
                  <label class="col-sm-12 col-form-label">Experience pro</label>
                  <div class="col-sm-12">
                    <textarea class="form-control" aria-label="With textarea" name="experience_pro"></textarea>
                  </div>
                  <label style="margin-left: 2%">
                    @error('experience_pro')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                  </label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group row">
                  <label class="col-sm-12 col-form-label">Competence</label>
                  <div class="col-sm-12">
                    <textarea class="form-control" aria-label="With textarea" name="competence"></textarea>
                  </div>
                  <label style="margin-left: 2%">
                    @error('competence')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                  </label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group row">
                  <label class="col-sm-12 col-form-label">Qualite</label>
                  <div class="col-sm-12">
                    <textarea class="form-control" aria-label="With textarea" name="qualite"></textarea>
                  </div>
                  <label style="margin-left: 2%">
                    @error('qualite')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                  </label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                  <label class="col-sm-12 col-form-label">Centre d'interet</label>
                  <div class="col-sm-6">
                    <textarea class="form-control" aria-label="With textarea" name="centre_interet"></textarea>
                  </div>
              </div>
            </div>
  
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-12 col-form-label">Langues</label>
                {{-- <label class="col-sm-3 col-form-label">Langues</label> --}}
                @foreach ($liste as $langue)
                  <div class="col-sm-4">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" name="langue[]"  value="{{ $langue->id }}" > {{ $langue->name }} </label>
                    </div>
                  </div> 
                  @endforeach
                </div>
                <label style="margin-left: 25%">
                  @error('langue')
                      <span style="color: red">{{ $message }}</span>
                  @enderror
                </label>
            </div>
          </div>
      </div>
    </div>
    <button type="submit" class="btn btn-outline-secondary btn-lg btn-block">Valider </button>
  </form>
  </div>
</div>
@endsection