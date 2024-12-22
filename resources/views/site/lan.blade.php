@extends('layout')

@section('content')
    @if($announced)
        <p>Comme chaque année depuis 2023, nous organisons une LAN party privée dont voici les informations à propos de l'édition de {{ $startDate->year }}. <strong>Il n'est possible de la joindre que sur notre invitation expresse</strong>.</p>

        <section class="row row-cols-1 row-cols-md-2 g-4 mb-3">
            <div class="col">
                <article class="card">
                    <header class="card-header h5">Quand ?</header>

                    <div class="card-body">
                        <p class="card-text">Du {{ $startDate->month == $endDate->month ? $startDate->day : $startDate->isoFormat('d MMMM') }} au {{ $endDate->isoFormat('LL') }}.</p>
                        <p class="card-text">Aucune obligation de présence évidemment : vous venez et repartez quand vous voulez.</p>
                    </div>
                </article>
            </div>
            <div class="col">
                <article class="card">
                    <header class="card-header h5">Où ?</header>
                    <div class="card-body">
                        @if($locationName && $locationUrl)
                            <p class="card-text">Ça se passera à <a href="{{ $locationUrl }}">{{ $locationName }}</a>.</p>
                        @else
                            <p class="card-text">À définir.</p>
                        @endif
                    </div>
                </article>
            </div>
            <div class="col">
                <article class="card">
                    <header class="card-header h5">Qui ?</header>
                    <div class="card-body">
                        <p class="card-text">Il est actuellement prévu {{ $currentAttendees }} joueurs sur un maximum de {{ $maxAttendees }}.</p>
                    </div>
                </article>
            </div>
            <div class="col">
                <article class="card">
                    <header class="card-header h5">Combien ?</header>
                    <div class="card-body">
                        <p class="card-text">Les frais sont répartis équitablement entre tous les participants. Les joueurs venant de loin participent moins aux frais afin de compenser leurs frais de déplacement.</p>
                        <p class="card-text">Deux acomptes (englobant les frais de logement par personne) sont demandés : le premier afin de valider l'inscription, et le second 2 mois avant le début de la LAN.</p>
                    </div>
                </article>
            </div>
        </section>
    @else
        <p>Les informations de l'édition {{ $startDate->toImmutable()->addYear()->year }} de notre LAN party privée seront disponibles plus tard. En attendant, vous trouverez ci-dessous quelques informations sur nos précédentes éditions.</p>
    @endif
@endsection
