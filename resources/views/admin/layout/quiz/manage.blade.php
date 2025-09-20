@extends('admin.master')

@section('content')
<div class="container mt-4">

    <h2>Quizz du module : {{ $module->titre }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Création du quizz si inexistant --}}
    @if(!$module->quizz)
    <div class="card mb-4">
        <div class="card-header">Créer le quizz</div>
        <div class="card-body">
            <form method="POST" action="{{ route('quizz.storeOrUpdate', $module->id) }}">
                @csrf
                <div class="mb-3">
                    <label>Titre du quizz</label>
                    <input type="text" name="titre" class="form-control" value="Quizz du module {{ $module->titre }}">
                </div>
                <button type="submit" class="btn btn-primary">Créer le quizz</button>
            </form>
        </div>
    </div>
    @endif

    {{-- Ajouter une question --}}
    @if($module->quizz)
    <div class="card mb-4">
        <div class="card-header">Ajouter une question</div>
        <div class="card-body">
            <form method="POST" action="{{ route('quizz.storeOrUpdate', $module->id) }}">
                @csrf
                <div class="mb-3">
                    <label>Question</label>
                    <input type="text" name="question" class="form-control" required>
                </div>

                <div id="reponses-container">
                    <div class="mb-2">
                        <input type="text" name="reponses[]" class="form-control d-inline-block w-75" placeholder="Réponse 1" required>
                        <input type="radio" name="is_correct" value="0" required> Correct
                    </div>
                    <div class="mb-2">
                        <input type="text" name="reponses[]" class="form-control d-inline-block w-75" placeholder="Réponse 2" required>
                        <input type="radio" name="is_correct" value="1" required> Correct
                    </div>
                </div>

                <button type="button" id="add-reponse" class="btn btn-secondary mb-3">Ajouter une réponse</button>
                <br>
                <button type="submit" class="btn btn-success">Ajouter la question</button>
            </form>
        </div>
    </div>

    {{-- Liste des questions existantes --}}
    <div class="card">
        <div class="card-header">Questions existantes</div>
        <div class="card-body">
            @if($module->quizz && $module->quizz->questions->count() > 0)
                @foreach($module->quizz->questions as $qIndex => $question)
                    <div class="mb-3">
                        <strong>Q{{ $qIndex + 1 }}: {{ $question->content }}</strong>
                        <ul>
                            @foreach($question->reponses as $rIndex => $rep)
                                <li>
                                    {{ $rep->content }}
                                    @if($rep->is_correct)
                                        <span class="badge bg-success">Correct</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            @else
                <p class="text-muted">Aucune question ajoutée pour le moment.</p>
            @endif
        </div>
    </div>
    @endif
</div>

@endsection

<!-- ✅ SCRIPT INLINE POUR TEST -->
<script>
console.log('Script chargé !'); // Pour vérifier dans la console

// ✅ Attendre que le DOM soit chargé
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM chargé !'); // Pour vérifier dans la console

    let reponseCount = 2; // déjà deux réponses par défaut

    const addButton = document.getElementById('add-reponse');
    console.log('Bouton trouvé :', addButton); // Pour vérifier dans la console

    if (addButton) { // ✅ Vérifier que l'élément existe
        console.log('Event listener ajouté !'); // Pour vérifier dans la console

        addButton.addEventListener('click', function() {
            console.log('Bouton cliqué !'); // Pour vérifier dans la console

            const container = document.getElementById('reponses-container');
            const div = document.createElement('div');
            div.classList.add('mb-2');
            div.innerHTML = `
                <input type="text" name="reponses[]" class="form-control d-inline-block w-75" placeholder="Réponse ${reponseCount + 1}" required>
                <input type="radio" name="is_correct" value="${reponseCount}" required> Correct
                <button type="button" class="btn btn-sm btn-danger ms-2 remove-reponse">×</button>
            `;
            container.appendChild(div);
            reponseCount++;
        });
    } else {
        console.error('Bouton add-reponse non trouvé !');
    }

    // ✅ Délégation d'événements pour les boutons de suppression
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-reponse')) {
            const parentDiv = e.target.closest('.mb-2');
            if (parentDiv) {
                parentDiv.remove();
                // Optionnel : réajuster les valeurs des radio buttons
                updateRadioValues();
            }
        }
    });

    // ✅ Fonction pour réajuster les valeurs des boutons radio
    function updateRadioValues() {
        const reponseInputs = document.querySelectorAll('#reponses-container .mb-2');
        reponseInputs.forEach((div, index) => {
            const radio = div.querySelector('input[type="radio"]');
            if (radio) {
                radio.value = index;
            }
        });
    }
});
</script>
