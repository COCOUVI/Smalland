@extends('Master')

@section('content')
    <style>
        /* Success message vert */
        .alert-success {
            background-color: #e6f9ec;
            border: 1.5px solid #2ecc71;
            color: #27ae60;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.8rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
        }

        /* Message rouge (échec) */
        .alert-fail {
            background-color: #ffe6e6;
            border: 1.5px solid #e74c3c;
            color: #c0392b;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.8rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Message erreur */
        .alert-error {
            background-color: #ffe6e6;
            border: 1.5px solid #e74c3c;
            color: #c0392b;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.8rem;
            font-weight: 600;
            text-align: center;
        }

        /* Container principal */
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

        /* Titre principal */
        .quiz-container h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #2c3e50;
            text-align: center;
            letter-spacing: 1px;
        }

        /* Description */
        .quiz-container p.description {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 2rem;
            text-align: center;
        }

        /* Message success - vert */
        .alert-success {
            background-color: #e6f9ec;
            border: 1.5px solid #2ecc71;
            color: #27ae60;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.8rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
        }

        /* Message d’erreur - rouge */
        .alert-error,
        .alert-danger {
            background-color: #ffe6e6;
            border: 1.5px solid #e74c3c;
            color: #c0392b;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.8rem;
            font-weight: 600;
            text-align: center;
        }

        /* Bloc question */
        .question-block {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 1.8rem 2rem;
            margin-bottom: 1.8rem;
            background-color: #fafafa;
            transition: box-shadow 0.3s ease;
        }

        .question-block:hover {
            box-shadow: 0 0 12px rgba(46, 204, 113, 0.4);
            border-color: #2ecc71;
        }

        /* Texte de la question */
        .question-block h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #34495e;
        }

        /* Réponses */
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

        /* Hover sur réponse */
        .answer-label:hover {
            border-color: #2ecc71;
            background-color: #e6f9ec;
            color: #27ae60;
        }

        /* Input radio */
        .answer-label input[type="radio"] {
            accent-color: #2ecc71;
            cursor: pointer;
            width: 18px;
            height: 18px;
        }

        /* Focus accessible */
        .answer-label input[type="radio"]:focus+span {
            outline: 2px solid #27ae60;
            outline-offset: 2px;
            border-radius: 4px;
        }

        /* Bouton soumettre */
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
            letter-spacing: 0.05em;
            margin-top: 1.5rem;
        }

        .btn-submit:hover {
            background-color: #219150;
        }

        /* Message d’info (ex : quiz déjà fait) */
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

        a {
            text-decoration: none;
        }

        /* Responsive */
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

        {{-- Message succès/échec après soumission --}}
        @if (session('success') && session('score') !== null)
            @if (session('score') >= 70)
                <div class="alert-success" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon-success" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" width="24" height="24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @else
                <div class="alert-fail" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon-fail" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" width="24" height="24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
        @endif

        @if (session('error'))
            <div class="alert-error" role="alert">
                {{ session('error') }}
            </div>
        @endif
        {{-- ✅ Vérifie si l'utilisateur a déjà validé le quiz --}}
        @if ($userQuizz && $userQuizz->score >= 70)
            <div class="alert-success" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon-success" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" width="24" height="24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>
                    Félicitations 🎉 Vous avez déjà validé ce quiz avec un score de
                    <strong>{{$userQuizz->score }}%</strong>.
                </span>
            </div>
        @elseif ($canResubmit)
            <form method="POST" action="{{ route('quizz.submit', $quizz->id) }}">
                @csrf

                @foreach ($quizz->questions as $index => $question)
                    <div class="question-block">
                        <h3>Question {{ $index + 1 }}: {{ $question->content }}</h3>

                        @foreach ($question->reponses as $reponse)
                            <label class="answer-label" for="answer_{{ $reponse->id }}">
                                <input type="radio" id="answer_{{ $reponse->id }}" name="question_{{ $question->id }}"
                                    value="{{ $reponse->id }}" required>
                                <span>{{ $reponse->content }}</span>
                            </label>
                        @endforeach
                    </div>
                @endforeach

                <button type="submit" class="btn-submit">Soumettre le quiz</button>
            </form>
        @else
            <div class="alert-info" role="alert">
                Vous avez déjà répondu à ce quiz. Vous pourrez le refaire après 24 heures si votre score est inférieur à
                100%.
            </div>
            <br><br><br><br><br><br>
        @endif

    </div>
@endsection
