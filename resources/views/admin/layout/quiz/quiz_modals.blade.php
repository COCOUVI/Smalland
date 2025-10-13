{{-- Modal pour modifier le titre du quizz --}}
<div class="modal fade" id="editQuizzTitleModal" tabindex="-1" aria-labelledby="editQuizzTitleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editQuizzTitleModalLabel">Modifier le titre du quizz</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @if($module->quizz)
            <form id="editQuizzTitleForm" action="{{ route('quizz.updateTitle', $module->quizz->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="quizz_titre" class="form-label">Nouveau titre du quizz</label>
                        <input type="text" class="form-control" id="quizz_titre" name="titre" value="{{ $module->quizz->titre ?? '' }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Sauvegarder</button>
                </div>
            </form>
            @endif
        </div>
    </div>
</div>

{{-- Modal pour supprimer le quizz --}}
<div class="modal fade" id="deleteQuizzModal" tabindex="-1" aria-labelledby="deleteQuizzModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteQuizzModalLabel">Supprimer le quizz</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer ce quizz ? Cette action supprimera également toutes les questions associées et est irréversible.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                @if($module->quizz)
                <form id="deleteQuizzForm" action="{{ route('quizz.destroy', $module->quizz->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer définitivement</button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Modal de confirmation de suppression de question --}}
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmModalLabel">Confirmation de suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer cette question ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancel-delete-btn" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger" id="confirm-delete-btn">Supprimer</button>
            </div>
        </div>
    </div>
</div>
