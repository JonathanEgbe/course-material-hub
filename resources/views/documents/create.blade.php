@extends('layouts.app')

@section('title', 'Upload Document')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <!-- Header -->
        <div class="d-flex align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">
                    <i class="bi bi-cloud-upload-fill me-2 text-primary"></i>
                    Upload Document
                </h2>
                <p class="text-muted mb-0">
                    Share course materials with students by uploading files here
                </p>
            </div>
        </div>

        <!-- Upload Form -->
        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Document Title -->
                    <div class="mb-4">
                        <label for="title" class="form-label fw-semibold">
                            <i class="bi bi-bookmark me-1"></i>
                            Document Title <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control form-control-lg @error('title') is-invalid @enderror" 
                               id="title" 
                               name="title" 
                               value="{{ old('title') }}" 
                               placeholder="e.g., Introduction to Algorithms - Chapter 1"
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Course Code -->
                    <div class="mb-4">
                        <label for="course_code" class="form-label fw-semibold">
                            <i class="bi bi-book me-1"></i>
                            Course Code <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control form-control-lg @error('course_code') is-invalid @enderror" 
                               id="course_code" 
                               name="course_code" 
                               value="{{ old('course_code') }}" 
                               placeholder="e.g., CSE301, IFT302, MAT201"
                               required>
                        @error('course_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Enter the course code in uppercase (e.g., IFT302)
                        </small>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold">
                            <i class="bi bi-chat-dots me-1"></i>
                            Description <span class="text-muted">(Optional)</span>
                        </label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="3" 
                                  placeholder="Brief description of the document content...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- File Upload -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-file-earmark me-1"></i>
                            Upload File <span class="text-danger">*</span>
                        </label>
                        <div class="upload-area" id="uploadArea">
                            <i class="bi bi-cloud-arrow-up-fill"></i>
                            <h5 class="mt-3 fw-bold">Click to upload or drag and drop</h5>
                            <p class="text-muted mb-2">
                                Supported formats: PDF, DOC, DOCX, PPT, PPTX, ZIP
                            </p>
                            <p class="text-muted mb-0">
                                <small>Maximum file size: 10MB</small>
                            </p>
                            <input type="file" 
                                   class="d-none" 
                                   id="file" 
                                   name="file" 
                                   accept=".pdf,.doc,.docx,.ppt,.pptx,.zip" 
                                   required>
                        </div>
                        <div id="fileInfo" class="d-none mt-3">
                            <div class="alert alert-info mb-0">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-file-earmark-check-fill me-2 fs-4"></i>
                                    <div>
                                        <strong id="fileName" class="d-block"></strong>
                                        <small id="fileSize" class="text-muted"></small>
                                    </div>
                                    <button type="button" class="btn-close ms-auto" id="removeFile"></button>
                                </div>
                            </div>
                        </div>
                        @error('file')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Allowed File Types Info -->
                    <div class="mb-4">
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-danger"><i class="bi bi-filetype-pdf me-1"></i>PDF</span>
                            <span class="badge bg-primary"><i class="bi bi-filetype-doc me-1"></i>DOC</span>
                            <span class="badge bg-primary"><i class="bi bi-filetype-docx me-1"></i>DOCX</span>
                            <span class="badge bg-warning text-dark"><i class="bi bi-filetype-ppt me-1"></i>PPT</span>
                            <span class="badge bg-warning text-dark"><i class="bi bi-filetype-pptx me-1"></i>PPTX</span>
                            <span class="badge bg-secondary"><i class="bi bi-file-zip me-1"></i>ZIP</span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary btn-lg flex-fill">
                            <i class="bi bi-cloud-upload-fill me-2"></i>
                            Upload Document
                        </button>
                        <a href="{{ route('documents.index') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="bi bi-arrow-left me-1"></i>
                            Back
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const uploadArea = document.getElementById('uploadArea');
        const fileInput = document.getElementById('file');
        const fileInfo = document.getElementById('fileInfo');
        const fileName = document.getElementById('fileName');
        const fileSizeDisplay = document.getElementById('fileSize');
        const removeFileBtn = document.getElementById('removeFile');

        // Click to upload
        uploadArea.addEventListener('click', function() {
            fileInput.click();
        });

        // Drag and drop
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.style.borderColor = '#0d6efd';
            this.style.background = '#e7f1ff';
        });

        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.style.borderColor = '#dee2e6';
            this.style.background = '#f8f9fa';
        });

        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.style.borderColor = '#dee2e6';
            this.style.background = '#f8f9fa';
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                handleFileSelect(files[0]);
            }
        });

        // File input change
        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                handleFileSelect(this.files[0]);
            }
        });

        // Remove file
        removeFileBtn.addEventListener('click', function() {
            fileInput.value = '';
            fileInfo.classList.add('d-none');
            uploadArea.classList.remove('d-none');
        });

        function handleFileSelect(file) {
            const validTypes = [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-powerpoint',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'application/zip',
                'application/x-zip-compressed'
            ];

            const maxSize = 10 * 1024 * 1024; // 10MB

            if (!validTypes.includes(file.type) && !file.name.match(/\.(pdf|doc|docx|ppt|pptx|zip)$/i)) {
                alert('Invalid file type. Please upload PDF, DOC, DOCX, PPT, PPTX, or ZIP files only.');
                fileInput.value = '';
                return;
            }

            if (file.size > maxSize) {
                alert('File is too large. Maximum file size is 10MB.');
                fileInput.value = '';
                return;
            }

            fileName.textContent = file.name;
            fileSizeDisplay.textContent = formatFileSize(file.size);
            uploadArea.classList.add('d-none');
            fileInfo.classList.remove('d-none');
        }

        function formatFileSize(bytes) {
            const units = ['B', 'KB', 'MB', 'GB'];
            let size = bytes;
            let unitIndex = 0;
            
            while (size >= 1024 && unitIndex < units.length - 1) {
                size /= 1024;
                unitIndex++;
            }
            
            return size.toFixed(2) + ' ' + units[unitIndex];
        }
    });
</script>
@endpush