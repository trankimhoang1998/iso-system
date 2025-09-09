<div class="admin-category-simple-item" style="margin-left: {{ $level * 30 }}px;">
    <div class="admin-category-simple-content">
        <div class="admin-category-simple-name">{{ $category->name }}</div>
        @if($category->description)
            <div class="admin-category-simple-description">{{ $category->description }}</div>
        @endif
    </div>
    <div class="admin-category-simple-actions">
        <a href="{{ route('admin.iso-directive-categories.edit', $category) }}" class="admin-btn admin-btn--small admin-btn--primary">
            <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
        </a>
        <form action="{{ route('admin.iso-directive-categories.destroy', $category) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="admin-btn admin-btn--small admin-btn--danger">
                <svg class="admin-btn__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        </form>
    </div>
</div>

@foreach($category->children as $child)
    @include('admin.iso-directive-categories.partials.category-item', ['category' => $child, 'level' => $level + 1])
@endforeach