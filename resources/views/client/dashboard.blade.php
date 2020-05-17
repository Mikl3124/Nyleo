@extends('layouts.app')
@section('content')
    @include('layouts.steps')
        <div class="container">
            
            @if(Auth::user()->firstname)
                <h1 class="text-center mt-5">
                    Bienvenue {{Auth::user()->firstname}}
                </h1>
            @else
                <h1 class="text-center mt-5">
                    Bienvenue sur la plateforme Nyleo
                </h1>
            @endif
            @switch($step)
                @case(0)
                    <p>Prochaine étape: <a href="{{ route('client.edit', Auth::user()) }}">Remplir votre fiche client</a></p>
                @break

                @case(1)
                    <p><i class="fas fa-check"></i> Fiche client complétée</p>
                    <p><i class="fas fa-arrow-right"></i>  Prochaine étape: <a href="{{ route('projet.edit', Auth::user()) }}"> Remplir la fiche projet</a></p>
                @break

                @case(2)
                    <p>Prochaine étape: <a href="{{ route('client.edit', Auth::user()) }}">Remplir la fiche projet</a></p>
                @break

                @default
                    Default case...
            @endswitch
        </div>

@endsection


