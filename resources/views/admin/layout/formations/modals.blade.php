<!-- Modal Ajouter Formation -->
<div class="modal fade" id="addFormationModal" tabindex="-1" aria-labelledby="addFormationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFormationModalLabel">Ajouter une formation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addFormationForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div id="addFormationAlert"></div>

                    <div class="mb-3">
                        <label for="addTitle" class="form-label">Titre</label>
                        <input type="text" class="form-control" id="addTitle" name="title" required>
                        <span class="text-danger" id="addTitleError"></span>
                    </div>

                    <div class="mb-3">
                        <label for="addDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="addDescription" name="description" rows="5" required></textarea>
                        <span class="text-danger" id="addDescriptionError"></span>
                    </div>

                    <div class="mb-3">
                        <label for="addPrice" class="form-label">Prix</label>
                        <input type="number" min="0" class="form-control" id="addPrice" name="price" required>
                        <span class="text-danger" id="addPriceError"></span>
                    </div>

                    <div class="mb-3">
                        <label for="addImage" class="form-label">Image</label>
                        <input type="file" class="form-control" id="addImage" name="image" accept="image/*">
                        <span class="text-danger" id="addImageError"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Créer la formation</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Modifier Formation -->
<div class="modal fade" id="editFormationModal" tabindex="-1" aria-labelledby="editFormationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editFormationModalLabel">Modifier la formation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editFormationForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="editFormationId" name="formation_id">
                <div class="modal-body">
                    <div id="editFormationAlert"></div>

                    <div class="mb-3">
                        <label for="editTitre" class="form-label">Titre</label>
                        <input type="text" class="form-control" id="editTitre" name="titre" required>
                        <span class="text-danger" id="editTitreError"></span>
                    </div>

                    <div class="mb-3">
                        <label for="editDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="editDescription" name="description" rows="5" required></textarea>
                        <span class="text-danger" id="editDescriptionError"></span>
                    </div>

                    <div class="mb-3">
                        <label for="editPrice" class="form-label">Prix (FCFA)</label>
                        <input type="number" step="0.01" class="form-control" id="editPrice" name="price" required>
                        <span class="text-danger" id="editPriceError"></span>
                    </div>

                    <div class="mb-3">
                        <label for="editImage" class="form-label">Image (laisser vide si inchangée)</label>
                        <input type="file" class="form-control" id="editImage" name="image" accept="image/*">
                        <span class="text-danger" id="editImageError"></span>
                        <div id="currentImagePreview" class="mt-2"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Supprimer Formation -->
<div class="modal fade" id="deleteFormationModal" tabindex="-1" aria-labelledby="deleteFormationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteFormationModalLabel">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer la formation <strong id="deleteFormationTitle"></strong> ?</p>
                <p class="text-danger"><small>Cette action est irréversible.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Supprimer</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ajouter Module -->
<div class="modal fade" id="addModuleModal" tabindex="-1" aria-labelledby="addModuleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModuleModalLabel">Ajouter un module</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addModuleForm" action="" method="POST">
                @csrf
                <div class="modal-body">
                    <div id="ajaxAlert"></div>
                    <div class="mb-3">
                        <label for="moduleTitle" class="form-label">Titre du module</label>
                        <input type="text" class="form-control" id="moduleTitle" name="titre" required>
                        <span class="text-danger" id="titreError"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
</div>
