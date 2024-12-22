@extends('layout')

@section('content')
    @if($announced)
        <p>Comme chaque année depuis 2023, nous organisons une LAN party privée dont voici les informations à propos de l'édition de {{ $startDate->year }}. <strong>Il n'est possible de la joindre que sur notre invitation expresse</strong>.</p>

        <section>
            <article>
                <header>Quand ?</header>
                <p>Du {{ $startDate->month == $endDate->month ? $startDate->day : $startDate->isoFormat('d MMMM') }} au {{ $endDate->isoFormat('LL') }}.</p>
                <p>Aucune obligation de présence évidemment : vous venez et repartez quand vous voulez.</p>
            </article>
            <article>
                <header>Où ?</header>

                @if($locationName && $locationUrl)
                    <p>Ça se passera à <a href="{{ $locationUrl }}">{{ $locationName }}</a>.</p>
                @else
                    <p>À définir.</p>
                @endif
           </article>
            <article>
                <header>Qui ?</header>
                <p>Il est actuellement prévu {{ $currentAttendees }} joueurs sur un maximum de {{ $maxAttendees }}.</p>
            </article>
            <article>
                <header>Combien ?</header>
                <p>Les frais sont répartis équitablement entre tous les participants. Les joueurs venant de loin participent moins aux frais afin de compenser leurs frais de déplacement.</p>
                <p>Deux acomptes (englobant les frais de logement par personne) sont demandés : le premier afin de valider l'inscription, et le second 2 mois avant le début de la LAN.</p>
            </article>
        </section>
    @else
        <p>Les informations de l'édition {{ $startDate->toImmutable()->addYear()->year }} de notre LAN party privée seront disponibles plus tard. En attendant, vous trouverez ci-dessous quelques informations sur nos précédentes éditions.</p>
    @endif
@endsection
