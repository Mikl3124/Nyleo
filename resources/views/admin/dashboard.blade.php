@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class=text-center>DASHBOARD</h1>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#CreateUserModal">
      Créer un client
    </button>
    <form action="{{ route('test.mail') }}" method="POST">
      @csrf
      <button type="submit" class="btn btn-success mt-3">Test Mail</button>
    </form>
    {{-- --------- TABLE SECTION ---------- --}}
    <table class="table table-hover">

        <thead>
          <tr>
            <th scope="col">Email</th>
            <th scope="col">Nom</th>
            <th scope="col">Prénom</th>
            <th scope="col">Ville</th>
            <th scope="col">Etape</th>
            <th scope="col"></th>
          </tr>
        </thead>


      <tbody>
        @foreach($users as $user)

            <tr>
                <td>{{ $user->email }}</td>
                <td>{{ $user->firstname }}</td>
                <td>{{ $user->lastname }}</td>
                <td>{{ $user->town }}</td>
                <td>{{ $user->step }}</td>
                <td><a href="" class="btn btn-primary">Accéder</a></td>
            </tr>

        @endforeach
      </tbody>
    </table>
</div>


@endsection

<!-- Modal Création Client-->
<div class="modal fade" id="CreateUserModal" tabindex="-1" role="dialog" aria-labelledby="CreateUserModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="CreateUserModalLabel">Créer un utilisateur</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('client.store') }}">
            @csrf
            <div class="form-group">
                <input placeholder="Adresse e-mail" id="email" type="email" class="form-control" name="email" required autocomplete="email">
            </div>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-success">Créer</button>
        </form>
      </div>
    </div>
  </div>
</div>
