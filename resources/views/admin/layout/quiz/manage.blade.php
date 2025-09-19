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
        </div>
    </div>
    @endif
</div>

@endsection

@section('scripts')
<script>
let reponseCount = 2; // déjà deux réponses par défaut
document.getElementById('add-reponse').addEventListener('click', function() {
    const container = document.getElementById('reponses-container');
    const div = document.createElement('div');
    div.classList.add('mb-2');
    div.innerHTML = `
        <input type="text" name="reponses[]" class="form-control d-inline-block w-75" placeholder="Réponse ${reponseCount + 1}" required>
        <input type="radio" name="is_correct" value="${reponseCount}" required> Correct
    `;
    container.appendChild(div);
    reponseCount++;
});
</script>
@endsection
