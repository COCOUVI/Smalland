<script>
    document.addEventListener('DOMContentLoaded', function() {

        // ===================== VOIR LEÇON =====================
        const lessonModal = document.getElementById('lessonModal');
        if (lessonModal) {
            lessonModal.addEventListener('show.bs.modal', function(event) {
                const btn = event.relatedTarget;
                const title = btn.dataset.lessonTitle;
                const video = btn.dataset.lessonVideo;
                const pdf = btn.dataset.lessonPdf;

                lessonModal.querySelector('#lessonTitle').textContent = title;
                lessonModal.querySelector('#lessonVideoContainer').innerHTML = video ?
                    `<video width="100%" height="400" controls>
                    <source src="${video}" type="video/mp4">
                    Votre navigateur ne supporte pas la vidéo.
                </video>` :
                    `<p class="text-muted">Aucune vidéo disponible.</p>`;

                lessonModal.querySelector('#lessonPdfContainer').innerHTML = pdf ?
                    `<a href="${pdf}" target="_blank" class="btn btn-outline-danger">
                    <i class="fas fa-file-pdf me-1"></i> Voir PDF
                </a>` :
                    `<p class="text-muted">Aucun PDF disponible.</p>`;
            });
        }

        // ===================== MODIFIER LEÇON =====================
        const editModalEl = document.getElementById('editLessonModal');
        const editForm = document.getElementById('editLessonForm');
        const alertBox = document.getElementById('editLessonAlert');

        if (editModalEl && editForm) {
            editModalEl.addEventListener('show.bs.modal', function(event) {
                const btn = event.relatedTarget;
                document.getElementById('editLessonId').value = btn.dataset.lessonId;
                document.getElementById('editTitre').value = btn.dataset.lessonTitle;

                const video = btn.dataset.lessonVideo;
                const pdf = btn.dataset.lessonPdf;

                document.getElementById('currentVideoPreview').innerHTML = video ?
                    `<video width="100%" height="200" controls>
                    <source src="${video}" type="video/mp4">
                </video>` :
                    `<p class="text-muted">Aucune vidéo disponible</p>`;

                document.getElementById('currentPdfPreview').innerHTML = pdf ?
                    `<a href="${pdf}" target="_blank" class="btn btn-outline-danger">
                    <i class="fas fa-file-pdf me-1"></i> Voir PDF
                </a>` :
                    `<p class="text-muted">Aucun PDF disponible</p>`;

                if (alertBox) alertBox.classList.add('d-none');
            });

            editForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const lessonId = document.getElementById('editLessonId').value;
                const formData = new FormData(editForm);
                formData.append('_method', 'PUT');

                fetch(`/dashboard/lessons/${lessonId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (!alertBox) return;
                        if (data.success) {
                            alertBox.className = 'alert alert-success';
                            alertBox.textContent = data.message;
                            alertBox.classList.remove('d-none');

                            const row = document.querySelector(
                                `button[data-lesson-id="${lessonId}"]`)?.closest('tr');
                            if (row) row.querySelector('td:nth-child(2)').textContent = data.lesson
                                .titre;
                        } else {
                            alertBox.className = 'alert alert-danger';
                            alertBox.textContent = 'Erreur lors de la mise à jour';
                            alertBox.classList.remove('d-none');
                        }
                    })
                    .catch(() => {
                        if (!alertBox) return;
                        alertBox.className = 'alert alert-danger';
                        alertBox.textContent = 'Erreur réseau';
                        alertBox.classList.remove('d-none');
                    });
            });
        }

        // ===================== SUPPRESSION LEÇON =====================
        let lessonIdToDelete = null;
        let deleteBtnRef = null;

        const confirmModalEl = document.getElementById('confirmDeleteModal');
        let confirmModal = null;
        if (confirmModalEl) confirmModal = new bootstrap.Modal(confirmModalEl);

        function getDeleteAlert() {
            return document.getElementById('deleteAlert');
        }

        // Ouvrir modal de suppression
        document.querySelectorAll('.btn-delete-lesson').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                lessonIdToDelete = this.dataset.lessonId;
                deleteBtnRef = this;
                if (confirmModal) confirmModal.show();
            });
        });

        // Fermer modal via Annuler ou X
        if (confirmModalEl) {
            const cancelBtn = confirmModalEl.querySelector('.btn-secondary');
            const closeBtn = confirmModalEl.querySelector('.btn-close');

            [cancelBtn, closeBtn].forEach(button => {
                if (button) {
                    button.addEventListener('click', function() {
                        if (confirmModal) confirmModal.hide();
                    });
                }
            });

            confirmModalEl.addEventListener('hidden.bs.modal', function() {
                lessonIdToDelete = null;
                deleteBtnRef = null;
            });
        }

        // Confirmer suppression
        const confirmBtn = document.getElementById('confirmDeleteBtn');
        if (confirmBtn) {
            confirmBtn.addEventListener('click', function() {
                if (!lessonIdToDelete) return;

                const formData = new FormData();
                formData.append('_method', 'DELETE');

                fetch(`/dashboard/lessons/${lessonIdToDelete}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        },
                        body: formData
                    })
                    .then(res => {
                        // Si Laravel renvoie une redirection, on ne peut pas parser en JSON
                        if (res.ok) {
                            return res.json().catch(() => ({
                                success: true,
                                message: 'Leçon supprimée !'
                            }));
                        } else {
                            throw new Error('Erreur réseau');
                        }
                    })
                    .then(data => {
                        const deleteAlert = getDeleteAlert();

                        if (data.success) {
                            deleteBtnRef?.closest('tr')?.remove();
                            deleteBtnRef?.closest('.card-lesson')?.remove();

                            if (deleteAlert) {
                                deleteAlert.className =
                                    'alert alert-success alert-dismissible fade show';
                                deleteAlert.innerHTML =
                                    `${data.message}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
                                deleteAlert.classList.remove('d-none');
                            }
                        } else {
                            if (deleteAlert) {
                                deleteAlert.className =
                                    'alert alert-danger alert-dismissible fade show';
                                deleteAlert.innerHTML =
                                    `Erreur lors de la suppression.<button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
                                deleteAlert.classList.remove('d-none');
                            }
                        }

                        lessonIdToDelete = null;
                        deleteBtnRef = null;
                        if (confirmModal) confirmModal.hide();
                    })
                    .catch(() => {
                        const deleteAlert = getDeleteAlert();
                        if (deleteAlert) {
                            deleteAlert.className =
                            'alert alert-danger alert-dismissible fade show';
                            deleteAlert.innerHTML =
                                `Erreur réseau.<button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
                            deleteAlert.classList.remove('d-none');
                        }
                        lessonIdToDelete = null;
                        deleteBtnRef = null;
                        if (confirmModal) confirmModal.hide();
                    });
            });

        }

        console.log('Script leçons chargé ✅');

    });
</script>
