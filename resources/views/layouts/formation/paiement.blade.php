@extends('master')

@section('content')
<h2>Paiement de la formation {{ $formation->titre }}</h2>


<kkiapay-widget 
    amount="{{ $paiement->montant_payé }}"
    key="{{ $publicKey }}"
    callback="{{ $callbackUrl }}"
    data='{"paiement_id": {{ $paiement->id }} }'
    sandbox="true">
</kkiapay-widget>


<script src="https://cdn.kkiapay.me/k.js"></script>

<script>
    // Écouter la réussite ou l'échec
    addSuccessListener(response => {
        console.log("Paiement réussi:", response);
    });

    addFailedListener(error => {
        console.error("Paiement échoué:", error);
    });
</script>
@endsection
