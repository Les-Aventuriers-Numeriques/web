@extends('layout')

@section('content')
    <section>
        <p>Nous sommes un regroupement de joueurs partageant la même passion dont les origines remontent à l'âge d'or de <i>Project Reality</i>, le mod <i>Battlefield 2</i> le plus notoire.</p>
        <p>À l'époque, les membres historiques de ce groupe pouvaient se compter sur les doigts d'une main, mais de nombreuses péripéties au fil des années nous ont permises de rencontrer des joueurs partageant nos valeurs, qui ont décidé de jouer régulièrement à nos côtés, tout en nous permettant de nous diversifier et d'évoluer.</p>
        <p>La team <i>{{ $teamName }}</i> est donc née le {{ $founded->isoFormat('LL') }} dans l'esprit convivial qui nous décrit.</p>
        <p>Et sinon, nous organisons depuis 2023 une <a href="{{ site_route('lan') }}">LAN party annuelle</a> privée.</p>
    </section>
@endsection
