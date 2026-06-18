@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">
                    <i class="bi bi-collection-fill me-2 text-primary"></i>
                    Course Materials
                </h2>
                <p class="text-muted mb-0">
                    Browse and download academic materials for your courses
                </p>
            </div>
            <a href="{{ route('documents.create') }}" class="btn btn-primary">
                <i class="bi bi-cloud-upload-fill me-1"></i>
                <span class="d-none d-sm-inline">Upload New</span>
            </a>
        </div>

        <!-- Search and Filter Card -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('documents.index') }}" method="GET">
                    <div class="row g-3 align-items-center">
                        <!-- Search -->
                        <div class="col-md-5">
                            <div class="search-box">
                                <i class="bi bi-search"></i>
                                <input type="text" 
                                       name="search" 
                                       class="form-control form-control-lg" 
                                       placeholder="Search by title or course code..." 
                                       value="{{ request('search') }}">
                            </div>
                        </div>

                        <!-- Filter -->
                        <div class="col-md-4">
                            <select name="course_code" class="form-select form-select-lg">
                                <option value="">All Course Codes</option>
                                @foreach($courseCodes as $code)
                                    <option value="{{ $code }}" {{ request('course_code') == $code ? 'selected' : '' }}>
                                        {{ $code }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="col-md-3">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-lg flex-fill">
                                    <i class="bi bi-funnel-fill me-1"></i> Filter
                                </button>
                                @if(request('search') || request('course_code'))
                                    <a href="{{ route('documents.index') }}" class="btn btn-outline-secondary btn-lg">
                                        <i class="bi bi-x-lg"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Documents List -->
        @if($documents->count() > 0)
            <div class="row">
                @foreach($documents as $document)
                    <div class="col-12 document-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <!-- File Icon -->
                                    <div class="col-auto">
                                        <i class="bi {{ $document->icon }} file-icon"></i>
                                    </div>

                                    <!-- Document Info -->
                                    <div class="col-md-4 col-12 mb-2 mb-md-0">
                                        <h5 class="fw-bold mb-1 text-truncate" title="{{ $document->title }}">
                                            {{ $document->title }}
                                        </h5>
                                        <div class="d-flex flex-wrap align-items-center gap-2">
                                            <span class="course-badge">
                                                <i class="bi bi-bookmark-fill me-1"></i>
                                                {{ $document->course_code }}
                                            </span>
                                            @if($document->description)
                                                <span class="text-muted small text-truncate d-inline-block" 
                                                      style="max-width: 200px;" 
                                                      title="{{ $document->description }}">
                                                    <i class="bi bi-chat-dots me-1"></i>
                                                    {{ $document->description }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- File Details -->
                                    <div class="col-md-3 col-6 mb-2 mb-md-0">
                                        <div class="d-flex flex-column">
                                            <small class="text-muted">
                                                <i class="bi bi-file-earmark me-1"></i>
                                                {{ strtoupper($document->file_type) }}
                                            </small>
                                            <small class="text-muted">
                                                <i class="bi bi-hdd me-1"></i>
                                                {{ $document->formatted_size }}
                                            </small>
                                            <small class="text-muted">
                                                <i class="bi bi-calendar3 me-1"></i>
                                                {{ $document->created_at->format('M d, Y') }}
                                            </small>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="col-md-3 col-6">
                                        <div class="d-flex gap-2 justify-content-md-end">
                                            <a href="{{ route('documents.download', $document->id) }}" 
                                               class="btn btn-success btn-sm flex-fill flex-md-grow-0">
                                                <i class="bi bi-download me-1"></i> Download
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-danger btn-sm flex-fill flex-md-grow-0"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteModal{{ $document->id }}">
                                                <i class="bi bi-trash3 me-1"></i> Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Confirmation Modal -->
                        <div class="modal fade" id="deleteModal{{ $document->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title fw-bold">
                                            <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>
                                            Confirm Delete
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="mb-0">
                                            Are you sure you want to delete 
                                            <strong>"{{ $document->title }}"</strong>?
                                            <br>
                                            <span class="text-danger">
                                                <small>
                                                    <i class="bi bi-info-circle me-1"></i>
                                                    This action cannot be undone. The file will be permanently removed.
                                                </small>
                                            </span>
                                        </p>
                                    </div>
                                    <div class="modal-footer border-0">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="bi bi-x-lg me-1"></i> Cancel
                                        </button>
                                        <form action="{{ route('documents.destroy', $document->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="bi bi-trash3 me-1"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $documents->withQueryString()->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="card">
                <div class="card-body empty-state">
                    <i class="bi bi-folder2-open"></i>
                    <h4 class="fw-bold text-muted mb-2">No Documents Found</h4>
                    <p class="text-muted mb-4">
                        @if(request('search') || request('course_code'))
                            No documents match your search criteria. Try different keywords or clear filters.
                        @else
                            There are no course materials uploaded yet. Be the first to upload!
                        @endif
                    </p>
                    @if(!request('search') && !request('course_code'))
                        <a href="{{ route('documents.create') }}" class="btn btn-primary btn-lg">
                            <i class="bi bi-cloud-upload-fill me-2"></i>
                            Upload First Document
                        </a>
                    @else
                        <a href="{{ route('documents.index') }}" class="btn btn-outline-primary btn-lg">
                            <i class="bi bi-arrow-left me-2"></i>
                            Clear Filters
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-dismiss alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
</script>
@endpush