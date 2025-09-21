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

                    <!-- Nouveau champ Niveau -->
                    <div class="mb-3">
                        <label for="addLevel" class="form-label">Niveau</label>
                        <select class="form-select" id="addLevel" name="level" required>
                            <option value="" disabled selected>-- Sélectionnez un niveau --</option>
                            <option value="debutant">Débutant</option>
                            <option value="intermediaire">Intermédiaire</option>
                            <option value="expert">Expert</option>
                        </select>
                        <span class="text-danger" id="addLevelError"></span>
                    </div>

                    <!-- Nouveau champ Objectifs -->
                    <div class="mb-3">
                        <label for="addObjective" class="form-label">Objectifs de la formation</label>
                        <textarea class="form-control" id="addObjective" name="objective" rows="4"
                            placeholder="Décrivez les objectifs principaux de la formation" required></textarea>
                        <span class="text-danger" id="addObjectiveError"></span>
                    </div>

                    <div class="mb-3">
                        <label for="addPrice" class="form-label">Prix</label>
                        <input type="number" min="0" class="form-control" id="addPrice" name="price"
                            required>
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
<div class="modal fade" id="editFormationModal" tabindex="-1" aria-labelledby="editFormationModalLabel"
    aria-hidden="true">
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

                    <!-- Nouveau champ Niveau -->
                    <div class="mb-3">
                        <label for="editLevel" class="form-label">Niveau</label>
                        <select class="form-select" id="editLevel" name="level" required>
                            <option value="" disabled>-- Sélectionnez un niveau --</option>
                            <option value="debutant">Débutant</option>
                            <option value="intermediaire">Intermédiaire</option>
                            <option value="expert">Expert</option>
                        </select>
                        <span class="text-danger" id="editLevelError"></span>
                    </div>

                    <!-- Nouveau champ Objectifs -->
                    <div class="mb-3">
                        <label for="editObjective" class="form-label">Objectifs de la formation</label>
                        <textarea class="form-control" id="editObjective" name="objective" rows="4"
                            placeholder="Modifier les objectifs de la formation" required></textarea>
                        <span class="text-danger" id="editObjectiveError"></span>
                    </div>

                    <div class="mb-3">
                        <label for="editPrice" class="form-label">Prix (FCFA)</label>
                        <input type="number" min="0" class="form-control" id="editPrice" name="price"
                            required>
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
<div class="modal fade" id="deleteFormationModal" tabindex="-1" aria-labelledby="deleteFormationModalLabel"
    aria-hidden="true">
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
<div class="modal fade" id="addModuleModal" tabindex="-1" aria-labelledby="addModuleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- En-tête du modal -->
            <div class="modal-header">
                <h5 class="modal-title" id="addModuleModalLabel">Ajouter un module</h5>
                <button type="button" class="modal-close" data-bs-dismiss="modal" aria-label="Fermer">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Formulaire -->
            <form id="addModuleForm" method="POST">
                @csrf
                <!-- Corps du modal -->
                <div class="modal-body">
                    <div id="ajaxAlert"></div>

                    <!-- Conteneur des modules -->
                    <div id="modulesContainer">
                        <!-- Module unique -->
                        <div class="module-item">
                            <div class="module-input-group">
                                <input type="text" name="titres[]" class="module-input"
                                    placeholder="Titre du module" required>
                                <button type="button" class="remove-module-btn" title="Supprimer ce module">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Bouton Ajouter -->
                    <button type="button" id="addModuleField" class="add-module-btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Ajouter un module
                    </button>
                </div>

                <!-- Pied du modal -->
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Description -->
<div class="modal fade" id="descriptionModal" tabindex="-1" aria-labelledby="descriptionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="descriptionModalLabel">Description de la formation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 id="formationTitle" class="text-dark mb-3"></h6>
                <div id="formationDescription"></div>
            </div>
        </div>
    </div>
</div>
