@extends('Master')

@section('content')
<style>
    .alert-success {
        background-color: #e6f9ec;
        border: 1.5px solid #2ecc71;
        color: #27ae60;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        margin-bottom: 1.8rem;
        font-weight: 600;
    }

    .alert-fail {
        background-color: #ffe6e6;
        border: 1.5px solid #e74c3c;
        color: #c0392b;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        margin-bottom: 1.8rem;
        font-weight: 600;
    }

    .alert-error, .alert-danger {
        background-color: #ffe6e6;
        border: 1.5px solid #e74c3c;
        color: #c0392b;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        margin-bottom: 1.8rem;
        font-weight: 600;
        text-align: center;
    }

    .alert-info {
        background-color: #fff8dc;
        border: 1.5px solid #f1c40f;
        color: #b7950b;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        text-align: center;
        font-weight: 600;
        margin-top: 2rem;
    }

    .quiz-container {
        max-width: 700px;
        margin: 2rem auto;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        padding: 2.5rem 3rem;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #333;
    }

    .quiz-container h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: #2c3e50;
        text-align: center;
    }

    .quiz-container p.description {
        font-size: 1.1rem;
        color: #666;
        margin-bottom: 2rem;
        text-align: center;
    }

    .question-block {
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 1.8rem 2rem;
        margin-bottom: 1.8rem;
        background-color: #fafafa;
    }

    .question-block h3 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: #34495e;
    }

    .answer-label {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.8rem 1.2rem;
        border-radius: 8px;
        border: 1.5px solid #ccc;
        margin-bottom: 0.7rem;
        cursor: pointer;
        background-color: white;
        transition: all 0.3s ease;
        font-size: 1rem;
        color: #2c3e50;
    }

    .answer-label:hover {
        border-color: #2ecc71;
        background-color: #e6f9ec;
        color: #27ae60;
    }

    .answer-label input[type="checkbox"] {
        accent-color: #2ecc71;
        cursor: pointer;
        width: 18px;
        height: 18px;
    }

    .btn-submit {
        display: block;
        width: 100%;
        padding: 1.2rem 0;
        background-color: #27ae60;
        color: white;
        font-size: 1.2rem;
        font-weight: 700;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-top: 1.5rem;
    }

    .btn-submit:hover {
        background-color: #219150;
    }

    @media (max-width: 640px) {
        .quiz-container {
            padding: 2rem 1.5rem;
            margin: 1rem;
        }

        .btn-submit {
            font-size: 1rem;
            padding: 1rem 0;
        }
    }
</style>

<div class="quiz-container">
    <h1>{{ $quizz->titre }}</h1>
    <p class="description">Répondez aux questions suivantes pour tester vos connaissances.</p>

    {{-- Alertes --}}
    @if (session('success') && session('score') !== null)
        @if (session('score') >= 70)
            <div class="alert-success">
                ✅ {{ session('success') }}
            </div>
        @else
            <div class="alert-fail">
                ❌ {{ session('success') }}
            </div>
        @endif
    @endif

    @if (session('error'))
        <div class="alert-error">
            {{ session('error') }}
        </div>
    @endif

    {{-- Si l’utilisateur peut refaire le quiz --}}
    @if ($canResubmit)
        <form method="POST" action="{{ route('quizz.submit', $quizz->id) }}">
            @csrf

            @foreach ($quizz->questions as $index => $question)
                <div class="question-block">
                    <h3>Question {{ $index + 1 }} : {{ $question->content }}</h3>

                    @foreach ($question->reponses as $reponse)
                        <label class="answer-label" for="answer_{{ $reponse->id }}">
                            <input type="checkbox"
                                id="answer_{{ $reponse->id }}"
                                name="question_{{ $question->id }}[]"
                                value="{{ $reponse->id }}">
                            <span>{{ $reponse->content }}</span>
                        </label>
                    @endforeach
                </div>
            @endforeach

            <button type="submit" class="btn-submit">Soumettre le quiz</button>
        </form>
    @elseif($canViewAnswers && $userQuizz)
        {{-- Affichage des réponses précédentes --}}
        <div class="alert-info">
            ✅ Vous avez déjà réussi ce quiz avec 100%. Voici vos réponses :
        </div>

        @php
            $savedAnswers = json_decode($userQuizz->reponses ?? '{}', true);
        @endphp

        @foreach ($quizz->questions as $index => $question)
            <div class="question-block">
                <h3>Question {{ $index + 1 }} : {{ $question->content }}</h3>

                @foreach ($question->reponses as $reponse)
                    @php
                        $userSelected = isset($savedAnswers[$question->id]) && in_array($reponse->id, $savedAnswers[$question->id]);
                        $isCorrect = $reponse->is_correct;
                    @endphp
                    <div class="answer-label" style="
                        border-color: {{ $isCorrect ? '#2ecc71' : ($userSelected ? '#e74c3c' : '#ccc') }};
                        background-color: {{ $isCorrect ? '#e6f9ec' : ($userSelected ? '#ffe6e6' : '#fff') }};
                        color: {{ $isCorrect ? '#27ae60' : ($userSelected ? '#c0392b' : '#2c3e50') }};
                    ">
                        <input type="checkbox" disabled {{ $userSelected ? 'checked' : '' }}>
                        <span>{{ $reponse->content }}</span>
                        @if($isCorrect)
                            <strong> (✔ Réponse correcte)</strong>
                        @endif
                    </div>
                @endforeach
            </div>
        @endforeach

    @else
        <div class="alert-info">
            Vous avez déjà répondu à ce quiz. Vous pourrez le refaire après 24 heures car votre score est inférieur à 100%.
        </div>
    @endif
</div>
@endsection