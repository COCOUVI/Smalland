@extends('layouts.App')

@section('content')
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $quizz->titre }}</h1>
                <p class="text-gray-600 mb-6">Répondez aux questions suivantes pour tester vos connaissances.</p>

                @if (session('success'))
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-green-800">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border border-red-300 text-red-800 rounded-lg p-4 mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($canResubmit)
                    <form method="POST" action="{{ route('quizz.submit', $quizz->id) }}">
                        @csrf

                        <div class="space-y-8">
                            @foreach ($quizz->questions as $index => $question)
                                <div class="border border-gray-200 rounded-lg p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                        Question {{ $index + 1 }}: {{ $question->content }}
                                    </h3>

                                    <div class="space-y-3">
                                        @foreach ($question->reponses as $reponse)
                                            <label
                                                class="flex items-center space-x-3 p-3 rounded-lg border border-gray-200 hover:border-very-green cursor-pointer transition-colors">
                                                <input type="radio" name="question_{{ $question->id }}"
                                                    value="{{ $reponse->id }}"
                                                    class="text-very-green focus:ring-very-green" required>
                                                <span class="text-gray-700">{{ $reponse->content }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-8 flex justify-end">
                            <button type="submit"
                                class="bg-very-green text-white px-8 py-3 rounded-lg hover:bg-green-600 transition-colors font-semibold">
                                Soumettre le quiz
                            </button>
                        </div>
                    </form>
                @else
                    <br><br><br>
                    <div class="bg-yellow-100 border border-yellow-300 text-yellow-800 rounded-lg p-4 mb-4">
                        Vous avez déjà répondu à ce quiz. Vous pourrez le refaire après 24 heures.
                    </div>
                    <br><br><br><br><br>
                @endif
            </div>
        </div>
    </div>
@endsection
