<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class DocumentController extends Controller
{
    /**
     * Allowed file types for upload.
     */
    protected $allowedTypes = [
        'pdf', 'doc', 'docx', 'ppt', 'pptx', 'zip'
    ];

    /**
     * Display a listing of all documents with search and filter.
     */
    public function index(Request $request)
    {
        $query = Document::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('course_code', 'like', "%{$search}%");
            });
        }

        // Filter by course code
        if ($request->filled('course_code')) {
            $query->where('course_code', $request->course_code);
        }

        // Get distinct course codes for filter dropdown
        $courseCodes = Document::select('course_code')
            ->distinct()
            ->orderBy('course_code')
            ->pluck('course_code');

        // Paginate results
        $documents = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('documents.index', compact('documents', 'courseCodes'));
    }

    /**
     * Show the form for creating a new document upload.
     */
    public function create()
    {
        return view('documents.create');
    }

    /**
     * Store a newly uploaded document in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'course_code' => 'required|string|max:50',
            'description' => 'nullable|string|max:1000',
            'file'        => 'required|file|mimes:pdf,doc,docx,ppt,pptx,zip|max:10240',
        ], [
            'file.required' => 'Please select a file to upload.',
            'file.mimes'    => 'Allowed file types are: PDF, DOC, DOCX, PPT, PPTX, ZIP.',
            'file.max'      => 'Maximum file size is 10MB.',
        ]);

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $fileSize = $file->getSize();
            $fileType = $file->getClientOriginalExtension();

            // Generate a unique filename to prevent overwrites
            $fileName = time() . '_' . str_replace(' ', '_', $originalName);
            $file->move(public_path('documents'), $fileName);
            $filePath = 'documents/' . $fileName;

            // Create document record
            Document::create([
                'title'       => $validated['title'],
                'course_code' => strtoupper($validated['course_code']),
                'description' => $validated['description'] ?? null,
                'file_name'   => $originalName,
                'file_path'   => $filePath,
                'file_size'   => $fileSize,
                'file_type'   => strtolower($fileType),
            ]);

            return redirect()->route('documents.index')
                ->with('success', 'Document uploaded successfully!');
        }

        return redirect()->back()
            ->with('error', 'Failed to upload document. Please try again.');
    }

    /**
     * Download the specified document.
     */
    // public function download($id)
    // {
    //     $document = Document::findOrFail($id);

    //     if (!Storage::disk('public')->exists($document->file_path)) {
    //         return redirect()->route('documents.index')
    //             ->with('error', 'File not found.');
    //     }

    //     return Storage::disk('public')->download($document->file_path, $document->file_name);
    // }

       public function download($id)
        {
            $document = Document::findOrFail($id);
        
            if (!Storage::disk('public')->exists($document->file_path)) {
                abort(404, 'File not found');
            }

            return Storage::disk('public')->download(
                $document->file_path,
                $document->file_name,
                [
                        'Content-Type' => Storage::disk('public')->mimeType($document->file_path),
                    ]
                );
            }



    /**
     * Remove the specified document from storage and database.
     */
    public function destroy($id)
    {
        $document = Document::findOrFail($id);

        // Delete file from storage
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        // Delete database record
        $document->delete();

        return redirect()->route('documents.index')
            ->with('success', 'Document deleted successfully!');
    }
}