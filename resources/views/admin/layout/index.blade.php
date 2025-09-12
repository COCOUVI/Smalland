@extends('admin.master')
@section('content')
    <div class="row">
        @foreach ($cards as $card)
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-4">
                <div class="card h-100">
                    <div class="card-statistic-4 d-flex align-items-center" style="min-height:130px;">
                        <div class="row w-100 align-items-center">
                            <!-- Texte -->
                            <div class="col-6 pr-0 pt-3">
                                <div class="card-content">
                                    <h5 class="font-15">{{ $card['title'] }}</h5>
                                    <h2 class="mb-3 font-18">{{ $card['value'] }}</h2>
                                    <p class="mb-0"><span
                                            class="{{ $card['percentColor'] }}">{{ $card['percent'] }}</span> depuis le mois
                                        dernier</p>
                                </div>
                            </div>
                            <!-- Image -->
                            <div class="col-6 pl-0 d-flex justify-content-center align-items-center">
                                <div class="banner-img">
                                    <img src="{{ asset($card['img']) }}" alt="{{ $card['title'] }}" class="img-fluid"
                                        style="max-height:70px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


    <!-- Graphiques -->
    <div class="row">
        <!-- Ventes -->
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header">
                    <h4>Statistiques des ventes</h4>
                </div>
                <div class="card-body">
                    <canvas id="chartVentes" height="120"></canvas>
                </div>
            </div>
        </div>

        <!-- Répartition -->
        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header">
                    <h4>Répartition Produits / Formations</h4>
                </div>
                <div class="card-body">
                    <canvas id="chartRepartition" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Derniers Paiements -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h4>Derniers Paiements</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Utilisateur</th>
                                    <th>Date</th>
                                    <th>Méthode</th>
                                    <th>Montant</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Jean Dupont</td>
                                    <td>10/09/2025</td>
                                    <td>Moov Money</td>
                                    <td>25 000 CFA</td>
                                    <td><span class="badge badge-success">Réussi</span></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Sarah Johnson</td>
                                    <td>08/09/2025</td>
                                    <td>PayPal</td>
                                    <td>18 500 CFA</td>
                                    <td><span class="badge badge-warning">En attente</span></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Aliou Sow</td>
                                    <td>05/09/2025</td>
                                    <td>Carte Bancaire</td>
                                    <td>50 000 CFA</td>
                                    <td><span class="badge badge-success">Réussi</span></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Aminata Traoré</td>
                                    <td>03/09/2025</td>
                                    <td>Cash</td>
                                    <td>12 000 CFA</td>
                                    <td><span class="badge badge-danger">Échoué</span></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>David Martin</td>
                                    <td>01/09/2025</td>
                                    <td>MTN Mobile Money</td>
                                    <td>30 000 CFA</td>
                                    <td><span class="badge badge-success">Réussi</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Graphique des ventes (ligne)
        const ctxVentes = document.getElementById('chartVentes').getContext('2d');
        new Chart(ctxVentes, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil'],
                datasets: [{
                    label: 'Ventes',
                    data: [120, 190, 300, 250, 200, 320, 400],
                    borderColor: '#4e73df',
                    backgroundColor: 'rgba(78, 115, 223, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                }
            }
        });

        // Graphique de répartition (camembert)
        const ctxRepartition = document.getElementById('chartRepartition').getContext('2d');
        new Chart(ctxRepartition, {
            type: 'doughnut',
            data: {
                labels: ['Produits', 'Formations'],
                datasets: [{
                    data: [120, 45],
                    backgroundColor: ['#36b9cc', '#1cc88a']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
@endpush
