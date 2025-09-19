 <!-- Modal Voir -->
 <div class="modal fade" id="lessonModal" tabindex="-1" aria-hidden="true">
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header bg-info text-white">
                 <h5 class="modal-title">Détails de la leçon</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
             </div>
             <div class="modal-body">
                 <h4 id="lessonTitle"></h4>
                 <div id="lessonVideoContainer" class="mb-3"></div>
                 <div id="lessonPdfContainer"></div>
             </div>
         </div>
     </div>
 </div>

 <!-- Modal Modifier -->
 <div class="modal fade" id="editLessonModal" tabindex="-1" aria-hidden="true">
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header bg-warning text-white">
                 <h5 class="modal-title">Modifier la leçon</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
             </div>
             <div class="modal-body">
                 <div id="editLessonAlert" class="alert d-none"></div>
                 <form id="editLessonForm" enctype="multipart/form-data">
                     @csrf
                     @method('PUT')
                     <input type="hidden" id="editLessonId" name="id">

                     <div class="mb-3">
                         <label for="editTitre" class="form-label">Titre</label>
                         <input type="text" class="form-control" id="editTitre" name="titre">
                     </div>

                     <div class="mb-3">
                         <label class="form-label">Vidéo actuelle</label>
                         <div id="currentVideoPreview" class="mb-2"></div>
                         <input type="file" name="video_file" class="form-control">
                     </div>

                     <div class="mb-3">
                         <label class="form-label">PDF actuel</label>
                         <div id="currentPdfPreview" class="mb-2"></div>
                         <input type="file" name="pdf_file" class="form-control">
                     </div>

                     <button type="submit" class="btn btn-warning">Mettre à jour</button>
                 </form>
             </div>
         </div>
     </div>
 </div>

<!-- Modal Confirmation de suppression -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-danger">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="confirmDeleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i> Confirmation de suppression
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer cette leçon ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Annuler
                </button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    Supprimer
                </button>
            </div>
        </div>
    </div>
</div>