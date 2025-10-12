@extends('master')

@section('content')
    <h2>Paiement de la formation {{ $formation->titre }}</h2>


    <kkiapay-widget amount="{{ $paiement->montant_payé }}" key="{{ $publicKey }}" 
        callback="{{route('paiement.callback')}}"
        data='{"paiement_id": {{ $paiement->id }} }' sandbox="true">
    </kkiapay-widget>


    <script src="https://cdn.kkiapay.me/k.js"></script>


    <script>
        addSuccessListener(response => {
            console.log(response);
        });

        addFailedListener(error => {
            console.log(error);
        });
    </script>
