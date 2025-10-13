@extends('space-etudiant.master')

@section('main-content')
<div class="card mb-4">
    <div class="card-body">
        <div id="certificat-section">
            @include('space-etudiant.layout.certificat-section', ['certificats' => $certificats])
        </div>
    </div>
</div>
@endsection
