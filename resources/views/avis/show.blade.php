<!-- Modal Ajouter un avis -->
<div id="addAvisModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md mx-auto">
        <h2 class="text-xl font-bold mb-4">Donner votre avis</h2>

        <form method="POST" action="{{ route('avis.store', $formation->id) }}">
            @csrf

            <div class="mb-4">
                <label for="note" class="block text-sm font-medium text-gray-700">Note (1 à 5)</label>
                <select name="note" id="note" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="1">1 - Très mauvais</option>
                    <option value="2">2 - Mauvais</option>
                    <option value="3">3 - Moyen</option>
                    <option value="4">4 - Bon</option>
                    <option value="5">5 - Excellent</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="content_avis" class="block text-sm font-medium text-gray-700">Votre avis</label>
                <textarea name="content_avis" id="content_avis" rows="4" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-very-green text-white px-4 py-2 rounded hover:bg-green-600">Envoyer</button>
            </div>
        </form>
    </div>
</div>
