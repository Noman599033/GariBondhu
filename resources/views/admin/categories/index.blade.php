@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold" data-i18n="cat_title">Car Categories</h2>
    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal"><i class="bi bi-plus-lg me-1"></i> <span data-i18n="cat_add_btn">Add Category</span></a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <form action="{{ route('admin.settings.categories.index') }}" method="GET" class="mb-4">
            <div class="input-group" style="max-width: 400px;">
                <input type="text" name="search" class="form-control" data-i18n-placeholder="cat_search_placeholder" placeholder="Search categories..." value="{{ $search ?? '' }}">
                <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                @if(isset($search) && $search !== '')
                    <a href="{{ route('admin.settings.categories.index') }}" class="btn btn-outline-secondary" data-i18n="cat_clear">Clear</a>
                @endif
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th data-i18n="cat_th_id">ID</th>
                        <th data-i18n="cat_th_name">Name</th>
                        <th data-i18n="cat_th_slug">Slug</th>
                        <th data-i18n="cat_th_sort">Sort Order</th>
                        <th data-i18n="cat_th_status">Status</th>
                        <th class="text-end" data-i18n="cat_th_actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td class="fw-bold">{{ $category->name }}</td>
                        <td><span class="text-muted">{{ $category->slug }}</span></td>
                        <td>{{ $category->sort_order }}</td>
                        <td>
                            @if($category->status === 'active')
                                <span class="badge bg-success" data-i18n="cat_status_active">Active</span>
                            @else
                                <span class="badge bg-warning text-dark" data-i18n="cat_status_inactive">Inactive</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $category->id }}"><i class="bi bi-pencil"></i></a>
                            
                            @if(!$category->cars()->exists())
                            <form action="{{ route('admin.settings.categories.destroy', $category) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                            @else
                            <button type="button" class="btn btn-sm btn-outline-secondary" disabled title="Cannot delete: Cars are assigned to this category"><i class="bi bi-trash"></i></button>
                            @endif
                        </td>
                    </tr>

                    <!-- Edit Category Modal -->
                    <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" aria-labelledby="editCategoryModalLabel{{ $category->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content text-start">
                                <form action="{{ route('admin.settings.categories.update', $category) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editCategoryModalLabel{{ $category->id }}" data-i18n="cat_edit_modal_title">Edit Category</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label" data-i18n="cat_modal_name">Category Name</label>
                                            <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" data-i18n="cat_modal_sort">Sort Order</label>
                                            <input type="number" name="sort_order" class="form-control" value="{{ $category->sort_order }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" data-i18n="cat_modal_status">Status</label>
                                            <select name="status" class="form-select" required>
                                                <option value="active" {{ $category->status == 'active' ? 'selected' : '' }} data-i18n="cat_status_active">Active</option>
                                                <option value="inactive" {{ $category->status == 'inactive' ? 'selected' : '' }} data-i18n="cat_status_inactive">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-i18n="cat_modal_close">Close</button>
                                        <button type="submit" class="btn btn-primary" data-i18n="cat_modal_save">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted" data-i18n="cat_no_categories">No car categories found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.settings.categories.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel" data-i18n="cat_add_modal_title">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" data-i18n="cat_modal_name">Category Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" data-i18n="cat_modal_sort">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" data-i18n="cat_modal_status">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="active" selected data-i18n="cat_status_active">Active</option>
                            <option value="inactive" data-i18n="cat_status_inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-i18n="cat_modal_close">Close</button>
                    <button type="submit" class="btn btn-primary" data-i18n="cat_modal_save_new">Save Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
