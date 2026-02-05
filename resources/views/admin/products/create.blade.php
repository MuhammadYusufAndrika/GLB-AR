@extends('admin.layouts.app')

@section('title', 'Add New Product')

@section('content')
<div class="page-header">
    <h1 class="page-title">Add New Product</h1>
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Back to Products
    </a>
</div>

<div class="card" style="max-width: 800px;">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="product_name" class="form-label">Product Name *</label>
            <input 
                type="text" 
                id="product_name" 
                name="product_name" 
                class="form-control" 
                value="{{ old('product_name') }}"
                placeholder="Enter product name"
                required
            >
            @error('product_name')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description" class="form-label">Description</label>
            <textarea 
                id="description" 
                name="description" 
                class="form-control" 
                placeholder="Enter product description"
                rows="4"
            >{{ old('description') }}</textarea>
            @error('description')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="category" class="form-label">Category</label>
            <input 
                type="text" 
                id="category" 
                name="category" 
                class="form-control" 
                value="{{ old('category') }}"
                placeholder="e.g., Electronics, Furniture, Fashion"
            >
            @error('category')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">3D Model File (.glb or .gltf) *</label>
            <div class="file-input-wrapper" id="model-drop-zone">
                <input 
                    type="file" 
                    id="model_file" 
                    name="model_file" 
                    accept=".glb,.gltf"
                    required
                >
                <div class="file-input-label" id="model-label">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color: var(--primary); margin-bottom: 0.5rem;">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                    </svg>
                    <p><strong>Click to upload</strong> or drag and drop</p>
                    <p style="font-size: 0.75rem;">GLB or GLTF (max 50MB)</p>
                </div>
            </div>
            @error('model_file')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Poster Image (Optional)</label>
            <div class="file-input-wrapper" id="poster-drop-zone">
                <input 
                    type="file" 
                    id="poster_file" 
                    name="poster_file" 
                    accept="image/jpeg,image/png,image/webp"
                >
                <div class="file-input-label" id="poster-label">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color: var(--primary); margin-bottom: 0.5rem;">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                        <polyline points="21 15 16 10 5 21"></polyline>
                    </svg>
                    <p><strong>Click to upload</strong> or drag and drop</p>
                    <p style="font-size: 0.75rem;">JPG, PNG, or WebP (max 5MB)</p>
                </div>
            </div>
            <div class="form-text">This image shows while the 3D model is loading.</div>
            @error('poster_file')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                    <polyline points="7 3 7 8 15 8"></polyline>
                </svg>
                Create Product
            </button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>

<script>
// File input label update
document.getElementById('model_file').addEventListener('change', function(e) {
    const label = document.getElementById('model-label');
    if (e.target.files.length > 0) {
        label.innerHTML = '<p style="color: var(--success);">✓ ' + e.target.files[0].name + '</p>';
    }
});

document.getElementById('poster_file').addEventListener('change', function(e) {
    const label = document.getElementById('poster-label');
    if (e.target.files.length > 0) {
        label.innerHTML = '<p style="color: var(--success);">✓ ' + e.target.files[0].name + '</p>';
    }
});
</script>
@endsection
