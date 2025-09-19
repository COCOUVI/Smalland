<!-- Modal pour modifier un module -->
<div class="modal fade" id="editModuleModal" tabindex="-1" aria-labelledby="editModuleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModuleModalLabel">Modifier le module</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editModuleForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="moduleTitre" class="form-label">Titre du module <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="moduleTitre" name="titre" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de confirmation de suppression -->
<div class="modal fade" id="deleteModuleModal" tabindex="-1" aria-labelledby="deleteModuleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-1">
                <h5 class="modal-title text-danger" id="deleteModuleModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Confirmer la suppression
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <div class="text-center mb-3">
                    <i class="fas fa-trash-alt text-danger" style="font-size: 3rem; opacity: 0.7;"></i>
                </div>
                <p class="text-center fs-6">Êtes-vous sûr de vouloir supprimer le module :</p>
                <p class="text-center fw-bold fs-5 text-primary" id="moduleToDeleteTitle"></p>
                <div class="alert alert-warning border-0 bg-warning bg-opacity-10 text-warning-emphasis">
                    <i class="fas fa-info-circle me-2"></i>
                    Cette action est irréversible et supprimera définitivement ce module.
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Annuler
                </button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    <i class="fas fa-trash me-1"></i>Supprimer définitivement
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour ajouter une leçon -->
<div class="modal fade" id="addLessonModal" tabindex="-1" aria-labelledby="addLessonModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLessonModalLabel">Ajouter une leçon</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addLessonForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="lessonModuleId" name="module_id" value="">

                    <!-- Titre de la leçon -->
                    <div class="mb-4">
                        <label for="lessonTitle" class="form-label">
                            Titre de la leçon <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="lessonTitle" name="titre" required>
                        <div class="form-text">Donnez un titre descriptif à votre leçon</div>
                    </div>

                    <!-- Section Upload Vidéo -->
                    <div class="mb-4">
                        <label for="lessonVideo" class="form-label">
                            <i class="fas fa-video me-2 text-primary"></i>
                            Vidéo de la leçon <span class="text-danger">*</span>
                        </label>
                        <div class="upload-zone" id="videoUploadZone">
                            <input type="file" class="form-control" id="lessonVideo" name="video"
                                accept="video/*" style="display: none;">
                            <div class="upload-placeholder" onclick="document.getElementById('lessonVideo').click()">
                                <div class="upload-icon">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                </div>
                                <p class="mb-2"><strong>Cliquez pour sélectionner une vidéo</strong></p>
                                <p class="text-muted small">Formats acceptés: MP4, AVI, MOV, WMV (Max: 100MB)</p>
                            </div>
                            <div class="upload-preview" id="videoPreview" style="display: none;">
                                <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-file-video fa-2x text-primary me-3"></i>
                                        <div>
                                            <div class="fw-bold" id="videoFileName"></div>
                                            <div class="text-muted small" id="videoFileSize"></div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeVideo()">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <div class="progress mt-2" id="videoProgress" style="display: none;">
                                    <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section Upload PDF -->
                    <div class="mb-4">
                        <label for="lessonPdf" class="form-label">
                            <i class="fas fa-file-pdf me-2 text-danger"></i>
                            Document PDF <span class="text-muted">(optionnel)</span>
                        </label>
                        <div class="upload-zone" id="pdfUploadZone">
                            <input type="file" class="form-control" id="lessonPdf" name="pdf" accept=".pdf" style="display: none;">
                            <div class="upload-placeholder" onclick="document.getElementById('lessonPdf').click()">
                                <div class="upload-icon">
                                    <i class="fas fa-file-pdf fa-3x text-muted mb-3"></i>
                                </div>
                                <p class="mb-2"><strong>Cliquez pour sélectionner un PDF</strong></p>
                                <p class="text-muted small">Support de cours, exercices, etc. (Max: 10MB)</p>
                            </div>
                            <div class="upload-preview" id="pdfPreview" style="display: none;">
                                <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-file-pdf fa-2x text-danger me-3"></i>
                                        <div>
                                            <div class="fw-bold" id="pdfFileName"></div>
                                            <div class="text-muted small" id="pdfFileSize"></div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removePdf()">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <div class="progress mt-2" id="pdfProgress" style="display: none;">
                                    <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Aperçu du module -->
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Cette leçon sera ajoutée au module: <strong id="moduleNamePreview"></strong>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Annuler
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-plus me-1"></i>Ajouter la leçon
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
